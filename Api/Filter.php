<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header("content-type: application/json");

$apiKeys = [
    "OdcAFk6MvV9PPLGunL5nKhqlliIDtBa8" // old madblox apikey, subject to remove
];

if(!isset($_REQUEST["text"])) exit(json_encode(["success"=>false,"message"=>"Please put the text"]));
$text = $_REQUEST["text"];

if(!isset($_REQUEST["apikey"])) exit(json_encode(["success"=>false,"message"=>"Please put the apikey"]));
if(!in_array($_REQUEST["apikey"], $apiKeys)) exit(json_encode(["success"=>false,"message"=>"Invalid apikey"]));

echo json_encode(["success"=>true,"new"=>filterBadWords($text)]);