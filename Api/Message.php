<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header('Content-Type: application/json');

if(!$loggedin) exit(json_encode(["success"=>false,"message"=>"Please login"]));

if(!isset($_REQUEST["ID"])) exit(json_encode(["success"=>false,"message"=>"Please put an ID"]));
$id = (int)$_REQUEST["ID"];

$q = $con->prepare("SELECT * FROM messages WHERE id = :id");
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->execute();
$msgsql = $q->fetch();
if(!$msgsql) exit(json_encode(["success"=>false,"message"=>"Message doesn't exist"]));
if((int)$msgsql["user1"] !== (int)$user["id"] && (int)$msgsql["user2"] !== (int)$user["id"]) exit(json_encode(["success"=>false,"message"=>"You do not have enough permissions to view this message"]));

$msg = [
    "id" => (int)$msgsql["id"],
    "sender" => (int)$msgsql["user1"],
    "receiver" => (int)$msgsql["user2"],
    "subject" => $msgsql["subject"],
    "content" => $msgsql["content"],
    "read" => (int)$msgsql["hasBeenRead"],
    "created" => (int)$msgsql["created"]
];

echo json_encode(["success"=>true,"message"=>$msg], JSON_PRETTY_PRINT);