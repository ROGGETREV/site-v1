<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
if(!$loggedin || !isset($_REQUEST["code"]) || empty($_REQUEST["code"])) {
    header('location: /');
    exit;
}
if((int)$user["discord_verified"] === 1) {
    header('location: /Home.aspx');
    exit;
}
$code = $_REQUEST["code"];

$ch = curl_init("https://discord.com/api/oauth2/token");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    "grant_type" => "authorization_code",
    "code" => $code,
    "redirect_uri" => "http://shitblx.cf/Api/DiscordVerification.ashx"
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [ "Content-Type: application/x-www-form-urlencoded" ]);
curl_setopt($ch, CURLOPT_USERPWD, $discord["clientid"].":".$discord["clientsecret"]);

$res = json_decode(curl_exec($ch), true);

if(curl_errno($ch)){
    exit("Sorry, could not access Discord's servers: ".curl_error($ch));
}

curl_close($ch);

if(isset($res["error"])) exit("Sorry, Discord couldn't complete the verification: ".$res["error_description"]);
// $scopes = explode(" ", $res["scope"]);
if($res["scope"] !== "guilds identify" && $res["scope"] !== "identify guilds") exit("Sorry, ROGGET couldn't complete the verification: The scope Discord gave us didn't have guilds or identify.");

$resUser = getDiscordUserInfoFromAccessToken($res["access_token"]);

$q = $con->prepare("SELECT * FROM users WHERE discord_verified = true AND discord_id = :did");
$q->bindParam(':did', $resUser["id"], PDO::PARAM_INT);
$q->execute();
if($q->fetch()) exit("Sorry, ROGGET couldn't complete the verification: This Discord account was already used on another ROGGET account.");

$guilds = getDiscordServersFromAccessToken($res["access_token"]);
$joinedROGGET = false;
foreach($guilds as $server) {
    if($server["id"] == $discord["serverid"]) $joinedROGGET = true;
}
if(!$joinedROGGET) exit("Sorry, ROGGET couldn't complete the verification: This Discord account did not join the ROGGET server.");

$expires = time() + $res["expires_in"];
$q = $con->prepare("UPDATE users SET discord_verified = true, discord_id = :did, discord_access_token = :atoken, discord_refresh_token = :rtoken, discord_expires_in = :expire WHERE id = :id");
$q->bindParam(':did', $resUser["id"], PDO::PARAM_INT);
$q->bindParam(':atoken', $res["access_token"], PDO::PARAM_STR);
$q->bindParam(':rtoken', $res["refresh_token"], PDO::PARAM_STR);
$q->bindParam(':expire', $expires, PDO::PARAM_INT);
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->execute();
header('location: /Home.aspx');