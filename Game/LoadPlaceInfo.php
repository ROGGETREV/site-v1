<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header('content-type: text/plain');
$defaultPlace = [
    "creator" => 0
];
if(!isset($_REQUEST["PlaceId"])) {
    $game = $defaultPlace;
}
$q = $con->prepare("SELECT * FROM games WHERE id = :id");
$q->bindParam(':id', $_REQUEST["PlaceId"], PDO::PARAM_INT);
$q->execute();
$game = $q->fetch();
if(!$game) {
    $game = $defaultPlace;
}
function sign($script, $key) {
    $signature = "";
    openssl_sign($script, $signature, $key, OPENSSL_ALGO_SHA1);
    return base64_encode($signature);
}

ob_start();
?>

-- Loaded by StartGameSharedScript --
pcall(function() game:SetCreatorID(<?php echo (int)$game["creator"]; ?>, Enum.CreatorType.User) end)

pcall(function() game:GetService("SocialService"):SetFriendUrl("http://assetgame.shitblx.cf/Game/LuaWebService/HandleSocialRequest.ashx?method=IsFriendsWith&playerid=%d&userid=%d") end)
pcall(function() game:GetService("SocialService"):SetBestFriendUrl("http://assetgame.shitblx.cf/Game/LuaWebService/HandleSocialRequest.ashx?method=IsBestFriendsWith&playerid=%d&userid=%d") end)
pcall(function() game:GetService("SocialService"):SetGroupUrl("http://assetgame.shitblx.cf/Game/LuaWebService/HandleSocialRequest.ashx?method=IsInGroup&playerid=%d&groupid=%d") end)
pcall(function() game:GetService("SocialService"):SetGroupRankUrl("http://assetgame.shitblx.cf/Game/LuaWebService/HandleSocialRequest.ashx?method=GetGroupRank&playerid=%d&groupid=%d") end)
pcall(function() game:GetService("SocialService"):SetGroupRoleUrl("http://assetgame.shitblx.cf/Game/LuaWebService/HandleSocialRequest.ashx?method=GetGroupRole&playerid=%d&groupid=%d") end)
pcall(function() game:GetService("GamePassService"):SetPlayerHasPassUrl("http://assetgame.shitblx.cf/Game/GamePass/GamePassHandler.ashx?Action=HasPass&UserID=%d&PassID=%d") end)
pcall(function() game:GetService("MarketplaceService"):SetProductInfoUrl("https://api.shitblx.cf/marketplace/productinfo?assetId=%d") end)
pcall(function() game:GetService("MarketplaceService"):SetDevProductInfoUrl("https://api.shitblx.cf/marketplace/productDetails?productId=%d") end)
pcall(function() game:GetService("MarketplaceService"):SetPlayerOwnsAssetUrl("https://api.shitblx.cf/ownership/hasasset?userId=%d&assetId=%d") end)
pcall(function() game:SetPlaceVersion(0) end)
pcall(function() game:SetVIPServerOwnerId(0) end)
<?php
$data = ob_get_clean();
$signature = sign("\r\n" . $data, $clientKeys["private"]);
exit("--rbxsig%". $signature . "%\r\n" . $data);
?>