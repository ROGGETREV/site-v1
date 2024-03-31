<?php
error_reporting(0);
$ver = (int)$_REQUEST["ver"] ?? 1;
$md5 = [
    "1" => "6301b74dc81a4a2a73c6148f9386ac5a",
    "2" => "6301b74dc81a4a2a73c6148f9386ac5a",
    "3" => "b0975f436aa4c8f9492a20cfd9011d61",
    "4" => "09f21e09d7e60e2fbfd91d5e46ac646e"
];
if(array_key_exists((string)$ver, $md5)) exit($md5[(string)$ver]);
echo "Unknown version";