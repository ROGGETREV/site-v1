<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
error_reporting(0);
header('Content-Type: text/plain');
if($_REQUEST["apiKey"] === "EHbKaHdKKrWlRfxneJkbEUWo9vZVLE64") {
    if(isset($_REQUEST["count"])) {
        $q = $con->prepare("UPDATE games SET players = :players WHERE id = :id");
        $q->bindParam(':players', $_REQUEST["count"], PDO::PARAM_INT);
        $q->bindParam(':id', $_REQUEST["game"], PDO::PARAM_INT);
        $q->execute();
        echo "Updated count";
    } else {
        echo "Missing count";
    }
} else {
    echo "Wrong API key";
}