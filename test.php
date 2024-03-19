<?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
$rcc = new Roblox\Grid\Rcc\RCCServiceSoap("127.0.0.1", 8543);
echo "HW: ".$rcc->HelloWorld();
echo "<br>";
echo "Version: ".$rcc->GetVersion();
$rcc->OpenJobEx("Test", [
    "Mode" => "Thumbnail",
    "Settings" => [
        "Type" => "Closeup",
        "PlaceId" => 1,
        "UserId" => 5,
        "BaseUrl" => "shitblx.cf",
        "MatchmakingContextId" => 1,
        "Arguments" => ["https://www.shitblx.cf/", "https://www.shitblx.cf/Game/CharacterFetch.ashx?userId=2", "PNG", 768, 768, true]
    ],
    "Arguments"=> [
        "MachineAddress"=> "127.0.0.1"
    ]
]);
/*$script = 'print("e");

Port = 53640

Server = game:GetService("NetworkServer")

HostService = game:GetService("RunService")

Server:Start(Port,20)

game:Load("test.rbxl")

game:GetService("RunService"):Run()

print("Rowritten server started!")

function onJoined(NewPlayer)
    print("Player joined: "..NewPlayer.Name.."")
    print("Checking for account code...")
    --check = game:httpGet("http://local.madblxx.tk/api/checkAccountCode?code="..NewPlayer.Name.."&apikey=")
    check = "e"
    if check == "#cant-join" then
        NewPlayer:remove()
    else
        --NewPlayer.Name = check
        NewPlayer:LoadCharacter()
        while wait() do
            if NewPlayer.Character.Humanoid.Health == 0 then
                wait(5)
                NewPlayer:LoadCharacter()
            elseif NewPlayer.Character.Parent == nil then
                wait(5)
                NewPlayer:LoadCharacter()
            end
        end
    end
end

game.Players.PlayerAdded:connect(onJoined)

game.Players.PlayerAdded:connect(function(PlayerAdded)
    count = #game.Players:GetPlayers()
    game:httpGet("http://madblxx.tk/api/setplayers?gameid=1&count="..count)
end)

game.Players.PlayerRemoving:connect(function(PlayerRemoved)
    count = #game.Players:GetPlayers()
    game:httpGet("http://madblxx.tk/api/setplayers?gameid=1&count="..count)
end)';
$rcc->BatchJobEx("test", $script);*/
/*$script = '
--game:Load("http://shitblx.cf/test.rbxl")
game.Players:CreateLocalPlayer(0)
game.Players.LocalPlayer:LoadCharacter()
bodyColors = Instance.new("BodyColors", game.Players.LocalPlayer) --.Character
bodyColors.HeadColor = BrickColor.new(25)
bodyColors.LeftArmColor = BrickColor.new(25)
bodyColors.RightArmColor = BrickColor.new(25)
bodyColors.LeftLegColor = BrickColor.new(25)
bodyColors.RightLegColor = BrickColor.new(25)
bodyColors.TorsoColor = BrickColor.new(25)

return game:GetService("ThumbnailGenerator"):Click("PNG", 720, 720, true)';

$scriptt = '
Port = 53640

Server = game:GetService("NetworkServer")

HostService = game:GetService("RunService")

Server:Start(Port,20)

game:Load("http://shitblx.cf/test.rbxl")

game:GetService("RunService"):Run()

print("Rowritten server started!")

function onJoined(NewPlayer)
    print("Player joined: "..NewPlayer.Name)
    NewPlayer:LoadCharacter()
    while wait() do
        if NewPlayer.Character.Humanoid.Health == 0 then
            wait(5)
            NewPlayer:LoadCharacter()
        elseif NewPlayer.Character.Parent == nil then
            wait(5)
            NewPlayer:LoadCharacter()
        end
    end
end

game.Players.PlayerAdded:connect(onJoined)
';

$xml = '<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:ns2="http://shitblx.cf/RCCServiceSoap" xmlns:ns1="http://shitblx.cf/" xmlns:ns3="http://shitblx.cf/RCCServiceSoap12">
    <SOAP-ENV:Body>
        <ns1:OpenJob>
            <ns1:job>
                <ns1:id>69</ns1:id>
                <ns1:expirationInSeconds>0.00000000000000000000000000000000001</ns1:expirationInSeconds>
                <ns1:category>1</ns1:category>
                <ns1:cores>321</ns1:cores>
            </ns1:job>
            <ns1:script>
                <ns1:name>Script</ns1:name>
                <ns1:script>
                    '.$script.'
                </ns1:script>
            </ns1:script>
        </ns1:OpenJob>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>';

$shit = json_encode([
    "Mode" => "Thumbnail",
    "Settings" => [
        "Type" => "Closeup",
        "PlaceId" => 1,
        "UserId" => 5,
        "BaseUrl" => "shitblx.cf",
        "MatchmakingContextId" => 1,
        "Arguments" => ["https://www.shitblx.cf/", "https://www.shitblx.cf/Game/CharacterFetch.ashx?userId=2", "PNG", 768, 768, true]
    ],
    "Arguments"=> [
        "MachineAddress"=> "127.0.0.1"
    ]
]);

$ch = curl_init("127.0.0.1:8543");
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $shit);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);

if(curl_errno($ch)) exit("Failed to connect to the RCCService.");

curl_close($ch);

$res = str_replace(["LUA_TTABLE", "LUA_TSTRING"], "", $res);

$res = strstr($res, "<ns1:value>");

$res = str_replace(
    ["<ns1:value>", "</ns1:value></ns1:OpenJobResult><ns1:OpenJobResult><ns1:type></ns1:type><ns1:table></ns1:table></ns1:OpenJobResult></ns1:OpenJobResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>"],
    "",
    $res
);

$decoded = base64_decode($res);
file_put_contents("test.png",$decoded);*/