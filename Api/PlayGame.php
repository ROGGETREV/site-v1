<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");

if(!$loggedin) {
    header('location: /Default.aspx');
    exit;
}

if(!isset($_REQUEST["placeid"])) {
    header('location: /Games.aspx');
    exit;
}

$id = (int)$_REQUEST["placeid"];

$q = $con->prepare("SELECT * FROM games WHERE id = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$game = $q->fetch();
if(!$game) {
    header('location: /Games.aspx');
    exit;
}

$auth = bin2hex(random_bytes(20));

$q = $con->prepare("UPDATE users SET gameAuthentication = :auth WHERE id = :id");
$q->bindParam(':auth', $auth, PDO::PARAM_STR);
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->execute();

header('location: rogget:placeid='.(int)$id.';client='.$game["gameClient"].';authentication='.$auth);
echo "<script>window.location = '/Place.aspx';</script>";