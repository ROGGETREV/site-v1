ROGGETAPIkey = "EHbKaHdKKrWlRfxneJkbEUWo9vZVLE64"

gameId = 1

Port = 53640

Server = game:GetService("NetworkServer")

function randint()
    return (math.random() * 99999999) + #game.Workspace:GetChildren() * #game.Players:GetChildren() * (math.random() * 99999999)
end

function kickPlayer(player, reason)
	name = player.Name
	player.Name = reason
	wait(0.1)
    game.NetworkServer:findFirstChild(name.."|"..player.userId):CloseConnection()
    print("Player '" .. name .. "' Kicked. Reason: "..reason)
    -- print("Tried kicking player but 2011E fucking SUCKS ASS MAN")
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
game:service("Players").PlayerAdded:connect(function(player)
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
    
	pcall(function() dofile("http://shitblx.cf/Game/AuthenticationCheck.ashx?authentication="..player.Name.."&game="..gameId.."&apiKey="..ROGGETAPIkey.."&"..randint()) end)

    print("Renaming Connection...")
    pcall(function()
        for i, v in pairs(game.NetworkServer:GetChildren()) do
            if(not string.find(v.Name, "|")) then
                v.Name = player.Name.."|"..player.userId
            end
        end
    end)

    player.CharacterAppearance = "http://shitblx.cf/Game/CharacterFetch.ashx?ID="..player.userId.."&game="..gameId
	
	print("Loading character...")
	characterRessurection(player)

	player.Changed:connect(function(name)
		if name=="Character" then
			characterRessurection(player)
		end
	end)
end)

game.Players.PlayerAdded:connect(function(player)
    count = #game.Players:GetChildren()
    print("Contacting ROGGET API to set the player count to "..count)
    game:httpGet("http://shitblx.cf/Game/SetPlayerCount.ashx?count="..count.."&game="..gameId.."&apiKey="..ROGGETAPIkey.."&"..randint())
end)

game.Players.PlayerRemoving:connect(function(player)
    count = #game.Players:GetChildren() - 1
    print("Contacting ROGGET API to set the player count to "..count)
    game:httpGet("http://shitblx.cf/Game/SetPlayerCount.ashx?count="..count.."&game="..gameId.."&apiKey="..ROGGETAPIkey.."&"..randint())
end)

Server:Start(Port, 10)

game:Load("http://shitblx.cf/test.rbxl")

game:GetService("RunService"):Run()

print("ROGGET 2011E server started!")