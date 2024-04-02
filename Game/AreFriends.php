<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
if(!$loggedin) exit("unknown");
if(!isset($_REQUEST["ID"])) exit("unknown");
$id = (int)$_REQUEST["ID"];
$q = $con->prepare("SELECT * FROM users WHERE id = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$usr = $q->fetch();
if(!$usr) exit("unknown");

$q = $con->prepare("SELECT * FROM friendships WHERE ((user1 = :id AND user2 = :id2) OR (user1 = :id2 AND user2 = :id))");
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->bindParam(':id2', $id, PDO::PARAM_INT);
$q->execute();
$friendship = $q->fetch();
if($friendship) {
    if($friendship["accepted"] === 1) {
        exit("friend");
    } else {
        if((int)$user["id"] === (int)$friendship["user2"]) exit("friendrequestreceived");
        exit("friendrequestsent");
    }
} else {
    exit("notfriend");
}