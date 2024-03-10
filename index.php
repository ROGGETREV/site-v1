<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");

if($loggedin) {
    header('location: /Home.aspx');
} else {
    header('location: /Default.aspx');
}