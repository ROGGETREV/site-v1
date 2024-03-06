<?php error_reporting(0); ?>
local server = "127.0.0.1" 
local serverport = <?php echo (int)$_REQUEST["serverPort"] ?? 53640; ?>

local clientport = 0 
local playername = "Player <?php echo (int)random_int(1, 9999); ?>"
function dieerror(errmsg) 
game:SetMessage(errmsg) 
wait(math.huge) 
end 
local suc, err = pcall(function() 
client = game:GetService("NetworkClient") 
local player = game:GetService("Players"):CreateLocalPlayer(0) 
player:SetSuperSafeChat(false) 
pcall(function() game:GetService("Players"):SetChatStyle(Enum.ChatStyle.ClassicAndBubble) end) 
game:GetService("Visit") 
player.Name = playername
local funeeplayr = game.Players:FindFirstChild(playername)
game:ClearMessage() 
end) 
if not suc then 
dieerror(err) 
end 
if not suc then
   dieerror(err)
end
function connected(url, replicator)
   local suc, err = pcall(function()
   local marker = replicator:SendMarker()
   local received = false
    
    local function onWorldReceived()
        pcall(function()
            game:ClearMessage()
        end)
        received = true
    end
    
    marker.Received:connect(onWorldReceived)
    game:SetMessageBrickCount()
   end)
   if not suc then
      dieerror(err)
   end
   marker.Recieved:wait()
   local suc, err = pcall(function()
   game:ClearMessage()
   end)
   if not suc then
      dieerror(err)
   end
end
function rejected()
   dieerror("Connection failed: Rejected by server.")
end
function failed(peer, errcode, why)
   dieerror("Failed [".. peer.. " ], ".. errcode.. ": ".. why)
end
local suc, err = pcall(function()
client.ConnectionAccepted:connect(connected)
client.ConnectionRejected:connect(rejected)
client.ConnectionFailed:connect(failed)
client:Connect(server, serverport, clientport, 20)
end)
replicator.Disconnection:connect(disconnect)
local marker = nil
pcall(function()
game:SetMessageBrickCount()
marker = replicator:SendMarker()
end)
if not suc then
   local x = Instance.new("Message")
   x.Text = err
   x.Parent = workspace
   wait(math.huge)
end
while true do
   wait(0.001)
   replicator:SendMarker()
end