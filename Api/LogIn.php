<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/main/reCAPTCHA.php");
header('Content-Type: application/json');

$captcha = false;
if(isset($_REQUEST["g-recaptcha-response"])) {
    $response = $reCAPTCHA->verifyResponse($_SERVER["REMOTE_ADDR"], $_REQUEST["g-recaptcha-response"]);
    if($response && $response->success) $captcha = true;
}
if(!$captcha) exit(json_encode(["success"=>false,"problem"=>"captcha","message"=>"Please complete the captcha"]));

if(!isset($_REQUEST["username"])) {
    exit(json_encode(["success"=>false,"problem"=>"username","message"=>"must be at least 3 characters"]));
}
$username = $_REQUEST["username"];
if(strlen($username) < 3) {
    exit(json_encode(["success"=>false,"problem"=>"username","message"=>"must be at least 3 characters"]));
}
if(strlen($username) > 20) {
    exit(json_encode(["success"=>false,"problem"=>"username","message"=>"must be less than 20 characters"]));
}

if(!isset($_REQUEST["password"])) {
    exit(json_encode(["success"=>false,"problem"=>"password","message"=>"must be at least 8 characters"]));
}
$password = $_REQUEST["password"];
if(strlen($password) < 8) {
    exit(json_encode(["success"=>false,"problem"=>"password","message"=>"must be at least 8 characters"]));
}

$q = $con->prepare("SELECT * FROM users WHERE username = :username");
$q->bindParam(':username', $_REQUEST["username"], PDO::PARAM_STR);
$q->execute();
$usr = $q->fetch();
if(!$usr) {
    exit(json_encode(["success"=>false,"problem"=>"username","message"=>"isn't correct"]));
}

if(!password_verify($password, $usr["password"])) {
    exit(json_encode(["success"=>false,"problem"=>"password","message"=>"isn't correct"]));
}

$time = time();
$sessKey = bin2hex(random_bytes(100));
$encryptIP = hash("sha512", $_SERVER["REMOTE_ADDR"]);

$q = $con->prepare("INSERT INTO `sessions` (`id`, `sessKey`, `userId`, `ip`, `userAgent`, `created`) VALUES (NULL, :sessKey, :id, :ip, :ua, :time)");
$q->bindParam(':sessKey', $sessKey, PDO::PARAM_STR);
$q->bindParam(':id', $usr["id"], PDO::PARAM_INT);
$q->bindParam(':ip', $encryptIP, PDO::PARAM_STR);
$q->bindParam(':ua', $_SERVER["HTTP_USER_AGENT"], PDO::PARAM_STR);
$q->bindParam(':time', $time, PDO::PARAM_INT);
$q->execute();

echo json_encode(["success"=>true,"authentication"=>$sessKey]);