<?php
file_put_contents("decline.txt", file_get_contents("php://input")." | ".json_encode($_GET)." | ".json_encode($_POST)." | ".json_encode($_COOKIE));
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header('Content-Type: application/json');

if(!$loggedin) {
    exit(json_encode(["success"=>false,"message"=>"Please login"]));
}

if(!isset($_REQUEST["requesterUserId"])) {
    exit(json_encode(["success"=>false,"message"=>"Please put the ID"]));
}
$id = (int)$_REQUEST["requesterUserId"];

if((int)$id === (int)$user["id"]) {
    exit(json_encode(["success"=>false,"message"=>"You can't friend yourself"]));
}

$time = time();
$q = $con->prepare("SELECT * FROM friendships WHERE ((user1 = :id AND user2 = :id2) OR (user1 = :id2 AND user2 = :id))");
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->bindParam(':id2', $id, PDO::PARAM_INT);
$q->execute();
$friendship = $q->fetch();
if(!$friendship) exit(json_encode(["success"=>false,"message"=>"You are not friends with this user"]));
$q = $con->prepare("DELETE FROM friendships WHERE id = :id");
$q->bindParam(':id', $friendship["id"], PDO::PARAM_INT);
$q->execute();
exit(json_encode(["success"=>true]));

echo json_encode(["success"=>false,"message"=>"Unknown error"]);