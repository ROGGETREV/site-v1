<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
if(!isset($_REQUEST["ID"])) {
    header('location: /images/loaderror.png');
    exit;
}

$id = (int)$_REQUEST["ID"];

$q = $con->prepare("SELECT * FROM catalog WHERE id = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$item = $q->fetch();
if(!$item) {
    header('location: /images/loaderror.png');
    exit;
}

if(!file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Catalog/".(int)$item["id"].".png")) {
    header('location: /images/loaderror.png');
    exit;
}

header('location: /images/Catalog/'.(int)$item["id"].'.png');