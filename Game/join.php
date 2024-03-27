<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header('Content-Type: application/json');

function sign($script, $key) {
    $signature = "";
    openssl_sign($script, $signature, $key, OPENSSL_ALGO_SHA1);
    return base64_encode($signature);
}

function generateClientTicket($id, $name, $charapp, $jobid, $privatekey) {
    $ticket = $id . "\n" . $jobid . "\n" . date('n\/j\/Y\ g\:i\:s\ A');
    openssl_sign($ticket, $sig, $privatekey, OPENSSL_ALGO_SHA1);
    $sig = base64_encode($sig);
    $ticket2 = $id . "\n" . $name . "\n" . $charapp . "\n". $jobid . "\n" . date('n\/j\/Y\ g\:i\:s\ A');
    openssl_sign($ticket2, $sig2, $privatekey, OPENSSL_ALGO_SHA1);
    $sig2 = base64_encode($sig2);
    $final = date('n\/j\/Y\ g\:i\:s\ A') . ";" . $sig2 . ";" . $sig;
    return($final);
}

$userID = 0;
if(isset($_REQUEST["UserID"])) $userID = (int)$_REQUEST["UserID"];

$port = 53640;
if(isset($_REQUEST["serverPort"])) $port = (int)$_REQUEST["serverPort"];

$joinscript = [
    "ClientPort" => 0,
    "MachineAddress" => "127.0.0.1",
    "ServerPort" => $port,
    "PingUrl" => "",
    "PingInterval" => 20,
    "UserName" => "Player",
    "SeleniumTestMode" => true,
    "UserId" => $userID,
    "GameChatType" => "AllUsers",
    "SuperSafeChat" => false, // FUCKING HELL
    "CharacterAppearance" => "http://www.shitblx.cf/v1.1/avatar-fetch/?placeId=0&userId=".(int)$userID,
    "ClientTicket" => generateClientTicket($userID, "Player", "http://www.shitblx.cf/v1.1/avatar-fetch/?placeId=0&userId=".(int)$userID, "00000000-0000-0000-0000-000000000000", $clientKeys["private"]),
    "GameId" => "00000000-0000-0000-0000-000000000000",
    "PlaceId" => 1,
    "MeasurementUrl" => "",
    "WaitingForCharacterGuid" => "",
    "BaseUrl" => "http://www.shitblx.cf/",
    "ChatStyle" => "ClassicAndBubble",
    "VendorId" => "0",
    "ScreenShotInfo" => "",
    "VideoInfo" => "",
    "CreatorId" => 2,
    "CreatorTypeEnum" => "User",
    "MembershipType" => "None",
    "AccountAge" => 3000000,
    "CookieStoreFirstTimePlayKey" => "rbx_evt_ftp",
    "CookieStoreFiveMinutePlayKey" => "rbx_evt_fmp",
    "CookieStoreEnabled" => true,
    "IsRobloxPlace" => true,
    "GenerateTeleportJoin" => false,
    "IsUnknownOrUnder13" => false,
    "SessionId" => "",
    "DataCenterId" => 0,
    "UniverseId" => 1,
    "BrowserTrackerId" => 0,
    "UsePortraitMode" => false,
    "FollowUserId" => 0
];

$data = json_encode($joinscript, JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
$signature = sign("\r\n" . $data, $clientKeys["private"]);
exit("--rbxsig%". $signature . "%\r\n" . $data);