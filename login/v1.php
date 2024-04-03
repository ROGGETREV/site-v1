<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header("content-type: application/json");
error_reporting(0);

if(
    isset($_REQUEST["username"]) && isset($_REQUEST["password"]) && !empty($_REQUEST["username"]) && !empty($_REQUEST["password"])
) {
    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];

    $q = $con->prepare("SELECT * FROM users WHERE username = :username");
    $q->bindParam(':username', $username, PDO::PARAM_STR);
    $q->execute();
    $usr = $q->fetch();
    if(!$usr) {
        exit(json_encode([
            "errors" => [
                [
                    "code" => 1,
                    "message" => "That account does not exist.",
                    "userFacingMessage" => "Something went wrong"
                ]
            ]
        ]));
    }

    if(!password_verify($password, $usr["password"])) {
        exit(json_encode([
            "errors" => [
                [
                    "code" => 1,
                    "message" => "Incorrect username or password. Please try again.",
                    "userFacingMessage" => "Something went wrong"
                ]
            ]
        ]));
    }

    $time = time();
    $sessKey = bin2hex(random_bytes(100));
    $encryptIP = hash("sha512", $_SERVER["REMOTE_ADDR"]);
    $mobileVer = "None";
    if(str_contains($_SERVER["HTTP_USER_AGENT"], "ROBLOX Android App 2.271.97572")) $mobileVer = "2.271.97572";

    $q = $con->prepare("INSERT INTO `sessions` (`id`, `sessKey`, `userId`, `ip`, `userAgent`, `mobileVersion`, `created`) VALUES (NULL, :sessKey, :id, :ip, :ua, :mobver, :time)");
    $q->bindParam(':sessKey', $sessKey, PDO::PARAM_STR);
    $q->bindParam(':id', $usr["id"], PDO::PARAM_INT);
    $q->bindParam(':ip', $encryptIP, PDO::PARAM_STR);
    $q->bindParam(':ua', $_SERVER["HTTP_USER_AGENT"], PDO::PARAM_STR);
    $q->bindParam(':mobver', $mobileVer, PDO::PARAM_STR);
    $q->bindParam(':time', $time, PDO::PARAM_INT);
    $q->execute();

    setcookie('.ROGGETSECURITY', $sessKey, time() + 31536000, "/");
    setcookie('.ROGGETSECURITY', $sessKey, time() + 31536000, "/", "shitblx.cf");
    setcookie('.ROGGETSECURITY', $sessKey, time() + 31536000, "/", ".shitblx.cf");

    $bc = false;
    if($usr["buildersclub"] !== "None") $bc = true;

    echo(json_encode([
        "Status" => "OK",
        "UserInfo" => [
            "userId" => (int)$usr["id"],
            "username" => $usr["username"],
            "RobuxBalance" => (int)$usr["nuggets"],
            "IsAnyBuildersClubMember" => $bc,
            "ThumbnailUrl" => "http://shitblx.cf/images/Users/Get.ashx?ID=".(int)$usr["id"]
        ]
        /*"membershipType" => 4,
        "username" => $usr["username"],
        "isUnder13" => false,
        "countryCode" => "US",
        "userId" => (int)$usr["id"]*/
    ]));
} else {
    exit(json_encode([
        "errors" => [
            [
                "code" => 9,
                "message" => "Please complete the form.",
                "userFacingMessage" => "Something went wrong"
            ]
        ]
    ]));
}