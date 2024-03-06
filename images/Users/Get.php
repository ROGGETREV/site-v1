<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
if(!isset($_REQUEST["ID"])) {
    if($loggedin) {
        $_REQUEST["ID"] = (int)$user["id"];
    } else {
        header('location: /images/loaderror.png');
        exit;
    }
}

$id = (int)$_REQUEST["ID"];

$q = $con->prepare("SELECT * FROM users WHERE id = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$usr = $q->fetch();
if(!$usr) {
    header('location: /images/loaderror.png');
    exit;
}

if(isset($_REQUEST["year"])) {
    $year = (int)$_REQUEST["year"];
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Users/".$year."_".(int)$usr["id"].".png")) {
        header('location: /images/Users/'.$year.'_'.(int)$usr["id"].'.png?'.random_int(1, getrandmax()));
        exit;
    }
    header('location: /images/loaderror.png');
    exit;
}

if(!file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Users/".$usr["renderYear"]."_".(int)$usr["id"].".png")) {
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Users/2008_".(int)$usr["id"].".png")) {
        header('location: /images/Users/2008_'.(int)$usr["id"].'.png?'.random_int(1, getrandmax()));
        exit;
    }
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Users/2011_".(int)$usr["id"].".png")) {
        header('location: /images/Users/2011_'.(int)$usr["id"].'.png?'.random_int(1, getrandmax()));
        exit;
    }
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Users/2011edited2016_".(int)$usr["id"].".png")) {
        header('location: /images/Users/2011edited2016_'.(int)$usr["id"].'.png?'.random_int(1, getrandmax()));
        exit;
    }
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/images/Users/2016_".(int)$usr["id"].".png")) {
        header('location: /images/Users/2016_'.(int)$usr["id"].'.png?'.random_int(1, getrandmax()));
        exit;
    }
    header('location: /images/loaderror.png');
    exit;
}

header('location: /images/Users/'.$usr["renderYear"].'_'.(int)$usr["id"].'.png?'.random_int(1, getrandmax()));