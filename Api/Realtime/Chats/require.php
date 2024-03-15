<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
$apiKey = "5MBue3AOqp7xRtLayzMu6XG1PfcTGdKz";
if($_SERVER["PHP_SELF"] === "/Api/Realtime/Chats/apiKey.php" || !isset($_REQUEST["apiKey"])) exitHTTPCode(404);
if($_REQUEST["apiKey"] !== $apiKey) exitHTTPCode(404);