<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header("content-type: application/json");

$info = [
    "UserId" => 0,
    "Username" => null,
    "DisplayName" => null,
    "HasPasswordSet" => true,
    "Email" => null,
    "AgeBracket" => 0,
    "Roles" => [],
    "MembershipType" => 0,
    "RobuxBalance" => 0,
    "NotificationCount" => 0,
    "EmailNotificationEnabled" => false,
    "PasswordNotificationEnabled" => false
];

if($loggedin) {
    $info = [
        "UserId" => (int)$user["id"],
        "Username" => $user["username"],
        "DisplayName" => $user["username"],
        "HasPasswordSet" => true,
        "Email" => null,
        "AgeBracket" => 0,
        "Roles" => [],
        "MembershipType" => 0,
        "RobuxBalance" => (int)$user["nuggets"],
        "NotificationCount" => 0,
        "EmailNotificationEnabled" => false,
        "PasswordNotificationEnabled" => false
    ];
}

echo json_encode($info);