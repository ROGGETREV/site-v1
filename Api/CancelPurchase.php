<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header('Content-Type: application/json');

if(!$loggedin) exit(json_encode(["success"=>false,"message"=>"Please login"]));

if(!isset($_REQUEST["csrf_token"])) exit(json_encode(["success"=>false,"message"=>"Please put the csrf_token"]));

if(!isCorrectCSRF($_REQUEST["csrf_token"])) {
    if(isset($_SERVER["HTTP_REFERER"])) warnCSRF($_SERVER["HTTP_REFERER"]);
    exit(json_encode(["success"=>false,"message"=>"Invalid csrf_token"]));
}

if(!isset($_REQUEST["ID"])) exit(json_encode(["success"=>false,"message"=>"Missing ID"]));
$id = (int)$_REQUEST["ID"];

$q = $con->prepare("SELECT * FROM catalog WHERE id = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$item = $q->fetch();
if(!$item) exit(json_encode(["success"=>false,"message"=>"Item does not exist"]));

$q = $con->prepare("SELECT * FROM users WHERE id = :id");
$q->bindParam(':id', $item["creator"], PDO::PARAM_INT);
$q->execute();
$creator = $q->fetch();
if(!$creator) exit(json_encode(["success"=>false,"message"=>"Item does not exist"]));

if((int)$creator["id"] === (int)$user["id"]) exit(json_encode(["success"=>false,"message"=>"You made this item"]));

$q = $con->prepare("SELECT * FROM owneditems WHERE user = :id AND item = :iid");
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->bindParam(':iid', $id, PDO::PARAM_INT);
$q->execute();
if(!$q->fetch()) exit(json_encode(["success"=>false,"message"=>"You don't own this item."]));

$q = $con->prepare("DELETE FROM owneditems WHERE user = :id AND item = :iid");
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->bindParam(':iid', $id, PDO::PARAM_INT);
$q->execute();

echo json_encode(["success"=>true]);