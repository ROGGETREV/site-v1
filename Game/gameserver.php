Port = 53640

Server = game:GetService("NetworkServer")

HostService = game:GetService("RunService")

Server:Start(Port,20)

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