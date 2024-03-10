<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header("Content-Type: application/json");

if(!$loggedin) exit(json_encode(["success"=>false,"message"=>"Please login"]));

if($user["permission"] !== "Administrator") exit(json_encode(["success"=>false,"message"=>"You can't render items without being an administrator"]));

if(!isset($_REQUEST["ID"])) exit(json_encode(["success"=>false,"message"=>"No ID specified"]));
$id = (int)$_REQUEST["ID"];

$q = $con->prepare("SELECT * FROM catalog WHERE id = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$item = $q->fetch();
if(!$item) exit(json_encode(["success"=>false,"message"=>"Item does not exist"]));
if($item["moderation"] === "Refused") exit(json_encode(["success"=>false,"message"=>"Item is banned"]));

$script = '
game.Players:CreateLocalPlayer(0)
game.Players.LocalPlayer:LoadCharacter()
bodyColors = Instance.new("BodyColors", game.Players.LocalPlayer) --.Character
bodyColors.HeadColor = BrickColor.new(25)
bodyColors.LeftArmColor = BrickColor.new(25)
bodyColors.RightArmColor = BrickColor.new(25)
bodyColors.LeftLegColor = BrickColor.new(25)
bodyColors.RightLegColor = BrickColor.new(25)
bodyColors.TorsoColor = BrickColor.new(25)

print("Rendering item ID '.$id.'")
b64 = game:GetService("ThumbnailGenerator"):Click("PNG", 720, 720, true)
print("Done")
return b64';

$xml = '<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:ns2="http://shitblx.cf/RCCServiceSoap" xmlns:ns1="http://shitblx.cf/" xmlns:ns3="http://shitblx.cf/RCCServiceSoap12">
    <SOAP-ENV:Body>
        <ns1:OpenJob>
            <ns1:job>
                <ns1:id>'.random_uuidv4().'</ns1:id>
                <ns1:expirationInSeconds>0.00000000000000000000000000000000001</ns1:expirationInSeconds>
                <ns1:category>1</ns1:category>
                <ns1:cores>321</ns1:cores>
            </ns1:job>
            <ns1:script>
                <ns1:name>Script</ns1:name>
                <ns1:script>
                    '.$script.'
                </ns1:script>
            </ns1:script>
        </ns1:OpenJob>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>';

$ch = curl_init("127.0.0.1:8541");
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: text/xml"]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);

if(curl_errno($ch)) exit(["success"=>false,"message"=>"Could not access the RCCService"]);

curl_close($ch);

$res = str_replace(["LUA_TTABLE", "LUA_TSTRING"], "", $res);

$res = strstr($res, "<ns1:value>");

$res = str_replace(
    ["<ns1:value>", "</ns1:value></ns1:OpenJobResult><ns1:OpenJobResult><ns1:type></ns1:type><ns1:table></ns1:table></ns1:OpenJobResult></ns1:OpenJobResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>"],
    "",
    $res
);

$decoded = base64_decode($res);
file_put_contents($_SERVER["DOCUMENT_ROOT"]."/images/Catalog/".(int)$id.".png", $decoded);
echo json_encode(["success"=>true,"render"=>"/images/Catalog/".(int)$id.".png"]);