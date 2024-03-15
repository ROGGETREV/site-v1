<?php
require_once(__DIR__."/require.php");

if(!isset($_REQUEST["auth"])) exitHTTPCode(404);

header("content-type: application/json");

$auth = $_REQUEST["auth"];
$time = time();

$q = $con->prepare("SELECT id, username FROM users WHERE chatAuthentication = :auth");
$q->bindParam(':auth', $auth, PDO::PARAM_STR);
$q->execute();
$usr = $q->fetch(PDO::FETCH_ASSOC);
if(!$usr) exit(json_encode(["success"=>false]));

echo json_encode(["success"=>true,"user"=>$usr]);