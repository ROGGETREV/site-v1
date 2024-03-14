<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header('Content-Type: application/json');

if(!$loggedin) exit(json_encode(["success"=>false,"message"=>"Please login"]));

$q = $con->prepare("SELECT * FROM messages WHERE user2 = :id AND hasBeenRead = 0");
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->execute();
$unreadsql = $q->fetchAll(PDO::FETCH_ASSOC);

$q = $con->prepare("SELECT * FROM messages WHERE user1 = :id");
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->execute();
$sentsql = $q->fetchAll(PDO::FETCH_ASSOC);

$q = $con->prepare("SELECT * FROM messages WHERE user2 = :id AND hasBeenRead = 1");
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->execute();
$readsql = $q->fetchAll(PDO::FETCH_ASSOC);

$unread = [];
$sent = [];
$read = [];

foreach($unreadsql as $msg) array_push($unread, [ "id" => (int)$msg["id"], "sender" => (int)$msg["user1"], "receiver" => (int)$msg["user2"], "subject" => $msg["subject"], "content" => $msg["content"], "read" => (int)$msg["hasBeenRead"], "created" => (int)$msg["created"] ]);
foreach($sentsql as $msg) array_push($sent, [ "id" => (int)$msg["id"], "sender" => (int)$msg["user1"], "receiver" => (int)$msg["user2"], "subject" => $msg["subject"], "content" => $msg["content"], "read" => (int)$msg["hasBeenRead"], "created" => (int)$msg["created"] ]);
foreach($readsql as $msg) array_push($read, [ "id" => (int)$msg["id"], "sender" => (int)$msg["user1"], "receiver" => (int)$msg["user2"], "subject" => $msg["subject"], "content" => $msg["content"], "read" => (int)$msg["hasBeenRead"], "created" => (int)$msg["created"] ]);

echo json_encode(["success"=>true,"unread"=>$unread,"sent"=>$sent,"read"=>$read], JSON_PRETTY_PRINT);