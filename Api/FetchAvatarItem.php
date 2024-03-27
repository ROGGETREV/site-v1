<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header("Content-Type: text/xml");
if(!isset($_REQUEST["ID"])) exit;
$id = (int)$_REQUEST["ID"];
$q = $con->prepare("SELECT * FROM `catalog` WHERE id = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$item = $q->fetch();
if(!$item) exit;
if(in_array($item["type"], [
    "shirt",
    "pants"
])) {
?><roblox xmlns:xmime="http://www.w3.org/2005/05/xmlmime" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://www.shitblx.cf/roblox.xsd" version="4">
	<External>null</External>
	<External>nil</External>
	<Item class="<?php echo ucwords($item["type"]); ?>" referent="RBX0">
		<Properties>
			<Content name="<?php echo ucwords($item["type"]); ?>Template"><url>http://<?php echo $_SERVER["SERVER_NAME"]; ?>/Asset/?redir=/Asset/assets/<?php echo $item["type"]; ?>/<?php echo (int)$id; ?>.png</url></Content>
			<string name="Name"><?php echo htmlspecialchars($item["name"]); ?></string>
			<bool name="archivable">true</bool>
		</Properties>
	</Item>
</roblox><?php } else if($item["type"] === "tshirt") { ?><roblox xmlns:xmime="http://www.w3.org/2005/05/xmlmime" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://www.shitblx.cf/roblox.xsd" version="4">
    <External>null</External>
    <External>nil</External>
    <Item class="ShirtGraphic" referent="RBX0">
        <Properties>
            <Content name="Graphic">
                <url>http://shitblx.cf/Asset/?redir=/Asset/assets/<?php echo $item["type"]; ?>/<?php echo (int)$id; ?>.png</url>
            </Content>
            <string name="Name"><?php echo htmlspecialchars($item["name"]); ?></string>
            <bool name="archivable">true</bool>
        </Properties>
    </Item>
</roblox><?php } else if($item["type"] === "face") { ?><roblox xmlns:xmime="http://www.w3.org/2005/05/xmlmime" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://www.shitblx.cf/roblox.xsd" version="4">
    <External>null</External>
    <External>nil</External>
    <Item class="Decal" referent="RBX0">
        <Properties>
            <token name="Face">5</token>
            <string name="Name">face</string>
            <float name="Shiny">20</float>
            <float name="Specular">0</float>
            <Content name="Texture">
                <url>http://shitblx.cf/Asset/?redir=/Asset/assets/<?php echo $item["type"]; ?>/<?php echo (int)$id; ?>.png</url>
            </Content>
            <bool name="archivable">true</bool>
        </Properties>
    </Item>
</roblox><?php } ?>