<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header('Content-Type: application/json');

if(!isset($_REQUEST["ID"])) {
    exit(json_encode(["success"=>false,"message"=>"Please put the ID"]));
}
$id = (int)$_REQUEST["ID"];

$q = $con->prepare("SELECT * FROM users WHERE id = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$usr = $q->fetch();
if(!$usr) exit(json_encode(["success"=>false,"message"=>"Unknown user"]));

$wearing = [];

$q = $con->prepare("SELECT * FROM wearing WHERE user = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
foreach($q->fetchAll() as $wear) array_push($wearing, $wear["item"]);

echo json_encode([
    "success" => true,
    "user" => [
        "id" => (int)$usr["id"],
        "username" => $usr["username"],
        "description" => $usr["description"],
        "permissions" => $usr["permission"],
        "membership" => $usr["buildersclub"],
        "lastonline" => (int)$usr["lastonline"],
        "nuggets" => (int)$usr["nuggets"],
        "banned" => (bool)$usr["banned"],
        "avatar" => [
            "bodyColors" => json_decode($usr["bodyColors"], true),
            "wearing" => $wearing,
            "charapp" => "http://shitblx.cf/Game/CharacterFetch.ashx?userId=".(int)$usr["id"]
        ],
        "created" => (int)$usr["created"]
    ]
], JSON_PRETTY_PRINT);