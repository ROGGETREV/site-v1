<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
if(!isset($_REQUEST["username"])) exit("null");
$username = $_REQUEST["username"];

if($username === "[SERVER]") exit("http://shitblx.cf/images/logosmall.png");

$q = $con->prepare("SELECT * FROM users WHERE ((username = :username) OR (gameAuthentication = :username))");
$q->bindParam(':username', $username, PDO::PARAM_STR);
$q->execute();
$usr = $q->fetch();

if(!$usr) exit("null");

if($usr["username"] === "nolanwhy") exit("http://shitblx.cf/images/nolanwhite.png");
elseif($usr["permission"] === "Administrator") exit("http://shitblx.cf/images/logosmall.png");
else {
    if($usr["buildersclub"] === "None") exit;
    elseif($usr["buildersclub"] === "BuildersClub") exit("rbxasset://textures/ui/TinyBcIcon.png");
    elseif($usr["buildersclub"] === "TurboBuildersClub") exit("rbxasset://textures/ui/TinyTbcIcon.png");
    elseif($usr["buildersclub"] === "OutrageousBuildersClub") exit("rbxasset://textures/ui/TinyObcIcon.png");
}

echo "null";