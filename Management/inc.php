<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");

if(!$loggedin) {
    header('location: /Default.aspx');
    exit;
}
if(!in_array($user["permission"], [
    "Moderator",
    "Administrator"
])) {
    header('location: /request-error.aspx?code=403');
    exit;
}