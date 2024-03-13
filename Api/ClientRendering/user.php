<?php error_reporting(0); ?>
pcall(function() game.GuiRoot.MainMenu:remove() end)
pcall(function() game.GuiRoot.RightPalette:remove() end)
pcall(function() game.GuiRoot.ScoreHud:remove() end)
pcall(function() game.CoreGui.RobloxGui:remove() end)
local plr = game.Players:CreateLocalPlayer(0)
plr.CharacterAppearance = "http://shitblx.cf/Game/CharacterFetch.ashx?userId=<?php echo (int)$_REQUEST["ID"]; ?>"
plr:LoadCharacter()