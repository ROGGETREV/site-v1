<?php
error_reporting(0);
$ver = (int)$_REQUEST["ver"] ?? 1;
while(file_exists("Update".($ver + 1).".zip")) {
    $ver++;
}
echo $ver;