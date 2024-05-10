<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header("content-type: application/json");

$apiKeys = [
    "OdcAFk6MvV9PPLGunL5nKhqlliIDtBa8", // old madblox apikey, subject to remove
    "ThesupercoolapikeyFRFR!!!!!96464645132", // nodeblox fake src
    "npodTYDS3uWAKGmkRIC50In0KpF2swi2", // rbx09 or whatever shit
];

if(!isset($_REQUEST["text"])) exit(json_encode(["success"=>false,"message"=>"Please put the text"]));
$text = $_REQUEST["text"];

if(!isset($_REQUEST["apikey"])) exit(json_encode(["success"=>false,"message"=>"Please put the apikey"]));
if(!in_array($_REQUEST["apikey"], $apiKeys)) exit(json_encode(["success"=>false,"message"=>"Invalid apikey"]));

if($_REQUEST["apikey"] === "ThesupercoolapikeyFRFR!!!!!96464645132") {
    $real = [
        "I'm maybe a scammer, but I'm not!",
        "I farted",
        "I am skibidi rizz sigma ohio gyatt",
        "I ACTUALLY FARTED",
        "Diarrhea"
    ];
    exit(json_encode(["success"=>true,"new"=>$real[array_rand($real)]]));
}

echo json_encode(["success"=>true,"new"=>filterBadWords($text)]);