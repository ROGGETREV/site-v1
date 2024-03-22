<?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
$rcc = new Roblox\Grid\Rcc\RCCServiceSoap("127.0.0.1", 8542);
echo "HW: ".$rcc->HelloWorld();
echo "<br>";
echo "Version: ".$rcc->GetVersion()."<br>";
/*echo "<img src='data:image/png;base64,".$rcc->OpenJobEx("Testt", new Roblox\Grid\Rcc\ScriptExecution("Testt-Script", json_encode([
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
])))."'>";*/
// echo $rcc->OpenJobEx("TestServer1", new Roblox\Grid\Rcc\ScriptExecution("TestServer1-Script", 'print("response:"..game:HttpGetAsync("https://shitblx.cf/test.rbxl"))'));
echo $rcc->OpenJobEx("TestServer1", new Roblox\Grid\Rcc\ScriptExecution("TestServer1-Script", '
placeId = 1
port = 8542
url = "http://shitblx.cf/"
------------------- UTILITY FUNCTIONS --------------------------


function waitForChild(parent, childName)
	while true do
		local child = parent:findFirstChild(childName)
		if child then
			return child
		end
		parent.ChildAdded:wait()
	end
end

-----------------------------------END UTILITY FUNCTIONS -------------------------

-----------------------------------"CUSTOM" SHARED CODE----------------------------------

pcall(function() settings().Network.UseInstancePacketCache = true end)
pcall(function() settings().Network.UsePhysicsPacketCache = true end)
--pcall(function() settings()["Task Scheduler"].PriorityMethod = Enum.PriorityMethod.FIFO end)
pcall(function() settings()["Task Scheduler"].PriorityMethod = Enum.PriorityMethod.AccumulatedError end)

--settings().Network.PhysicsSend = 1 -- 1==RoundRobin
--settings().Network.PhysicsSend = Enum.PhysicsSendMethod.ErrorComputation2
settings().Network.PhysicsSend = Enum.PhysicsSendMethod.TopNErrors
settings().Network.ExperimentalPhysicsEnabled = true
settings().Network.WaitingForCharacterLogRate = 100
pcall(function() settings().Diagnostics:LegacyScriptMode() end)

-----------------------------------START GAME SHARED SCRIPT------------------------------

local assetId = placeId -- might be able to remove this now

local scriptContext = game:GetService(\'ScriptContext\')
pcall(function() scriptContext:AddStarterScript(37801172) end)
scriptContext.ScriptsDisabled = true

game:SetPlaceID(assetId, false)
game:GetService("ChangeHistoryService"):SetEnabled(false)

-- establish this peer as the Server
local ns = game:GetService("NetworkServer")

if url~=nil then
	pcall(function() game:GetService("Players"):SetAbuseReportUrl(url .. "/AbuseReport/InGameChatHandler.ashx") end)
	pcall(function() game:GetService("ScriptInformationProvider"):SetAssetUrl(url .. "/Asset/") end)
	pcall(function() game:GetService("ContentProvider"):SetBaseUrl(url .. "/") end)
	pcall(function() game:GetService("Players"):SetChatFilterUrl(url .. "/Game/ChatFilter.ashx") end)

	game:GetService("BadgeService"):SetPlaceId(placeId)

	game:GetService("BadgeService"):SetIsBadgeLegalUrl("")
	game:GetService("InsertService"):SetBaseSetsUrl(url .. "/Game/Tools/InsertAsset.ashx?nsets=10&type=base")
	game:GetService("InsertService"):SetUserSetsUrl(url .. "/Game/Tools/InsertAsset.ashx?nsets=20&type=user&userid=%d")
	game:GetService("InsertService"):SetCollectionUrl(url .. "/Game/Tools/InsertAsset.ashx?sid=%d")
	game:GetService("InsertService"):SetAssetUrl(url .. "/Asset/?id=%d")
	game:GetService("InsertService"):SetAssetVersionUrl(url .. "/Asset/?assetversionid=%d")
	
	pcall(function() loadfile(url .. "/Game/LoadPlaceInfo.ashx?PlaceId=" .. placeId)() end)
	
	-- pcall(function() 
	--			if access then
	--				loadfile(url .. "/Game/PlaceSpecificScript.ashx?PlaceId=" .. placeId .. "&" .. access)()
	--			end
	--		end)
end

pcall(function() game:GetService("NetworkServer"):SetIsPlayerAuthenticationRequired(true) end)
settings().Diagnostics.LuaRamLimit = 0
--settings().Network:SetThroughputSensitivity(0.08, 0.01)
--settings().Network.SendRate = 35
--settings().Network.PhysicsSend = 0  -- 1==RoundRobin


game:GetService("Players").PlayerAdded:connect(function(player)
	print("Player " .. player.userId .. " added")
end)

game:GetService("Players").PlayerRemoving:connect(function(player)
	print("Player " .. player.userId .. " leaving")
end)

if placeId~=nil and url~=nil then
	-- yield so that file load happens in the heartbeat thread
	wait()
	
	-- load the game
	--game:Load(url .. "/asset/?id=" .. placeId)
	game:Load("http://shitblx.cf/Asset/?id=niggaaaaaaaaaa&town.rbxl")
end

-- Now start the connection
ns:Start(53640) 


scriptContext:SetTimeout(10)
scriptContext.ScriptsDisabled = false



------------------------------END START GAME SHARED SCRIPT--------------------------



-- StartGame -- 
game:GetService("RunService"):Run()
'));
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