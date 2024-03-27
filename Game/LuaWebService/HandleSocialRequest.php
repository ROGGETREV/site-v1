<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header('Content-Type: text/plain');
$methods = [
    "IsInGroup",
    "GetGroupRank"
];
$admins = [];
$interns = [];

$q = $con->prepare("SELECT * FROM users");
$q->execute();
foreach($q->fetchAll() as $usr) {
    if($usr["permission"] === "Administrator") {
        array_push($admins, $usr["id"]);
    }
    /*if($usr["intern"] === 1) {
        array_push($interns, $usr["id"]);
    }*/
}

if(!isset($_REQUEST["method"])) {
    exit('<Value Type="boolean">false</Value>');
}
$method = $_REQUEST["method"];
if(!in_array($method, $methods)) {
    exit('<Value Type="boolean">false</Value>');
}

if($method === "IsInGroup") {
    if(!isset($_REQUEST["groupid"]) || !isset($_REQUEST["playerid"])) {
        exit('<Value Type="boolean">false</Value>');
    }
    if($_REQUEST["groupid"] == 1200769) {
        if(in_array($_REQUEST["playerid"],$admins)) {
            exit('<Value Type="boolean">true</Value>');
        }
    }
    exit('<Value Type="boolean">false</Value>');
} elseif($method === "GetGroupRank") {
    if(!isset($_REQUEST["groupid"]) || !isset($_REQUEST["playerid"])) {
        exit('<Value Type="boolean">false</Value>');
    }
    if($_REQUEST["groupid"] == 2868472) {
        if(in_array($_REQUEST["playerid"],$interns)) {
            exit('<Value Type="integer">110</Value>');
        }
    }
    exit('<Value Type="integer">0</Value>');
} else {
    $value = false;
}


if (is_bool($value)) {
    $type = "boolean";
} elseif (is_int($value)) {
    $type = "integer";
} else {
    $type = "string";
}
if($type === "boolean") {
    if($value) {
        echo "<Value Type=\"$type\">true</Value>";
    } else {
        echo "<Value Type=\"$type\">false</Value>";
    }
} else {
    echo "<Value Type=\"$type\">$value</Value>";
}