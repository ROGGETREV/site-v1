-- Created by nolanwhy, 2024
-- Steal if gay
game.Players:CreateLocalPlayer(0)
game.Players.LocalPlayer:LoadCharacter()
game:GetService("RunService"):Run()
while wait() do
    if game.Players.LocalPlayer.Character.Humanoid.Health == 0 or game.Players.LocalPlayer.Character.Parent == nil then
        wait(5)
        game.Players.LocalPlayer:LoadCharacter()
    end
end