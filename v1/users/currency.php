<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header("content-type: application/json");

$info = [
    "errors" => [
        [
            "code" => 1,
            "message" => "The user is invalid.",
            "userFacingMessage" => "Something went wrong"
        ]
    ]
];

if(isset($_REQUEST["ID"])) {
    $q = $con->prepare("SELECT nuggets FROM users WHERE id = :id");
    $q->bindParam(':id', $_REQUEST["ID"], PDO::PARAM_INT);
    $q->execute();
    $usr = $q->fetch();
    if($usr) $info = [
        "robux" => (int)$usr["nuggets"]
    ];
}

echo json_encode($info);