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
if(strlen($username) > 16) {
    exit(json_encode(["success"=>false,"problem"=>"username","message"=>"must be less than 16 characters"]));
}
if(!preg_match('/^[A-Za-z0-9_]*$/', $username)) {
    exit(json_encode(["success"=>false,"problem"=>"username","message"=>"must have only the alphabet, numbers or _"]));
}

if(!isset($_REQUEST["password"])) {
    exit(json_encode(["success"=>false,"problem"=>"password","message"=>"must be at least 8 characters"]));
}
$password = $_REQUEST["password"];
if(strlen($password) < 8) {
    exit(json_encode(["success"=>false,"problem"=>"password","message"=>"must be at least 8 characters"]));
}

if($enableInviteKeys) {
    if(!isset($_REQUEST["invitekey"])) {
        exit(json_encode(["success"=>false,"problem"=>"invitekey","message"=>"must be at least 5 characters"]));
    }
    $invitekey = $_REQUEST["invitekey"];
    if(strlen($invitekey) < 5) {
        exit(json_encode(["success"=>false,"problem"=>"invitekey","message"=>"must be at least 5 characters"]));
    }
}

$q = $con->prepare("SELECT * FROM users WHERE username = :username");
$q->bindParam(':username', $_REQUEST["username"], PDO::PARAM_STR);
$q->execute();
$usr = $q->fetch();
if($usr) {
    exit(json_encode(["success"=>false,"problem"=>"username","message"=>"is already taken"]));
}

if($enableInviteKeys) {
    $q = $con->prepare("SELECT * FROM invitekeys WHERE invitekey = :ikey");
    $q->bindParam(':ikey', $invitekey, PDO::PARAM_STR);
    $q->execute();
    $key = $q->fetch();
    if(!$key) {
        exit(json_encode(["success"=>false,"problem"=>"invitekey","message"=>"does not exist"]));
    }
    if($key["used"] === 1) {
        exit(json_encode(["success"=>false,"problem"=>"invitekey","message"=>"is already used"]));
    }

    $q = $con->prepare("UPDATE invitekeys SET used = 1 WHERE invitekey = :ikey");
    $q->bindParam(':ikey', $invitekey, PDO::PARAM_STR);
    $q->execute();
}

$hashPass = password_hash($password, PASSWORD_BCRYPT, [ "cost" => 12 ]);

$time = time();
$q = $con->prepare("INSERT INTO `users` (`id`, `username`, `password`, `permission`, `created`, `discord_time_since_no_verification`) VALUES (NULL, :username, :password, 'User', :time, :time)");
$q->bindParam(':username', $username, PDO::PARAM_STR);
$q->bindParam(':password', $hashPass, PDO::PARAM_STR);
$q->bindParam(':time', $time, PDO::PARAM_INT);
$q->execute();

$id = (int)$con->lastInsertId("users");
$sessKey = bin2hex(random_bytes(100));
$encryptIP = hash("sha512", $_SERVER["REMOTE_ADDR"]);

$q = $con->prepare("INSERT INTO `sessions` (`id`, `sessKey`, `userId`, `ip`, `userAgent`, `created`) VALUES (NULL, :sessKey, :id, :ip, :ua, :time)");
$q->bindParam(':sessKey', $sessKey, PDO::PARAM_STR);
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->bindParam(':ip', $encryptIP, PDO::PARAM_STR);
$q->bindParam(':ua', $_SERVER["HTTP_USER_AGENT"], PDO::PARAM_STR);
$q->bindParam(':time', $time, PDO::PARAM_INT);
$q->execute();

echo json_encode(["success"=>true,"authentication"=>$sessKey]);