ROGGETAPIkey = "EHbKaHdKKrWlRfxneJkbEUWo9vZVLE64"

gameId = 1

Port = 53640

Server = game:GetService("NetworkServer")

Server:Start(Port, 20)

game:Load("http://shitblx.cf/test.rbxl")

game:GetService("RunService"):Run()

print("ROGGET 2010L server started!")

function randint()
    return (math.random() * 99999999) + #game.Workspace:GetChildren() * #game.Players:GetChildren() * (math.random() * 99999999)
end

function kickPlayer(player, reason)
    --game.NetworkServer:findFirstChild(player.Name.."|"..player.userId):CloseConnection()
    --print("Player '" .. player.Name .. "' Kicked. Reason: "..reason)
    print("Tried kicking player but 2010L fucking SUCKS ASS MAN")
end

game.Players.PlayerAdded:connect(function(player)
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
	
	-- pcall(function() dofile("http://shitblx.cf/Game/AuthenticationCheck.ashx?authentication="..player.Name.."&game="..gameId.."&apiKey="..ROGGETAPIkey.."&"..randint()) end)

	if(authCheck[1] == "false") then
		kickPlayer(player, "Authentication check failed")
	else
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

	    -- player.CharacterAppearance = "http://shitblx.cf/Game/CharacterFetch.ashx?userId="..player.userId.."&game="..gameId.."&noredir"

        print("Loading character...")
        pcall(function() player:LoadCharacter() end)
    
        while wait() do
            if player.Character.Humanoid.Health == 0 or player.Character.Parent == nil then
                wait(5)
                player:LoadCharacter()
            end
        end
	end
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