<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header("content-type: image/png");
if(!isset($_REQUEST["ID"])) {
    exitFile($_SERVER["DOCUMENT_ROOT"]."/images/loaderror.png");
}

$id = (int)$_REQUEST["ID"];

$q = $con->prepare("SELECT * FROM `catalog` WHERE id = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$item = $q->fetch();
if(!$item) {
    exitFile($_SERVER["DOCUMENT_ROOT"]."/images/loaderror.png");
}

if($item["type"] === "face") {
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/Asset/assets/face/".(int)$item["id"].".png")) exitFile($_SERVER["DOCUMENT_ROOT"].'/Asset/assets/face/'.(int)$item["id"].'.png');
    exitFile($_SERVER["DOCUMENT_ROOT"]."/images/loaderror.png");
}

if(isset($_REQUEST["year"])) {
    $year = (int)$_REQUEST["year"];
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Catalog/".$year."_".(int)$item["id"].".png")) exitFile($_SERVER["DOCUMENT_ROOT"].'/images/Catalog/'.$year.'_'.(int)$item["id"].'.png');
    exitFile($_SERVER["DOCUMENT_ROOT"]."/images/loaderror.png");
}

if(!file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Catalog/".$item["renderYear"]."_".(int)$item["id"].".png")) {
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Catalog/2008_".(int)$item["id"].".png")) exitFile($_SERVER["DOCUMENT_ROOT"].'/images/Catalog/2008_'.(int)$item["id"].'.png');
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Catalog/2011_".(int)$item["id"].".png")) exitFile($_SERVER["DOCUMENT_ROOT"].'/images/Catalog/2011_'.(int)$item["id"].'.png');
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Catalog/2011edited2016_".(int)$item["id"].".png")) exitFile($_SERVER["DOCUMENT_ROOT"].'/images/Catalog/2011edited2016_'.(int)$item["id"].'.png');
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Catalog/2016_".(int)$item["id"].".png")) exitFile($_SERVER["DOCUMENT_ROOT"].'/images/Catalog/2016_'.(int)$item["id"].'.png');
    exitFile($_SERVER["DOCUMENT_ROOT"]."/images/loaderror.png");
}

exitFile($_SERVER["DOCUMENT_ROOT"].'/images/Catalog/'.$item["renderYear"].'_'.(int)$item["id"].'.png');