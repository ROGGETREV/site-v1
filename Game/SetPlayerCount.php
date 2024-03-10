<?php
error_reporting(0);
header('Content-Type: text/plain');
if($_REQUEST["apiKey"] === "EHbKaHdKKrWlRfxneJkbEUWo9vZVLE64") {
    if(isset($_REQUEST["count"])) {
        file_put_contents("../players.txt", (int)$_REQUEST["count"]);
        echo "Updated count";
    } else {
        echo "Missing count";
    }
} else {
    echo "Wrong API key";
}