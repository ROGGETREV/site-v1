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
$requestNuggets = (int)$_REQUEST["nuggets"] ?? 0;

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

$newNuggetCountForOwner = (int)$creator["nuggets"] + (int)$item["nuggets"];
$q = $con->prepare("UPDATE users SET nuggets = :new WHERE id = :id");
$q->bindParam(':new', $newNuggetCountForOwner, PDO::PARAM_INT);
$q->bindParam(':id', $item["creator"], PDO::PARAM_INT);
$q->execute();

$q = $con->prepare("INSERT INTO `owneditems` (`id`, `user`, `item`) VALUES (NULL, :id, :iid)");
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->bindParam(':iid', $id, PDO::PARAM_INT);
$q->execute();

$subject = "You have earned ".(int)$item["nuggets"]." nuggets!";
$content = "User ".$user["username"]." (ID ".(int)$user["id"].") has bought your item: \"".filterBadWords($item["name"])."\" at ".(int)$item["nuggets"]." nuggets.\nThe nuggets has been given to you.";

$time = time();

$q = $con->prepare("INSERT INTO `messages` (`id`, `user1`, `user2`, `subject`, `content`, `hasBeenRead`, `reply`, `created`) VALUES (NULL, 1, :id, :subject, :content, '0', '0', :time)");
$q->bindParam(':id', $creator["id"], PDO::PARAM_INT);
$q->bindParam(':subject', $subject, PDO::PARAM_STR);
$q->bindParam(':content', $content, PDO::PARAM_STR);
$q->bindParam(':time', $time, PDO::PARAM_INT);
$q->execute();

$subject = "You have bought ".filterBadWords($item["name"])." for ".(int)$item["nuggets"]." nuggets.";
$content = "You have bought an item: \"".filterBadWords($item["name"])."\" at ".(int)$item["nuggets"]." nuggets from user ".$creator["username"]." (ID ".(int)$creator["id"].").\nThe item has been given to you.";

$q = $con->prepare("INSERT INTO `messages` (`id`, `user1`, `user2`, `subject`, `content`, `hasBeenRead`, `reply`, `created`) VALUES (NULL, 1, :id, :subject, :content, '0', '0', :time)");
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->bindParam(':subject', $subject, PDO::PARAM_STR);
$q->bindParam(':content', $content, PDO::PARAM_STR);
$q->bindParam(':time', $time, PDO::PARAM_INT);
$q->execute();

echo json_encode(["success"=>true]);