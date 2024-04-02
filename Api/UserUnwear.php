<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header('Content-Type: application/json');

if(!$loggedin) {
    exit(json_encode(["success"=>false,"message"=>"Please login"]));
}

if(!isset($_REQUEST["csrf_token"])) exit(json_encode(["success"=>false,"message"=>"Please put the csrf_token"]));

if(!isCorrectCSRF($_REQUEST["csrf_token"])) {
    if(isset($_SERVER["HTTP_REFERER"])) warnCSRF($_SERVER["HTTP_REFERER"]);
    exit(json_encode(["success"=>false,"message"=>"Invalid csrf_token"]));
}

if(!isset($_REQUEST["ID"])) {
    exit(json_encode(["success"=>false,"message"=>"Please put an ID"]));
}

$q = $con->prepare("DELETE FROM wearing WHERE user = :id AND item = :iid");
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->bindParam(':iid', $_REQUEST["ID"], PDO::PARAM_INT);
$q->execute();

exit(json_encode(["success"=>true]));