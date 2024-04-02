<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
if(!isRoggetIP($_SERVER["REMOTE_ADDR"])) exit("print(\"Sorry, your IP is not whitelisted from ROGGET's internal APIs.\");");
?>
ROGGETAPIkey = "EHbKaHdKKrWlRfxneJkbEUWo9vZVLE64"

gameId = 1

Port = 53640

Server = game:GetService("NetworkServer")

ChatNotifier = true

function randint()
    return (math.random() * 99999999) + #game.Workspace:GetChildren() * #game.Players:GetChildren() * (math.random() * 99999999)
end

function kickPlayer(player, reason)
	name = player.Name
	player.Name = reason
	wait(1)
    pcall(function() game.NetworkServer:findFirstChild(name.."|"..player.userId):CloseConnection() end)
    pcall(function() player.Name = name end)
	print("Player '" .. name .. "' Kicked. Reason: "..reason)
end

function waitForChild(parent, childName)
	while true do
		local child = parent:findFirstChild(childName)
		if child then
			return child
		end
		parent.ChildAdded:wait()
	end
end

function getKillerOfHumanoidIfStillInGame(humanoid)
	local tag = humanoid:findFirstChild("creator")

	if tag then
		local killer = tag.Value
		if killer.Parent then
			return killer
		end
	end

	return nil
end

function onDied(victim, humanoid)
	local killer = getKillerOfHumanoidIfStillInGame(humanoid)

	local victorId = 0
	if killer then
		victorId = killer.userId
		print("STAT: kill by " .. victorId .. " of " .. victim.userId)
		game:httpGet("http://www.shitblx.cf/Game/Statistics.ashx?TypeID=15&UserID=" .. victorId .. "&AssociatedUserID=" .. victim.userId .. "&AssociatedPlaceID=0")
	end
	print("STAT: death of " .. victim.userId .. " by " .. victorId)
	game:httpGet("http://www.shitblx.cf/Game/Statistics.ashx?TypeID=16&UserID=" .. victim.userId .. "&AssociatedUserID=" .. victorId .. "&AssociatedPlaceID=0")
end

function createDeathMonitor(player)
	if player.Character then
		local humanoid = waitForChild(player.Character, "Humanoid")
		humanoid.Died:connect(
			function ()
				onDied(player, humanoid)
			end
		)
	end
end

game:service("Players").ChildAdded:connect(
	function (player)
		createDeathMonitor(player)
		player.Changed:connect(
			function (property)
				if property=="Character" then
					createDeathMonitor(player)
				end
			end
		)
	end
)

function characterRessurection(player)
	if player.Character then
		local humanoid = player.Character.Humanoid
		humanoid.Died:connect(function() wait(5) player:LoadCharacter() end)
	end
end

function splitString(inputstr, sep)
	if sep == nil then
			sep = "%s"
	end
	local t={}
	for str in string.gmatch(inputstr, "([^"..sep.."]+)") do
			table.insert(t, str)
	end
	return t
end

game:service("Players").PlayerAdded:connect(function(player)
	authenticated = Instance.new("BoolValue", player)
	authenticated.Name = "Authenticated"
	authenticated.Value = false
	if player.Name == "Player" then
		wait(0.3)
	end
	if player.Name == "ServerChatNotifier-"..ROGGETAPIkey then
		authenticated.Value = true
		player.Name = "[SERVER]"
	else
		print("Player joined with authentication: "..player.Name)

		print("Running authentication check script...")

		print("Renaming Connection...")
		pcall(function()
			for i, v in pairs(game.NetworkServer:GetChildren()) do
				if(not string.find(v.Name, "|")) then
					v.Name = player.Name.."|"..player.userId
				end
			end
		end)
		
		authCheck = splitString(game:httpGetAsync("http://shitblx.cf/Game/AuthenticationCheck.ashx?authentication="..player.Name.."&game="..gameId.."&apiKey="..ROGGETAPIkey.."&"..randint()), ";");

		if(authCheck[1] == "false") then
			kickPlayer(player, "Authentication check failed")
		else
			authenticated.Value = true
			player.userId = authCheck[2]
			player.Name = authCheck[3]
			player.CharacterAppearance = authCheck[4]

			print("Renaming Connection...")
			pcall(function()
				for i, v in pairs(game.NetworkServer:GetChildren()) do
					if(not string.find(v.Name, "|")) then
						v.Name = player.Name.."|"..player.userId
					end
				end
			end)

			if ChatNotifier then
				game.Players:Chat("Player joined: "..player.Name);
			end

			print("Loading character...")
			characterRessurection(player)

			player.Changed:connect(function(name)
				if name == "Character" then
					characterRessurection(player)
				end
			end)
		end
	end
end)

game.Players.PlayerAdded:connect(function(player)
    count = #game.Players:GetChildren()
	if ChatNotifier then count = count - 1 end
    print("Contacting ROGGET API to set the player count to "..count)
    game:httpGet("http://shitblx.cf/Game/SetPlayerCount.ashx?count="..count.."&game="..gameId.."&apiKey="..ROGGETAPIkey.."&"..randint())
	--player.Chatted:connect(function(msg)
	--	game:httpGet("http://shitblx.cf/Game/2011/Chat.ashx?text="..msg)
	--end)
end)

game.Players.PlayerRemoving:connect(function(player)
    count = #game.Players:GetChildren() - 1
	if ChatNotifier then count = count - 1 end
    print("Contacting ROGGET API to set the player count to "..count)
    game:httpGet("http://shitblx.cf/Game/SetPlayerCount.ashx?count="..count.."&game="..gameId.."&apiKey="..ROGGETAPIkey.."&"..randint())
	if player.Authenticated.Value == true and ChatNotifier then
		game.Players:Chat("Player left: "..player.Name);
	end
end)

game:Load("http://shitblx.cf/ironcafe.rbxl")

game:GetService("RunService"):Run()

if ChatNotifier then
	game.Players:CreateLocalPlayer(-1)
	game.Players.LocalPlayer.Name = "ServerChatNotifier-"..ROGGETAPIkey
else
	game:httpGet("http://shitblx.cf/Game/SetPlayerCount.ashx?count=0&game="..gameId.."&apiKey="..ROGGETAPIkey.."&"..randint())
end

Server:Start(Port, 10)

print("ROGGET 2011E server started!")