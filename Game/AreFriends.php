<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
if(!$loggedin) exit("return Enum.FriendStatus.Unknown");
if(!isset($_REQUEST["ID"])) exit("return Enum.FriendStatus.Unknown");
$id = (int)$_REQUEST["ID"];
$q = $con->prepare("SELECT * FROM users WHERE id = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$usr = $q->fetch();
if(!$usr) exit("return Enum.FriendStatus.Unknown");

$q = $con->prepare("SELECT * FROM friendships WHERE ((user1 = :id AND user2 = :id2) OR (user1 = :id2 AND user2 = :id))");
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->bindParam(':id2', $id, PDO::PARAM_INT);
$q->execute();
$friendship = $q->fetch();
if($friendship) {
    if($friendship["accepted"] === 1) {
        exit("return Enum.FriendStatus.Friend");
    } else {
        if((int)$user["id"] === (int)$friendship["user2"]) exit("return Enum.FriendStatus.FriendRequestReceived");
        exit("return Enum.FriendStatus.FriendRequestSent");
    }
} else {
    exit("return Enum.FriendStatus.NotFriend");
}