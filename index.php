<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");

if(str_contains($_SERVER["HTTP_USER_AGENT"], "ROBLOX Android App")) {
    header('location: /Games.aspx');
    exit;
}

if($loggedin) {
    header('location: /Home.aspx');
} else {
    header('location: /Default.aspx');
}