<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header("content-type: application/json");

function generateClientTicket($year, $params) {
    if($year === 2016) {
        if(
            !isset($params["id"]) ||
            !isset($params["name"]) ||
            !isset($params["charapp"]) ||
            !isset($params["jobid"]) ||
            !isset($params["privatekey"])
        ) return null;
        $ticket = $params["id"] . "\n" . $params["jobid"] . "\n" . date('n\/j\/Y\ g\:i\:s\ A');
        openssl_sign($ticket, $sig, $params["privatekey"], OPENSSL_ALGO_SHA1);
        $sig = base64_encode($sig);
        $ticket2 = $params["id"] . "\n" . $params["name"] . "\n" . $params["charapp"] . "\n". $params["jobid"] . "\n" . date('n\/j\/Y\ g\:i\:s\ A');
        openssl_sign($ticket2, $sig2, $params["privatekey"], OPENSSL_ALGO_SHA1);
        $sig2 = base64_encode($sig2);
        $final = date('n\/j\/Y\ g\:i\:s\ A') . ";" . $sig2 . ";" . $sig;
    } elseif($year === 2018) {
        if(
            !isset($params["id"]) ||
            !isset($params["name"]) ||
            !isset($params["charapp"]) ||
            !isset($params["jobid"]) ||
            !isset($params["followuserid"]) ||
            !isset($params["accountage"]) ||
            !isset($params["membership"]) ||
            !isset($params["countrycode"]) ||
            !isset($params["privatekey"])
        ) return null;
        $ticket = date('n\/j\/Y\ g\:i\:s\ A') . $params["jobid"] . "\n" . $params["id"] . "\n" . $params["id"] . "\n" . $params["followuserid"] . "\n" . $params["accountage"] . "\nf" . strlen($params["name"]) . "\n" . $params["name"] . "\n" . strlen($params["membership"]) . "\n" . $params["membership"] . "\n" . strlen($params["countrycode"]) . "\n" . $params["countrycode"] . "\n0\n\n" . strlen($params["name"]) . "\n" . $params["name"];
        openssl_sign($ticket, $sig, $params["privatekey"], OPENSSL_ALGO_SHA1);
        $sig = base64_encode($sig);

        $ticket2 = $params["id"] . "\n" . $params["name"] . "\n" . $params["charapp"] . "\n" . $params["jobid"] . "\n" . date('n\/j\/Y\ g\:i\:s\ A');
        openssl_sign($ticket2, $sig2, $params["privatekey"], OPENSSL_ALGO_SHA1);
        $sig2 = base64_encode($sig2);

        $final = date('n\/j\/Y\ g\:i\:s\ A') . ";" . $sig2 . ";" . $sig . ";4";
    }
    return($final);
}

$years = [
    2016,
    2018
];

if(!isset($_REQUEST["year"])) exit(json_encode(["success"=>false,"message"=>"Please put the game year as \"year\", in GET or POST, make sure its in this: ".json_encode($years)."."], JSON_PRETTY_PRINT));
$year = (int)$_REQUEST["year"];
if(!in_array($year, $years)) exit(json_encode(["success"=>false,"message"=>"The year ".$year." was not found in ".json_encode($years)."."], JSON_PRETTY_PRINT));

if(!isset($_REQUEST["id"])) exit(json_encode(["success"=>false,"message"=>"Please put the user id as \"id\", in GET or POST."], JSON_PRETTY_PRINT));
if(!isset($_REQUEST["username"])) exit(json_encode(["success"=>false,"message"=>"Please put the username as \"username\", in GET or POST."], JSON_PRETTY_PRINT));
if(!isset($_REQUEST["charapp"])) exit(json_encode(["success"=>false,"message"=>"Please put the user charapp as \"charapp\", in GET or POST."], JSON_PRETTY_PRINT));
if(!isset($_REQUEST["jobid"])) exit(json_encode(["success"=>false,"message"=>"Please put the server jobid as \"jobid\", in GET or POST."], JSON_PRETTY_PRINT));
if(!isset($_REQUEST["privatekey"])) exit(json_encode(["success"=>false,"message"=>"Please put the privatekey as \"privatekey\", in GET or POST."], JSON_PRETTY_PRINT));

if($year === 2018) {
    if(!isset($_REQUEST["followuserid"])) exit(json_encode(["success"=>false,"message"=>"Please put the followuserid as \"followuserid\", in GET or POST."], JSON_PRETTY_PRINT));
    if(!isset($_REQUEST["accountage"])) exit(json_encode(["success"=>false,"message"=>"Please put the account age as \"accountage\", in GET or POST."], JSON_PRETTY_PRINT));
    if(!isset($_REQUEST["membership"])) exit(json_encode(["success"=>false,"message"=>"Please put the membership as \"membership\", in GET or POST."], JSON_PRETTY_PRINT));
    if(!isset($_REQUEST["countrycode"])) exit(json_encode(["success"=>false,"message"=>"Please put the country code as \"countrycode\", in GET or POST."], JSON_PRETTY_PRINT));
}

$params = [
    "id" => (int)$_REQUEST["id"],
    "name" => $_REQUEST["username"],
    "charapp" => $_REQUEST["charapp"],
    "jobid" => $_REQUEST["jobid"],
    "privatekey" => $_REQUEST["privatekey"],
];

if($year === 2018) {
    $params["followuserid"] = $_REQUEST["followuserid"];
    $params["accountage"] = $_REQUEST["accountage"];
    $params["membership"] = $_REQUEST["membership"];
    $params["countrycode"] = $_REQUEST["countrycode"];
}

if(isset($_REQUEST["sigma"])) $params["privatekey"] = $clientKeys["private"];

ob_start();
$ticket = generateClientTicket($year, $params);
$errors = ob_get_clean();

if(empty($errors) && $ticket)
    echo json_encode(["success"=>true,"ticket"=>$ticket], JSON_PRETTY_PRINT);
else
    echo json_encode(["success"=>false,"message"=>"Errors occurred while generating client ticket. This typically occurs when the private key is invalid."], JSON_PRETTY_PRINT);