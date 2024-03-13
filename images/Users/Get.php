<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header("content-type: image/png");
if(!isset($_REQUEST["ID"])) {
    if($loggedin) {
        $_REQUEST["ID"] = (int)$user["id"];
    } else {
        exitFile($_SERVER["DOCUMENT_ROOT"]."/images/loaderror.png");
    }
}

$id = (int)$_REQUEST["ID"];

$q = $con->prepare("SELECT * FROM users WHERE id = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$usr = $q->fetch();
if(!$usr) {
    exitFile($_SERVER["DOCUMENT_ROOT"]."/images/loaderror.png");
}

if(isset($_REQUEST["year"])) {
    $year = (int)$_REQUEST["year"];
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Users/".$year."_".(int)$usr["id"].".png")) exitFile($_SERVER["DOCUMENT_ROOT"].'/images/Users/'.$year.'_'.(int)$usr["id"].'.png');
    exitFile($_SERVER["DOCUMENT_ROOT"]."/images/loaderror.png");
}

if(!file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Users/".$usr["renderYear"]."_".(int)$usr["id"].".png")) {
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Users/2008_".(int)$usr["id"].".png")) exitFile($_SERVER["DOCUMENT_ROOT"].'/images/Users/2008_'.(int)$usr["id"].'.png');
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Users/2011_".(int)$usr["id"].".png")) exitFile($_SERVER["DOCUMENT_ROOT"].'/images/Users/2011_'.(int)$usr["id"].'.png');
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Users/2011edited2016_".(int)$usr["id"].".png")) exitFile($_SERVER["DOCUMENT_ROOT"].'/images/Users/2011edited2016_'.(int)$usr["id"].'.png');
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Users/2016_".(int)$usr["id"].".png")) exitFile($_SERVER["DOCUMENT_ROOT"].'/images/Users/2016_'.(int)$usr["id"].'.png');
    exitFile($_SERVER["DOCUMENT_ROOT"]."/images/loaderror.png");
}

exitFile($_SERVER["DOCUMENT_ROOT"].'/images/Users/'.$usr["renderYear"].'_'.(int)$usr["id"].'.png');