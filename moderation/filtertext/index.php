<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header('Content-Type: application/json');

if(!isset($_REQUEST["text"])) {
    $array = [
        "white" => null,
        "black" => null
    ];
} else {
    $array = [
        "white" => filterBadWords($_REQUEST["text"]),
        "black" => $_REQUEST["text"]
    ];
}

echo json_encode(["data"=>$array]);