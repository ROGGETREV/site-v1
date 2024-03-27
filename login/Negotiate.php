<?php
if(isset($_REQUEST["authentication"])) {
    setcookie('.gameAuthentication', $_REQUEST["authentication"], time() + 31536000, "/");
    setcookie('.gameAuthentication', $_REQUEST["authentication"], time() + 31536000, "/", "shitblx.cf");
    setcookie('.gameAuthentication', $_REQUEST["authentication"], time() + 31536000, "/", ".shitblx.cf");
}