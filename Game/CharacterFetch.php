<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header('Content-Type: text/plain');
if(!isset($_REQUEST["userId"])) exit;
$id = (int)$_REQUEST["userId"];
$q = $con->prepare("SELECT * FROM users WHERE id = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$usr = $q->fetch();
if(!$usr) exit;
$return = "http://".$_SERVER["SERVER_NAME"];
if(!isset($_REQUEST["noredir"])) $return .= "/Asset/?redir=";
$return .= "/Asset/BodyColors.ashx/?userId=$id;";

$q = $con->prepare("SELECT * FROM wearing WHERE user = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
foreach($q->fetchAll() as $wearing) {
    $return .= "http://".$_SERVER["SERVER_NAME"];
    if(!isset($_REQUEST["noredir"])) $return .= "/Asset/?redir=";
    $return .= "/Api/FetchAvatarItem.ashx?ID=".(int)$wearing["item"].";";
}
echo substr($return, 0, -1);