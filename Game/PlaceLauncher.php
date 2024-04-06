<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header('Content-Type: application/json');
error_reporting(0);
// Place join status results
// Waiting = 0,
// Loading = 1,
// Joining = 2,
// Disabled = 3,
// Error = 4,
// GameEnded = 5,
// GameFull = 6
// UserLeft = 10
// Restricted = 11

function loadFail() {
    exit(json_encode([
        "jobId" => "",
        "status" => 4,
        "joinScriptUrl" => "",
        "authenticationUrl" => "",
        "authenticationTicket" => "",
        "message" => null
    ], JSON_UNESCAPED_SLASHES));
}

$status = 2;
if(!isset($_REQUEST["game"]) && isset($_REQUEST["placeId"])) $_REQUEST["game"] = (int)$_REQUEST["placeId"];

if(!isset($_REQUEST["game"]) || empty($_REQUEST["game"])) loadFail();

if(!str_contains($_SERVER["HTTP_USER_AGENT"], "ROBLOX Android App")) {
    if(isset($_REQUEST["authentication"]) && !empty($_REQUEST["authentication"])) {
        if($_REQUEST["authentication"] === "guest" && $guestEnabled) {} else {
            $q = $con->prepare("SELECT * FROM users WHERE gameAuthentication = :auth");
            $q->bindParam(':auth', $_REQUEST["authentication"], PDO::PARAM_STR);
            $q->execute();
            $usr = $q->fetch();
            if(!$usr) loadFail();
        }
    } else loadFail();
} else {
    if(!$loggedin) {
        if($guestEnabled) $_REQUEST["authentication"] = "guest";
        else loadFail();
    } else {
        // Mobile player holy shiet!!
        $auth = bin2hex(random_bytes(100));

        $q = $con->prepare("UPDATE users SET gameAuthentication = :auth WHERE id = :id");
        $q->bindParam(':auth', $auth, PDO::PARAM_STR);
        $q->bindParam(':id', $user["id"], PDO::PARAM_INT);
        $q->execute();

        $_REQUEST["authentication"] = $auth;
    }
}

$js = "http://shitblx.cf/Game/2016/Join.ashx?authentication=".$_REQUEST["authentication"]."&game=".(int)$_REQUEST["game"];
$negotiate = "http://shitblx.cf/Login/Negotiate.ashx?authentication=".$_REQUEST["authentication"]."&game=".(int)$_REQUEST["game"];

$auth = $_REQUEST["authentication"];
$game = (int)$_REQUEST["game"];

$q = $con->prepare("SELECT * FROM games WHERE id = :id");
$q->bindParam(':id', $game, PDO::PARAM_INT);
$q->execute();
$game = $q->fetch();
if(!$game) loadFail();

if($_REQUEST["authentication"] === "guest" && $guestEnabled) {} else {
    $fetchedPlayedGames = json_decode($usr["playedGames"], true);
    
    $playedGames = [];
    foreach($fetchedPlayedGames as $key => $value) {
        if($value !== (int)$game["id"]) {
            $playedGames[] = $value;
        }
    }

    $playedGames[] = (int)$game["id"];
    $playedGames = json_encode($playedGames);

    $q = $con->prepare("UPDATE users SET playedGames = :played WHERE gameAuthentication = :auth");
    $q->bindParam(':played', $playedGames, PDO::PARAM_STR);
    $q->bindParam(':auth', $_REQUEST["authentication"], PDO::PARAM_STR);
    $q->execute();
}

$response = [
    "jobId" => "TestServer1",
    "status" => $status,
    "joinScriptUrl" => $js,
    "authenticationUrl" => $negotiate,
    "authenticationTicket" => $_REQUEST["authentication"],
    "message" => null
];
echo json_encode($response, JSON_UNESCAPED_SLASHES);