<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");

if(!$loggedin) {
    header('location: /Default.aspx');
    exit;
}

if(isset($_REQUEST["all"])) {
    // Delete all sessions from the user
    $q = $con->prepare("DELETE FROM sessions WHERE userId = :id");
    $q->bindParam(':id', $user["id"], PDO::PARAM_INT);
    $q->execute();
} else {
    // Delete only this one
    $q = $con->prepare("DELETE FROM sessions WHERE sessKey = :sessKey");
    $q->bindParam(':sessKey', $_COOKIE["_ROGGETSECURITY"], PDO::PARAM_STR);
    $q->execute();
}

setcookie(".ROGGETSECURITY", "", -1, "/");
header('location: /Default.aspx');