<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header("Content-Type: text/xml");
if(!isset($_REQUEST["userId"])) exit;
$id = (int)$_REQUEST["userId"];
$q = $con->prepare("SELECT * FROM users WHERE id = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$usr = $q->fetch();
if(!$usr) exit;
$bodyColors = json_decode($usr["bodyColors"], true);
?>
<roblox xmlns:xmime="http://www.w3.org/2005/05/xmlmime" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://www.shitblx.cf/roblox.xsd" version="4">
    <External>null</External>
    <External>nil</External>
    <Item class="BodyColors">
        <Properties>
            <string name="Name">Body Colors</string>
            <int name="HeadColor"><?php echo (int)$bodyColors["head"]; ?></int>
            <int name="TorsoColor"><?php echo (int)$bodyColors["torso"]; ?></int>
            <int name="LeftArmColor"><?php echo (int)$bodyColors["leftarm"]; ?></int>
            <int name="RightArmColor"><?php echo (int)$bodyColors["rightarm"]; ?></int>
            <int name="LeftLegColor"><?php echo (int)$bodyColors["leftleg"]; ?></int>
            <int name="RightLegColor"><?php echo (int)$bodyColors["rightleg"]; ?></int>
            <bool name="archivable">true</bool>
        </Properties>
    </Item>
</roblox>