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

if(!isset($_REQUEST["year"])) {
    exit(json_encode(["success"=>false,"message"=>"Please put a year"]));
}

if(!in_array($_REQUEST["year"], [
    "2008",
    "2011",
    "2011edited2016",
    "2016"
])) {
    exit(json_encode(["success"=>false,"message"=>"Invalid year"]));
}

$q = $con->prepare("UPDATE users SET renderYear = :year WHERE id = :id");
$q->bindParam(':year', $_REQUEST["year"], PDO::PARAM_STR);
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->execute();

exit(json_encode(["success"=>true]));