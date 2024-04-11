<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header('Content-Type: application/json');

if(!$loggedin && !$guestEnabled || !isset($_REQUEST["game"])) exit;

if(!$loggedin && $guestEnabled) {
    $guestId = -1 * random_int(1, 9999);
    $user = [
        "id" => $guestId,
        "username" => "Guest ".$guestId,
        "buildersclub" => "None",
        "gameAuthentication" => "guest".$guestId
    ];
}
?>
authentication = "<?php echo addslashes($user["gameAuthentication"]); ?>"
username = "<?php echo addslashes($user["username"]); ?>"
userid = <?php echo (int)$user["id"]; ?>

--dofile("http://shitblx.cf/Game/2011/Cores/StarterScript.lua?authentication="..authentication)
function onPlayerAdded(player)
    -- override
end

game:GetService("ChangeHistoryService"):SetEnabled(false)
game:GetService("ContentProvider"):SetThreadPool(16)
game:GetService("InsertService"):SetBaseCategoryUrl("http://shitblx.cf/Game/Tools/InsertAsset.ashx?nsets=10&type=base")
game:GetService("InsertService"):SetUserCategoryUrl("http://shitblx.cf/Game/Tools/InsertAsset.ashx?nsets=20&type=user&userid=%d")
game:GetService("InsertService"):SetCollectionUrl("http://shitblx.cf/Game/Tools/InsertAsset.ashx?sid=%d")
game:GetService("InsertService"):SetAssetUrl("http://shitblx.cf/Asset/?id=%d")
game:GetService("InsertService"):SetAssetVersionUrl("http://shitblx.cf/Asset/?assetversionid=%d")
-- game:GetService("InsertService"):SetTrustLevel(0)
game:GetService("InsertService"):SetAdvancedResults(true)

pcall(function() game:GetService("Players"):SetChatStyle(Enum.ChatStyle.ClassicAndBubble) end)
local waitingForCharacter = false
pcall(function()
    if settings().Network.MtuOverride == 0 then
        settings().Network.MtuOverride = 1400
    end
end)

client = game:GetService("NetworkClient")
visit = game:GetService("Visit")

function setMessage(message)
    game:SetMessage(message)
end
function showErrorWindow(message)
    game:SetMessage(message)
end
function reportError(err)
    print("***ERROR*** " .. err)
    visit:SetUploadUrl("")
    client:Disconnect()
    wait(4)
    showErrorWindow("Error: " .. err)
end

function onDisconnection(peer, lostConnection)
    if lostConnection then
        showErrorWindow("You have lost the connection to the game")
    else
        if player.Name == username or player.Name == authentication then
            showErrorWindow("This game has shut down")
        else
            showErrorWindow("You have been kicked from the server. Reason: "..player.Name)
        end
    end
end

function requestCharacter(replicator)
    local connection
    connection = player.Changed:connect(function(property)
        if property == "Character" then
            game:ClearMessage()
            waitingForCharacter = false

            connection:disconnect()
        end
    end)

    setMessage("Requesting character")
    local success, err = pcall(function()  
        replicator:RequestCharacter()
        setMessage("Waiting for character")
        waitingForCharacter = true
    end)

    if not success then
        reportError(err)
        return
    end
end

function onConnectionAccepted(url, replicator)
    local waitingForMarker = true

    local success, err = pcall(function()  
        visit:SetPing("", 300)

        if not false then
            game:SetMessageBrickCount()
        else
            setMessage("Teleporting...")
        end
        replicator.Disconnection:connect(onDisconnection)

        local marker = replicator:SendMarker()

        marker.Received:connect(function()
            waitingForMarker = false
            requestCharacter(replicator)
        end)
    end)

    if not success then
        reportError(err)
        return
    end

    while waitingForMarker do
        workspace:ZoomToExtents()
        wait(0.5)
    end
end

function onConnectionFailed(_, error)
    showErrorWindow("Connection failed: ID "..error)
end

function onConnectionRejected()
    connectionFailed:disconnect()
    showErrorWindow("This game is not available. Please try another")
end

pcall(function() settings().Diagnostics:LegacyScriptMode() end)

local success, err = pcall(function() 
    game:SetRemoteBuildMode(true)

    setMessage("Connecting to server...")
    client.ConnectionAccepted:connect(onConnectionAccepted)
    client.ConnectionRejected:connect(onConnectionRejected)
    connectionFailed = client.ConnectionFailed:connect(onConnectionFailed)
    client.Ticket = authentication

    playerConnectSuccess, player = pcall(function() return client:PlayerConnect(userid, "90.78.85.2", 53640, 0, threadSleepTime) end)
    if not playerConnectSuccess then
        -- Old player connection scheme
        player = game:GetService("Players"):CreateLocalPlayer(userid)
        client:Connect("90.78.85.2", 53640, 0, threadSleepTime)
    end
    player:SetSuperSafeChat(<?php if(!str_starts_with($user["gameAuthentication"], "guest")) echo "false"; else echo "true"; ?>)
    player:SetMembershipType(Enum.MembershipType.<?php echo $user["buildersclub"]; ?>)
    player:SetAccountAge(365)

    onPlayerAdded(player)

    player.Name = authentication
    visit:SetUploadUrl("")
end)
if not success then
    reportError(err)
end
pcall(function() game:SetScreenshotInfo("") end)
pcall(function() game:SetVideoInfo("") end)