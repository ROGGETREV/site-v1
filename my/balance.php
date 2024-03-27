<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
$info = [
    "robux" => 0
];

if($loggedin) {
    $info["robux"] = (int)$user["nuggets"];
}

echo json_encode($info);