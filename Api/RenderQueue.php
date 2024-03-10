<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header('Content-Type: application/json');
$apiKey = "GarO0NaSHC5IW42q9i4wrhhwZV6GpXTz";

if(!isset($_REQUEST["apiKey"])) {
    exit(json_encode(["success"=>false,"message"=>"No API key provided"]));
}

if(!isset($_REQUEST["type"])) {
    exit(json_encode(["success"=>false,"message"=>"No type provided"]));
}

if($_REQUEST["apiKey"] !== $apiKey) {
    exit(json_encode(["success"=>false,"message"=>"Wrong API key"]));
}

$type = $_REQUEST["type"];
if(!in_array($type, [
    "get",
    "set"
])) {
    exit(json_encode(["success"=>false,"message"=>"Wrong type"]));
}

if($type === "get") {
    $q = $con->prepare("SELECT * FROM renderqueue LIMIT 1");
    $q->execute();
    $count = 0;
    foreach($q->fetchAll(PDO::FETCH_ASSOC) as $render) {
        $count++;
        exit(json_encode(["success"=>true,"render"=>$render]));
    }
    if($count <= 0) exit(json_encode(["success"=>true,"render"=>false]));
} else if($type === "set") {
    if(!isset($_REQUEST["remote"])) {
        exit(json_encode(["success"=>false,"message"=>"No remote provided"]));
    }
    if(!isset($_REQUEST["b64"])) {
        exit(json_encode(["success"=>false,"message"=>"No b64 provided"]));
    }
    if(!isset($_REQUEST["renderType"])) {
        exit(json_encode(["success"=>false,"message"=>"No renderType provided"]));
    }
    $remote = (int)$_REQUEST["remote"];
    $b64 = $_REQUEST["b64"];
    $renderType = $_REQUEST["renderType"];
    if(!in_array($renderType, [
        "user",
        "place"
    ])) {
        exit(json_encode(["success"=>false,"message"=>"Wrong renderType"]));
    }
    if($renderType === "user") {
        $q = $con->prepare("SELECT * FROM users WHERE id = :id");
        $q->bindParam(':id', $remote, PDO::PARAM_INT);
        $q->execute();
        $usr = $q->fetch();
        if(!$usr) {
            exit(json_encode(["success"=>false,"message"=>"Wrong remote"]));
        }
        $q = $con->prepare("DELETE FROM renderqueue WHERE remote = :id AND type = 'user'");
        $q->bindParam(':id', $remote, PDO::PARAM_INT);
        $q->execute();
        file_put_contents($_SERVER["DOCUMENT_ROOT"]."/images/Users/2011_".(int)$remote.".png", base64_decode($b64));
        exit(json_encode(["success"=>true]));
    } else if($renderType === "place") {
        // 
    }
}