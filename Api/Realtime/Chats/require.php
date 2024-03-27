<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
$apiKey = "ZuyTFBekyWSO6OEQF2Qe00gteVd7They";
if($_SERVER["PHP_SELF"] === "/Api/Realtime/Chats/apiKey.php" || !isset($_REQUEST["apiKey"])) exitHTTPCode(404);
if($_REQUEST["apiKey"] !== $apiKey) exitHTTPCode(404);