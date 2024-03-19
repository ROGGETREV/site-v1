<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
if(isset($_REQUEST["userIds"])) $id = (int)$_REQUEST["userIds"];
else if($loggedin) $id = (int)$user["id"];
     else $id = 0;

echo json_encode([
    "targetId" => (int)$id,
    "state" => "Completed",
    "imageUrl" => "https://shitblx.cf/images/Users/Get.ashx?ID=".(int)$id,
    "version" => "TN3"
]);