<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");

if(!$loggedin) exit;

$q = $con->prepare("DELETE FROM sessions WHERE sessKey = :sessKey");
$q->bindParam(':sessKey', $_COOKIE["_ROGGETSECURITY"], PDO::PARAM_STR);
$q->execute();

setcookie(".ROGGETSECURITY", "", -1, "/");