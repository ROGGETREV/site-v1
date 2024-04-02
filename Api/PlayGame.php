<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");

if(!$loggedin && !$guestEnabled) {
    header('location: /Default.aspx');
    exit;
}

if(!isset($_REQUEST["csrf_token"])) {
    header('location: /Default.aspx');
    exit;
}

if(!isCorrectCSRF($_REQUEST["csrf_token"])) {
    if(isset($_SERVER["HTTP_REFERER"])) warnCSRF($_SERVER["HTTP_REFERER"]);
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

if($loggedin) {
    $auth = bin2hex(random_bytes(20));

    $q = $con->prepare("UPDATE users SET gameAuthentication = :auth WHERE id = :id");
    $q->bindParam(':auth', $auth, PDO::PARAM_STR);
    $q->bindParam(':id', $user["id"], PDO::PARAM_INT);
    $q->execute();
} else {
    $auth = "guest";
}

header('location: rogget:placeid='.(int)$id.';client='.$game["gameClient"].';authentication='.$auth);
echo "<script>window.location = '/Place.aspx';</script>";