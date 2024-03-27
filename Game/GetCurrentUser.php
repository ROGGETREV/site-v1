<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
if($loggedin) exit((string)$user["id"]);
echo 0;