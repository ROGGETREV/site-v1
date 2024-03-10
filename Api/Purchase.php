<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header('Content-Type: application/json');

if(!$loggedin) exit(json_encode(["success"=>false,"message"=>"Please login"]));

if(!isset($_REQUEST["ID"])) exit(json_encode(["success"=>false,"message"=>"Missing ID"]));
$id = (int)$_REQUEST["ID"];
$requestNuggets = (int)$_REQUEST["nuggets"] ?? 0;

$q = $con->prepare("SELECT * FROM catalog WHERE id = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$item = $q->fetch();
if(!isset($_REQUEST["nuggets"])) $requestNuggets = (int)$item["nuggets"];

$q = $con->prepare("SELECT * FROM owneditems WHERE user = :id AND item = :iid");
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->bindParam(':iid', $id, PDO::PARAM_INT);
$q->execute();
if($q->fetch()) exit(json_encode(["success"=>false,"message"=>"You already own this item."]));

if($requestNuggets !== (int)$item["nuggets"]) exit(json_encode(["success"=>false,"message"=>"The Nugget cost of this item has changed (".(int)$requestNuggets." Nuggets => ".(int)$item["nuggets"]." Nuggets).\nPlease refresh the page."]));

$newNuggetCount = (int)$user["nuggets"] - (int)$item["nuggets"];
if($newNuggetCount < 0) exit(json_encode(["success"=>false,"message"=>"You do not have enough Nuggets."]));

$q = $con->prepare("UPDATE users SET nuggets = :new WHERE id = :id");
$q->bindParam(':new', $newNuggetCount, PDO::PARAM_INT);
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->execute();

$q = $con->prepare("INSERT INTO `owneditems` (`id`, `user`, `item`) VALUES (NULL, :id, :iid)");
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->bindParam(':iid', $id, PDO::PARAM_INT);
$q->execute();

echo json_encode(["success"=>true]);