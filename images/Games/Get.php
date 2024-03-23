<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header("content-type: image/png");
if(!isset($_REQUEST["ID"])) {
    exitFile($_SERVER["DOCUMENT_ROOT"]."/images/loaderror.png");
}

$id = (int)$_REQUEST["ID"];

$q = $con->prepare("SELECT * FROM games WHERE id = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$game = $q->fetch();
if(!$game) {
    exitFile($_SERVER["DOCUMENT_ROOT"]."/images/loaderror.png");
}

if(isset($_REQUEST["year"])) {
    $year = (int)$_REQUEST["year"];
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Games/".$year."_".(int)$game["id"].".png")) exitFile($_SERVER["DOCUMENT_ROOT"].'/images/Games/'.$year.'_'.(int)$game["id"].'.png');
    exitFile($_SERVER["DOCUMENT_ROOT"]."/images/loaderror.png");
}

if(!file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Games/".$game["renderYear"]."_".(int)$game["id"].".png")) {
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Games/2008_".(int)$game["id"].".png")) exitFile($_SERVER["DOCUMENT_ROOT"].'/images/Games/2008_'.(int)$game["id"].'.png');
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Games/2011_".(int)$game["id"].".png")) exitFile($_SERVER["DOCUMENT_ROOT"].'/images/Games/2011_'.(int)$game["id"].'.png');
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Games/2011edited2016_".(int)$game["id"].".png")) exitFile($_SERVER["DOCUMENT_ROOT"].'/images/Games/2011edited2016_'.(int)$game["id"].'.png');
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Games/2016_".(int)$game["id"].".png")) exitFile($_SERVER["DOCUMENT_ROOT"].'/images/Games/2016_'.(int)$game["id"].'.png');
    exitFile($_SERVER["DOCUMENT_ROOT"]."/images/loaderror.png");
}

exitFile($_SERVER["DOCUMENT_ROOT"].'/images/Games/'.$game["renderYear"].'_'.(int)$game["id"].'.png');