<?php
if(isset($_REQUEST["redir"])) {
    if(!str_starts_with($_REQUEST["redir"], "/") || str_starts_with($_REQUEST["redir"], "//")) {
        exit("Oh no! Somebody has probably tried to scam you!<h2>What happened?</h2>On some old ROBLOX clients, we have to use Asset links to redirect to other links. It doesn't work if we don't.<br><strong>But</strong>, the security check failed and this redirect link was not approved.<h2>What do I do?</h2>You're safe, ROGGET protected you 😎.<br>If this got sent by somebody, please block them and report them to a staff member ASAP");
    }
    header("location: ".$_REQUEST["redir"]);
    exit;
}
if($_REQUEST["id"] === "niggaaaaaaaaaa") {
    // header('location: /NORMAL ELEVATOR HALLOWEEN 16.rbxl');
    // header('location: /pcc.rbxl');
    header('location: /sr4.rbxl');
    // header('location: /MeepCity.rbxl');
    exit;
}
if(!isset($_REQUEST["id"]) || empty($_REQUEST["id"])) {
    header('location: https://assetdelivery.roblox.com/v1/asset?'.$_SERVER["QUERY_STRING"]);
    exit;
}
if(file_exists("assets/other/".$_REQUEST["id"])) {
    header("location: assets/other/".$_REQUEST["id"]);
    exit;
}
header('location: https://assetdelivery.roblox.com/v1/asset?'.$_SERVER["QUERY_STRING"]);