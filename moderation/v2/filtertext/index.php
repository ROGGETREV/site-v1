<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header('Content-Type: application/json');
if(!isset($_REQUEST["text"])) {
    $array = [
        "success" => false,
        "data" => [
            "AgeUnder13" => null,
            "Age13OrOver" => null
        ]
    ];
} else {
    $array = [
        "success" => true,
        "data" => [
            "AgeUnder13" => filterBadWords($_REQUEST["text"]),
            "Age13OrOver" => filterBadWords($_REQUEST["text"])
        ]
    ];
}

echo json_encode($array);