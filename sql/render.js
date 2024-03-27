import robot from "robotjs";
import { exec } from 'child_process';
import { cwd } from 'process';
import { join } from 'path';
import Jimp from "jimp";
import { readFileSync } from "fs";

// Config
let domain = "https://shitblx.cf";
let apikey = "GarO0NaSHC5IW42q9i4wrhhwZV6GpXTz";
let renderFile = "RoggetRenderer.exe";
let fullscreenProperly = false;

// Code
var mouse = robot.getMousePos();

let sleep=ms=>{return new Promise((resolve)=>{setTimeout(()=>{resolve();},ms);})};

function screenshot(robotScreenPic, path) {
    return new Promise((resolve, reject) => {
        try {
            const image = new Jimp(robotScreenPic.width, robotScreenPic.height);
            let pos = 0;
            image.scan(0, 0, image.bitmap.width, image.bitmap.height, (x, y, idx) => {
                const r = robotScreenPic.image.readUInt8(pos++);
                const g = robotScreenPic.image.readUInt8(pos++);
                const b = robotScreenPic.image.readUInt8(pos++);
                const a = robotScreenPic.image.readUInt8(pos++);

                const tolerance = 10;
                if (Math.abs(r - 0) < tolerance && Math.abs(g - 255) < tolerance && Math.abs(b - 1) < tolerance) {
                    image.bitmap.data[idx + 3] = 0;
                } else {
                    image.bitmap.data[idx + 2] = r;
                    image.bitmap.data[idx + 1] = g;
                    image.bitmap.data[idx + 0] = b;
                    image.bitmap.data[idx + 3] = a;
                }
            });
            image.write(path, resolve);
        } catch (err) {
            console.error(err);
            reject(err);
        }
    });
}

function moveMouse(x, y) {
    robot.moveMouse(x, y);
    console.log("[ACTION] Moved mouse to x" + x + " y" + y);
}

function mouseClick() {
    robot.mouseClick();
    console.log("[ACTION] Left clicked mouse");
}

function keyTap(key) {
    robot.keyTap(key);
    console.log("[ACTION] Tapped key \"" + key + "\"");
}

function getPixelColor(x, y) {
    let color = robot.getPixelColor(x, y);
    // console.log("[DETECT] Detected color at x" + x + " y" + y + ": #" + color);
    return color;
}

async function ImageModelServerView() {
    if(fullscreenProperly) {
        moveMouse(32, 36);
        mouseClick();
        await sleep(500);
        moveMouse(103, 58);
        mouseClick();
        moveMouse(0, 0);
    } else {
        moveMouse(460, 244);
        mouseClick();
        await sleep(500);
        moveMouse(488, 265);
        mouseClick();
        moveMouse(0, 0);
    }
}

async function CloseRenderer() {
    /*return new Promise(async (resolve, reject) => {
        /*moveMouse(1894, 10);
        mouseClick();
        await sleep(500);
        moveMouse(965, 572);
        mouseClick();/
        let interval = setInterval(async () => {
            if(getPixelColor(960, 496) === "ffffff") {
                clearInterval(interval);
                await sleep(200);
                keyTap("right");
                await sleep(200);
                keyTap("enter");
                resolve();
            } else {
                moveMouse(1894, 10);
                mouseClick();
            }
        }, 100);
    });*/
    exec('taskkill /f /im ' + renderFile);
}

async function waitForRobloxStart() {
    return new Promise(async (resolve, reject) => {
        let interval = setInterval(async () => {
            let x = 60;
            let y = 220;
            if(!fullscreenProperly) {
                x = 440;
                y = 589;
            }
            if(getPixelColor(x, y) === "00ff01") {
                clearInterval(interval);
                clearTimeout(timeout);
                resolve();
            }
        }, 100);
        let timeout = setTimeout(async () => {
            console.log("Looks like Roblox is stuck. Skipping render...");
            exec('taskkill /f /im ' + renderFile);
            process.exit();
        }, 15000);
    });
}

async function postImage(id, type, b64) {
    const req = await fetch(domain + "/Api/RenderQueue.ashx?type=set&remote=" + id + "&renderType=" + type + "&apiKey=" + apikey, {
        method: "POST",
        body: b64
    });
    console.log("[FETCH] Got response: " + await req.text());
    return true;
}

function checkRDP() {
    return true;
    return new Promise(async (resolve, reject) => {
        exec('C:\\Windows\\System32\\query.exe session', (error, stdout, stderr) => {
            if (error) {
                console.log(error);
                resolve(false);
                return;
            }
            if (stderr) {
                resolve(false);
                return;
            }

            const lines = stdout.split('\n');
            for (let i = 1; i < lines.length; i++) {
                const columns = lines[i].split(/\s+/);
                if (columns[2] === 'rdp-tcp') {
                    resolve(true);
                    return;
                }
            }
            resolve(false);
        });
    });
}

async function render(id, type, client, renderid) {
    moveMouse(0, 0);
    console.log("[RENDER] Doing render for " + type + " with id " + id.toString());
    let args = "-script \"dofile('" + domain + "/Api/RenderQueue.ashx?type=scriptget&apiKey=" + apikey + "&id=" + renderid.toString() + "')\"";
    exec(join(cwd(), renderFile) + " " + args, (err, stdout, stderr) => {
        if(err) {
            console.error("Error rendering: " + err);
            return;
        }
    });
    console.log("[RENDER] Waiting for Roblox to start...");
    await waitForRobloxStart();
    console.log("[RENDER] Sleeping 2.5 seconds...");
    await sleep(2200);
    console.log("[RENDER] Putting thumbnail view...");
    await ImageModelServerView();
    console.log("[RENDER] Screenshotting...");
    if(fullscreenProperly) await screenshot(robot.screen.capture(502, 123, 700, 820), join(cwd(), 'render.png'));
    if(!fullscreenProperly) await screenshot(robot.screen.capture(610, 331, 477, 477), join(cwd(), 'render.png'));
    console.log("[RENDER] Closing renderer...");
    await CloseRenderer();
    console.log("[RENDER] Uploading...");
    await postImage(id, type, Buffer.from(await readFileSync(join(cwd(), 'render.png'))).toString("base64"));
    moveMouse(0, 0);
    console.log("[RENDER] Finished Rendering!");
}

while(true) {
    if(!await checkRDP()) {
        console.error("[RDP FAIL] Nobody is connected to RDP. Closing all renders and RenderServer.");
        exec('taskkill /f /im ' + renderFile);
        process.exit();
    }
    const req = await fetch(domain + "/Api/RenderQueue.ashx?type=get&apiKey=" + apikey);
    const res = await req.json();
    if(res.render) await render(res.render.remote, res.render.type, res.render.client, res.render.id);
    await sleep(1000);
}