<?php
require_once(__DIR__."/require.php");

if(!isset($_REQUEST["message"]) || !isset($_REQUEST["user1"]) || !isset($_REQUEST["user2"])) exitHTTPCode(404);

header("content-type: application/json");

$msg = $_REQUEST["message"];
$user1 = (int)$_REQUEST["user1"];
$user2 = (int)$_REQUEST["user2"];
$time = time();

$q = $con->prepare("INSERT INTO `chats` (`id`, `user1`, `user2`, `message`, `created`) VALUES (NULL, :user1, :user2, :msg, :time)");
$q->bindParam(':msg', $msg, PDO::PARAM_STR);
$q->bindParam(':user1', $user1, PDO::PARAM_INT);
$q->bindParam(':user2', $user2, PDO::PARAM_INT);
$q->bindParam(':time', $time, PDO::PARAM_INT);
$q->execute();
echo json_encode(["success"=>true]);