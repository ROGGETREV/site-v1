game:SetMessage("")
 
dofile("http://shitblx.cf/Game/Cores/StarterScript.lua")
-- functions --------------------------
function onPlayerAdded(player)
  -- override
end
-- arguments ---------------------------------------

game:GetService("ChangeHistoryService"):SetEnabled(false)
game:GetService("ContentProvider"):SetThreadPool(16)
game:GetService("InsertService"):SetBaseCategoryUrl("http://shitblx.cf/Game/Tools/InsertAsset.php?nsets=10&type=base")
game:GetService("InsertService"):SetUserCategoryUrl("http://shitblx.cf/Game/Tools/InsertAsset.php?nsets=20&type=user&userid=%d")
game:GetService("InsertService"):SetCollectionUrl("http://shitblx.cf/Game/Tools/InsertAsset.php?sid=%d")
game:GetService("InsertService"):SetAssetUrl("http://shitblx.cf/Asset/?id=%d")
game:GetService("InsertService"):SetAssetVersionUrl("http://shitblx.cf/Asset/?assetversionid=%d")
-- game:GetService("InsertService"):SetTrustLevel(0)
game:GetService("InsertService"):SetAdvancedResults(true)

-- Bubble chat.  This is all-encapsulated to allow us to turn it off with a config setting
pcall(function() game:GetService("Players"):SetChatStyle(Enum.ChatStyle.ClassicAndBubble) end)
local waitingForCharacter = false
pcall( function()
  if settings().Network.MtuOverride == 0 then
    settings().Network.MtuOverride = 1400
  end
end)
-- globals -----------------------------------------
client = game:GetService("NetworkClient")
visit = game:GetService("Visit")
-- functions ---------------------------------------
function setMessage(message)
  -- todo: animated "..."
  if not false then
    game:SetMessage(message)
  else
    -- hack, good enought for now
    game:SetMessage("Teleporting ...")
  end
end
function showErrorWindow(message)
  game:SetMessage(message)
end
function reportError(err)
  print("***ERROR*** " .. err)
  if not test then visit:SetUploadUrl("") end
  client:Disconnect()
  wait(4)
  showErrorWindow("Error: " .. err)
end
-- called when the client connection closes
function onDisconnection(peer, lostConnection)
  if lostConnection then
    showErrorWindow("You have lost the connection to the game")
  else
    showErrorWindow("This game has shut down")
  end
end
function requestCharacter(replicator)
  
  -- prepare code for when the Character appears
  local connection
  connection = player.Changed:connect(function (property)
    if property=="Character" then
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
-- called when the client connection is established
function onConnectionAccepted(url, replicator)
  local waitingForMarker = true
  
  local success, err = pcall(function()  
    if not test then 
        visit:SetPing("", 300) 
    end
    
    if not false then
      game:SetMessageBrickCount()
    else
      setMessage("Teleporting ...")
    end
    replicator.Disconnection:connect(onDisconnection)
    
    -- Wait for a marker to return before creating the Player
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
  
  -- TODO: report marker progress
  
  while waitingForMarker do
    workspace:ZoomToExtents()
    wait(0.5)
  end
end
-- called when the client connection fails
function onConnectionFailed(_, error)
  showErrorWindow("connection failed! get fucked (ID=" .. error .. ")")
end
-- called when the client connection is rejected
function onConnectionRejected()
  connectionFailed:disconnect()
  showErrorWindow("This game is not available. Please try another")
end

-- main ------------------------------------------------------------
pcall(function() settings().Diagnostics:LegacyScriptMode() end)
local success, err = pcall(function()  
  game:SetRemoteBuildMode(true)
  
  setMessage("Welcome, nolanwhy! Connecting...")
  client.ConnectionAccepted:connect(onConnectionAccepted)
  client.ConnectionRejected:connect(onConnectionRejected)
  connectionFailed = client.ConnectionFailed:connect(onConnectionFailed)
  client.Ticket = ""

  playerConnectSucces, player = pcall(function() return client:PlayerConnect(67, "127.0.0.1", 53640, 0, threadSleepTime) end)
  if not playerConnectSucces then
    --Old player connection scheme
    player = game:GetService("Players"):CreateLocalPlayer(67)
    client:Connect("127.0.0.1", 53640, 0, threadSleepTime)
  end
  --player.CharacterAppearance = "http://shitblx.cf/Game/CharacterFetch.ashx?ID=67"
  player:SetSuperSafeChat(false)
  pcall(function() player:SetMembershipType(Enum.MembershipType.OutrageousBuildersClub) end)
  pcall(function() player:SetAccountAge(300) end)
  player.Idled:connect(onPlayerIdled)
  -- Overriden
  onPlayerAdded(player)
  
  pcall(function() player.Name = [========[nolanwhyfrfr]========] end)  
  if not test then visit:SetUploadUrl("") end
end)
if not success then
  reportError(err)
end
if not test then
  -- TODO: Async get?
  loadfile("")("", -1, 0)
end
pcall(function() game:SetScreenshotInfo("") end)
pcall(function() game:SetVideoInfo("") end)
-- use single quotes here because the video info string may have unescaped double quotes