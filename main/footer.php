<?php if(!str_contains($_SERVER["HTTP_USER_AGENT"], "ROBLOX Android App")) { ?>
<div style="width: 100%;height: 100px;bottom: 0;"></div>
<div style="position: fixed;background-color: var(--bs-tertiary-bg);width: 100%;height: 100px;bottom: 0;">
    <div style="position: absolute;top: 9px;left: 9px;width: 100%;" class="d-flex">
        <img src="/images/sigmacell/<?php if($siteTheme === "dark") echo "white"; else echo "dark"; ?>_small.png" style="height: 80px;cursor: pointer;" onerror='this.src = "/images/loaderror.png";' onclick='let voice = new Audio("/audio/SigmacellVoiceByYomi.mp3");voice.play();this.style.animation = "loadingClientAnim 0.7s ease-in-out";this.addEventListener("animationend", () => this.style.animation = null);'>
        <h4 style="top: 0px;position: absolute;left: 94px;">© Sigmacell, <?php echo (int)date("Y"); ?>.</h4>
        <h6 style="top: 31px;position: absolute;left: 94px;"><a href="https://sigmacell.boomlings.xyz">Sigmacell Website</a> - <a href="https://discord.gg/7h2k2DGFcF">Discord Server</a></h6>
        <span style="top: 52px;position: absolute;left: 94px;">We are not affiliated with ROBLOX Corporation.</span>
    </div>
</div>
<?php } ?>