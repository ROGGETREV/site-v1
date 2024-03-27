<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
error_reporting(0);
if(!isset($_REQUEST["userId"])) {
    $_REQUEST["userId"] = 0;
}
$_REQUEST["ID"] = (int)$_REQUEST["userId"];
if(isset($_REQUEST["username"])) {
    $_REQUEST["username"] = "nolanwhy";
    $q = $con->prepare("SELECT * FROM users WHERE username = :name");
    $q->bindParam(':name', $_REQUEST["username"], PDO::PARAM_STR);
    $q->execute();
    $usr = $q->fetch();
    if($usr) $_REQUEST["ID"] = (int)$usr["id"];
}
require_once($_SERVER["DOCUMENT_ROOT"]."/images/Users/Get.php");