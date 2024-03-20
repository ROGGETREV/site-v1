<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header("content-type: application/json");
error_reporting(0);

$post = json_decode(file_get_contents("php://input"), true);

if(!$post) {
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

if(
    isset($post["username"]) && isset($post["password"]) && !empty($post["username"]) && !empty($post["password"]) ||
    isset($post["ctype"]) && isset($post["cvalue"]) && isset($post["password"]) && !empty($post["ctype"]) && !empty($post["cvalue"]) && !empty($post["password"])
) {
    if(!isset($post["username"])) $username = $post["ctype"] === "Username" ? $post["cvalue"] : "";
    else $username = $post["username"];
    $password = $post["password"];

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

    $q = $con->prepare("INSERT INTO `sessions` (`id`, `sessKey`, `userId`, `ip`, `userAgent`, `created`) VALUES (NULL, :sessKey, :id, :ip, :ua, :time)");
    $q->bindParam(':sessKey', $sessKey, PDO::PARAM_STR);
    $q->bindParam(':id', $usr["id"], PDO::PARAM_INT);
    $q->bindParam(':ip', $encryptIP, PDO::PARAM_STR);
    $q->bindParam(':ua', $_SERVER["HTTP_USER_AGENT"], PDO::PARAM_STR);
    $q->bindParam(':time', $time, PDO::PARAM_INT);
    $q->execute();

    setcookie('.ROGGETSECURITY', $sessKey, time() + 31536000, "/");
    setcookie('.ROGGETSECURITY', $sessKey, time() + 31536000, "/", "shitblx.cf");
    setcookie('.ROGGETSECURITY', $sessKey, time() + 31536000, "/", ".shitblx.cf");

    exit(json_encode([
        "user" => [
            "id" => (int)$usr["id"],
            "name" => $usr["username"],
            "displayName" => $usr["username"]
        ],
        "twoStepVerificationData" => null,
        "isBanned" => (bool)$usr["banned"],
        "accountBlob" => "string"
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