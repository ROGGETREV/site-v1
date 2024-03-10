pcall(function() game:SetPlaceID(-1, false) end)
pcall(function() game:GetService("Players"):SetChatStyle(Enum.ChatStyle.ClassicAndBubble) end)

pcall(function()
	game:GetService("GuiService").Changed:connect(function()
		pcall(function() game:GetService("GuiService").ShowLegacyPlayerList = true end)
		pcall(function() game.CoreGui.RobloxGui.PlayerListScript:Remove() end)
		pcall(function() game.CoreGui.RobloxGui.PlayerListTopRightFrame:Remove() end)
		pcall(function() game.CoreGui.RobloxGui.BigPlayerListWindowImposter:Remove() end)
		pcall(function() game.CoreGui.RobloxGui.BigPlayerlist:Remove() end)
	end)
end)
game:GetService("RunService"):Run()
local Visit, NetworkClient, PlayerSuccess, Player, ConnectionFailedHook = game:GetService("Visit"), game:GetService("NetworkClient")

	local function GetClassCount(Class,Parent)
		local Objects = Parent:GetChildren()
		local Number = 0
		for Index,Object in pairs(Objects) do
			if (Object.className==Class) then
				Number = Number+1
			end
			Number = Number + GetClassCount(Class,Object)
		end
		return Number
	end

	local function RequestCharacter(Replicator)
		local Connection
		Connection=Player.Changed:connect(function(Property)
			if (Property=="Character") then
				game:ClearMessage()
			end
		end)
		SetMessage("Requesting character...")
		Replicator:RequestCharacter()
		SetMessage("Waiting for character...")
	end

	local function Disconnection(Peer,LostConnection)
		SetMessage("You have lost connection to the game")
	end

	local function ConnectionAccepted(Peer,Replicator)
		Replicator.Disconnection:connect(Disconnection)
		local RequestingMarker=true
		game:SetMessageBrickCount()
		local Marker=Replicator:SendMarker()
		Marker.Received:connect(function()
			RequestingMarker=false
			RequestCharacter(Replicator)
		end)
		while RequestingMarker do
			Workspace:ZoomToExtents()
			wait(0.5)
		end
	end

	local function ConnectionFailed(Peer, Code, why)
		SetMessage("Failed to connect to the Game. (ID="..Code..")")
	end

	pcall(function() settings().Diagnostics:LegacyScriptMode() end)
	pcall(function() game:SetRemoteBuildMode(true) end)
	SetMessage("Connecting to server...")
	NetworkClient.ConnectionAccepted:connect(ConnectionAccepted)
	ConnectionFailedHook=NetworkClient.ConnectionFailed:connect(ConnectionFailed)
	NetworkClient.ConnectionRejected:connect(function()
		pcall(function() ConnectionFailedHook:disconnect() end)
		SetMessage("Failed to connect to the Game. (Connection rejected)")
	end)

	pcall(function() NetworkClient.Ticket=Ticket or "" end) -- 2008 client has no ticket :O
	PlayerSuccess,Player=pcall(function() return NetworkClient:PlayerConnect(UserID,ServerIP,ServerPort) end)

	if (not PlayerSuccess) then
		SetMessage("Failed to connect to the Game. (Invalid IP Address)")
		NetworkClient:Disconnect()
	end

	if (not PlayerSuccess) then
		local Error,Message=pcall(function()
			Player=game:GetService("Players"):CreateLocalPlayer(UserID)
			NetworkClient:Connect(ServerIP,ServerPort)
		end)
		if (not Error) then
			SetMessage("Failed to connect to the Game.")
		end
	end
	
	pcall(function() Player.Name=PlayerName or "" end)
	pcall(function() Player:SetUnder13(false) end)
	pcall(function() Player:SetAccountAge(365) end)
	Player:SetSuperSafeChat(false)
	Player.CharacterAppearance=0
if (IconType == "BC") then
	Player:SetMembershipType(Enum.MembershipType.BuildersClub)
elseif (IconType == "TBC") then
	Player:SetMembershipType(Enum.MembershipType.TurboBuildersClub)
elseif  (IconType == "OBC") then
	Player:SetMembershipType(Enum.MembershipType.OutrageousBuildersClub)
elseif  (IconType == "NBC" or string.match(IconType, "http") == "http") then
	Player:SetMembershipType(Enum.MembershipType.None)
end

pcall(function() Visit:SetUploadUrl("") end)