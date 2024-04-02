<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header('Content-Type: application/json');

if(!$loggedin) exit(json_encode(["success"=>false,"message"=>"Please login"]));

if(!isset($_REQUEST["csrf_token"])) exit(json_encode(["success"=>false,"message"=>"Please put the csrf_token"]));

if(!isCorrectCSRF($_REQUEST["csrf_token"])) {
    if(isset($_SERVER["HTTP_REFERER"])) warnCSRF($_SERVER["HTTP_REFERER"]);
    exit(json_encode(["success"=>false,"message"=>"Invalid csrf_token"]));
}

if(!isset($_REQUEST["ID"])) exit(json_encode(["success"=>false,"message"=>"Please put the ID"]));

$id = (int)$_REQUEST["ID"];

if((int)$id === (int)$user["id"]) exit(json_encode(["success"=>false,"message"=>"You can't friend yourself"]));

if(!isset($_REQUEST["type"])) exit(json_encode(["success"=>false,"message"=>"Please put the type [add, remove]"]));

$type = $_REQUEST["type"];
if(!in_array($type, [
    "add",
    "remove"
])) exit(json_encode(["success"=>false,"message"=>"Wrong type [add, remove]"]));

$time = time();
$q = $con->prepare("SELECT * FROM friendships WHERE ((user1 = :id AND user2 = :id2) OR (user1 = :id2 AND user2 = :id))");
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->bindParam(':id2', $id, PDO::PARAM_INT);
$q->execute();
$friendship = $q->fetch();
if($type === "add") {
    if($friendship) {
        if($friendship["accepted"] === 1) {
            exit(json_encode(["success"=>false,"message"=>"You are already friends with this user"]));
        } else {
            if((int)$user["id"] === (int)$friendship["user2"]) {
                $q = $con->prepare("UPDATE friendships SET accepted = 1, responsetime = :time WHERE id = :id");
                $q->bindParam(':time', $time, PDO::PARAM_INT);
                $q->bindParam(':id', $friendship["id"], PDO::PARAM_INT);
                $q->execute();
                exit(json_encode(["success"=>true]));
            }
            exit(json_encode(["success"=>false,"message"=>"You already requested a friendship with this user"]));
        }
    } else {
        $q = $con->prepare("INSERT INTO `friendships` (`id`, `user1`, `user2`, `accepted`, `requesttime`, `responsetime`) VALUES (NULL, :id, :id2, '0', :time, '0')");
        $q->bindParam(':id', $user["id"], PDO::PARAM_INT);
        $q->bindParam(':id2', $id, PDO::PARAM_INT);
        $q->bindParam(':time', $time, PDO::PARAM_INT);
        $q->execute();
        exit(json_encode(["success"=>true]));
    }
    exit(json_encode(["success"=>true]));
} else if($type === "remove") {
    if(!$friendship) exit(json_encode(["success"=>false,"message"=>"You are not friends with this user"]));
    $q = $con->prepare("DELETE FROM friendships WHERE id = :id");
    $q->bindParam(':id', $friendship["id"], PDO::PARAM_INT);
    $q->execute();
    exit(json_encode(["success"=>true]));
}

echo json_encode(["success"=>false,"message"=>"Unknown error"]);