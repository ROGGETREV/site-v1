<?php
if(!isset($_REQUEST["userId"])) {
    $_REQUEST["userId"] = 0;
}
$_REQUEST["ID"] = (int)$_REQUEST["userId"];
require_once($_SERVER["DOCUMENT_ROOT"]."/images/Users/Get.php");