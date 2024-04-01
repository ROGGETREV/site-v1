<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header('Content-Type: application/json');

if(!$loggedin) exit;
$randomConnections = [
    "Welcome, {username}! We are connecting you to the game...",
    "Chicken nuggets? {username} is not a chicken nugget.",
    "ROGGET will never ask you for your password.",
    "Passwords are like toothbrushes, don't share 'em!",
    "Not a GOODBLOX shitvival!",
    "GroovyDominoes52 GOODBLOX Gameplay? More like {username} ROGGET Gameplay.",
    "game.Players.{username}.Cool = true",
    "Thank god {username} didn't choose to play MADBLOX!",
    "I play Pokemon GO everyday!"
];
?>

client = game:GetService("NetworkClient") -- needs to be at the top, just in case

local serverhost = "127.0.0.1"
local serverport = 53640
local authentication = "<?php echo addslashes($user["gameAuthentication"]); ?>"
local username = "<?php echo addslashes($user["username"]); ?>"

function exit(msg)
    game:SetMessage(msg)
    wait(math.huge)
end

pcall(function() game:GetService("Players"):SetChatFilterUrl("http://shitblx.cf/Game/ChatFilter.ashx?ID="..userId) end)
pcall(function() game:GetService("ContentFilter"):SetFilterUrl("http://shitblx.cf/Game/ChatFilter.ashx?ID="..userId) end)

local success, error = pcall(function()
    local player = game:GetService("Players"):CreateLocalPlayer(0)
    player:SetSuperSafeChat(false)
    pcall(function() game:GetService("Players"):SetChatStyle(Enum.ChatStyle.ClassicAndBubble) end)
    game:GetService("Visit")
    player.Name = authentication
    game:SetMessage("<?php echo str_replace("{username}", "\"..username..\"", $randomConnections[array_rand($randomConnections)]); ?>")
end)

if not success then
    exit(error)
end

function connected(url, replicator)
    local success, error = pcall(function()
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

    if not success then
        exit(error)
    end
    
    marker.Received:wait()

    local success, error = pcall(function()
        game:ClearMessage()
    end)

    if not success then
        exit(error)
    end
end

function rejected()
    exit("ROGGET has detected you were using the wrong client. Please re-install and try again.")
end

function failed(peer, errcode, reason)
    exit("Connection failed: ID "..errcode.." ("..reason..")")
end

local success, error = pcall(function()
    client.ConnectionAccepted:connect(connected)
    client.ConnectionRejected:connect(rejected)
    client.ConnectionFailed:connect(failed)
    client:Connect(serverhost, serverport, 0, 20)
end)

replicator.Disconnection:connect(disconnect)

local marker = nil

pcall(function()
    game:SetMessageBrickCount()
    marker = replicator:SendMarker()
end)

if not success then
    local x = Instance.new("Message")
    x.Text = error
    x.Parent = game.Workspace
    wait(math.huge)
end

while true do
    wait(0.001)
    replicator:SendMarker()
end