<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header('Content-Type: application/json');

$response = [
    "jobId" => "Test",
    "status" => 2,
    "joinScriptUrl" => "http://shitblx.cf/Game/Join.ashx?jobId=Test&playerPrivateKey=testingfrfr",
    "authenticationUrl" => "http://shitblx.cf/Login/Negotiate.ashx?playerPrivateKey=testingfrfr",
    "authenticationTicket" => "testingfrfr",
    "message" => null
];
echo json_encode($response, JSON_UNESCAPED_SLASHES);