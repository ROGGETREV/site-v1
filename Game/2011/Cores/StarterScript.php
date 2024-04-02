-- Creates all neccessary scripts for the gui on initial load, everything except build tools
-- Created by Ben T. 10/29/10
-- Please note that these are loaded in a specific order to diminish errors/perceived load time by user

delay(0, function()

local function waitForChild(instance, name)
	while not instance:FindFirstChild(name) do
		instance.ChildAdded:wait()
	end
end
local function waitForProperty(instance, property)
	while not instance[property] do
		instance.Changed:wait()
	end
end

waitForChild(game:GetService("CoreGui"),"RobloxGui")
local screenGui = game:GetService("CoreGui"):FindFirstChild("RobloxGui")

local scriptContext = game:GetService("ScriptContext")

-- Resizer (dynamically resizes gui)
dofile("http://shitblx.cf/Game/2011/Cores/Resizer.lua?<?php echo addslashes($_SERVER["QUERY_STRING"]); ?>")

-- SubMenuBuilder (builds out the material,surface and color panels)
dofile("http://shitblx.cf/Game/2011/Cores/SubMenuBuilder.lua?<?php echo addslashes($_SERVER["QUERY_STRING"]); ?>")

-- ToolTipper  (creates tool tips for gui)
dofile("http://shitblx.cf/Game/2011/Cores/ToolTipper.lua?<?php echo addslashes($_SERVER["QUERY_STRING"]); ?>")

--[[-- (controls the movement and selection of sub panels)
-- PaintMenuMover
scriptContext:AddCoreScript(36040464,screenGui.BuildTools.Frame.PropertyTools.PaintTool,"PaintMenuMover")
-- MaterialMenuMover
scriptContext:AddCoreScript(36040495,screenGui.BuildTools.Frame.PropertyTools.MaterialSelector,"MaterialMenuMover")
-- InputMenuMover
scriptContext:AddCoreScript(36040483,screenGui.BuildTools.Frame.PropertyTools.InputSelector,"InputMenuMover")]]--

-- SettingsScript 
dofile("http://shitblx.cf/Game/2011/Cores/SettingsScript.lua?<?php echo addslashes($_SERVER["QUERY_STRING"]); ?>")

-- MainChatScript
dofile("http://shitblx.cf/Game/2011/Cores/MainBotChatScript.lua?<?php echo addslashes($_SERVER["QUERY_STRING"]); ?>")

-- PlayerlistScript
--dofile("http://shitblx.cf/Game/2011/Cores/PlayerlistScript.lua?<?php echo addslashes($_SERVER["QUERY_STRING"]); ?>")

end)
