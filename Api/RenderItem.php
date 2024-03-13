<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header("Content-Type: application/json");

if(!$loggedin) {
    exit(json_encode(["success"=>false,"message"=>"Please login"]));
}

if($user["permission"] !== "Administrator") exit(json_encode(["success"=>false,"message"=>"You can't render items without being an administrator"]));

$id = (int)$user["id"];
if(!isset($_REQUEST["ID"])) {
    exit(json_encode(["success"=>false,"message"=>"Please put an ID"]));
}
$id = (int)$_REQUEST["ID"];
$q = $con->prepare("SELECT * FROM `catalog` WHERE id = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$item = $q->fetch();

$characterScript = '
bodyColors = Instance.new("BodyColors", plr.Character)
bodyColors.HeadColor = BrickColor.new(1)
bodyColors.TorsoColor = BrickColor.new(1)
bodyColors.LeftArmColor = BrickColor.new(1)
bodyColors.RightArmColor = BrickColor.new(1)
bodyColors.LeftLegColor = BrickColor.new(1)
bodyColors.RightLegColor = BrickColor.new(1)
';


$q = $con->prepare("SELECT * FROM wearing WHERE user = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
foreach($q->fetchAll() as $wearing) {
    $qq = $con->prepare("SELECT * FROM `catalog` WHERE id = :id");
    $qq->bindParam(':id', $wearing["item"], PDO::PARAM_INT);
    $qq->execute();
    $item = $qq->fetch();
    if($item) {
        $name = "avatar".(int)rand();
        if($item["type"] === "shirt") {
            $characterScript .= '
'.$name.' = Instance.new("Shirt", plr.Character)
'.$name.'.Name = "'.addslashes($item["name"]).'"
'.$name.'.ShirtTemplate = "http://shitblx.cf/Asset/assets/shirt/'.(int)$item["id"].'.png"
';
        } else if($item["type"] === "tshirt") {
            $characterScript .= '
'.$name.' = Instance.new("Decal", plr.Character.Torso)
'.$name.'.Name = "'.addslashes($item["name"]).'"
'.$name.'.Texture = "http://shitblx.cf/Asset/assets/tshirt/'.(int)$item["id"].'.png"
';
        }
    }
}

$continue2008 = true;
$continue2011edited2016 = true;
$continue2016 = true;

// Start 2008

$script2008 = '
local plr = game.Players:CreateLocalPlayer(0)
plr:LoadCharacter()

'.$characterScript.'

print("Rendering user ID '.$id.' (2008)")
b64 = game:GetService("ThumbnailGenerator"):Click("PNG", 895, 895, true)
print("Done")
return b64';

$xml2008 = '<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:ns2="http://shitblx.cf/RCCServiceSoap" xmlns:ns1="http://shitblx.cf/" xmlns:ns3="http://shitblx.cf/RCCServiceSoap12">
    <SOAP-ENV:Body>
        <ns1:OpenJob>
            <ns1:job>
                <ns1:id>'.random_jobID().'</ns1:id>
                <ns1:expirationInSeconds>0.00000000000000000000000000000000001</ns1:expirationInSeconds>
                <ns1:category>1</ns1:category>
                <ns1:cores>321</ns1:cores>
            </ns1:job>
            <ns1:script>
                <ns1:name>Script</ns1:name>
                <ns1:script>
                    '.$script2008.'
                </ns1:script>
            </ns1:script>
        </ns1:OpenJob>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>';

$ch = curl_init($RCCS["renders"]["2008"]);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: text/xml"]);
curl_setopt($ch, CURLOPT_TIMEOUT, 2);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml2008);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res2008 = curl_exec($ch);

if(curl_errno($ch)) $continue2008 = false;

curl_close($ch);

if($continue2008) {
    $res2008 = str_replace(["LUA_TTABLE", "LUA_TSTRING"], "", $res2008);

    $res2008 = strstr($res2008, "<ns1:value>");

    $res2008 = str_replace(
        ["<ns1:value>", "</ns1:value></ns1:OpenJobResult><ns1:OpenJobResult><ns1:type></ns1:type><ns1:table></ns1:table></ns1:OpenJobResult></ns1:OpenJobResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>"],
        "",
        $res2008
    );

    file_put_contents($_SERVER["DOCUMENT_ROOT"]."/images/Users/2008_".(int)$id.".png", base64_decode($res2008));
}
// End 2008
// Start 2011

$q = $con->prepare("SELECT * FROM renderqueue WHERE `remote` = :id AND `type` = 'user'");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$renderQueue = $q->fetch();
if(!$renderQueue) {
    $q = $con->prepare("INSERT INTO `renderqueue` (`id`, `remote`, `type`, `client`) VALUES (NULL, :id, 'user', '2011')");
    $q->bindParam(':id', $id, PDO::PARAM_INT);
    $q->execute();
}

// End 2011
// Start 2011edited2016
$script2011edited2016 = '
local plr = game.Players:CreateLocalPlayer(0)
--plr.CharacterAppearance = "http://shitblx.cf/Game/CharacterFetch.ashx?ID='.(int)$id.'"
plr:LoadCharacter()

'.$characterScript.'

for i, v in pairs(plr.Character:GetChildren()) do
    if v.ClassName == "Part" then
        v.Material = "SmoothPlastic"
    end
end

print("Rendering user ID '.$id.' (2011edited2016)")
b64 = game:GetService("ThumbnailGenerator"):Click("PNG", 895, 895, true)
print("Done")
return b64';

$xml2011edited2016 = '<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:ns2="http://shitblx.cf/RCCServiceSoap" xmlns:ns1="http://shitblx.cf/" xmlns:ns3="http://shitblx.cf/RCCServiceSoap12">
    <SOAP-ENV:Body>
        <ns1:OpenJob>
            <ns1:job>
                <ns1:id>'.random_jobID().'</ns1:id>
                <ns1:expirationInSeconds>0.00000000000000000000000000000000001</ns1:expirationInSeconds>
                <ns1:category>1</ns1:category>
                <ns1:cores>321</ns1:cores>
            </ns1:job>
            <ns1:script>
                <ns1:name>Script</ns1:name>
                <ns1:script>
                    '.$script2011edited2016.'
                </ns1:script>
            </ns1:script>
        </ns1:OpenJob>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>';

$ch = curl_init($RCCS["renders"]["2016"]);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: text/xml"]);
curl_setopt($ch, CURLOPT_TIMEOUT, 2);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml2011edited2016);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res2011edited2016 = curl_exec($ch);

if(curl_errno($ch)) $continue2011edited2016 = false;

curl_close($ch);

if($continue2011edited2016) {
    $res2011edited2016 = str_replace(["LUA_TTABLE", "LUA_TSTRING"], "", $res2011edited2016);

    $res2011edited2016 = strstr($res2011edited2016, "<ns1:value>");

    $res2011edited2016 = str_replace(
        ["<ns1:value>", "</ns1:value></ns1:OpenJobResult><ns1:OpenJobResult><ns1:type></ns1:type><ns1:table></ns1:table></ns1:OpenJobResult></ns1:OpenJobResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>"],
        "",
        $res2011edited2016
    );

    file_put_contents($_SERVER["DOCUMENT_ROOT"]."/images/Users/2011edited2016_".(int)$id.".png", base64_decode($res2011edited2016));
}

// End 2011edited2016
// Start 2016

$script2016 = '
game:GetService("ContentProvider"):SetBaseUrl("http://shitblx.cf/")
game:GetService("ScriptContext").ScriptsDisabled = true
--still didnt work without the scripts on top of this

local plr = game.Players:CreateLocalPlayer(0)
--plr.CharacterAppearance = "http://shitblx.cf/Game/CharacterFetch.ashx?ID='.(int)$id.'"
plr:LoadCharacter()d

'.$characterScript.'

print("Rendering user ID '.$id.' (2016)")
b64 = game:GetService("ThumbnailGenerator"):Click("PNG", 895, 895, false)
print("Done")
return b64';

$xml2016 = '<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:ns2="http://shitblx.cf/RCCServiceSoap" xmlns:ns1="http://shitblx.cf/" xmlns:ns3="http://shitblx.cf/RCCServiceSoap12">
    <SOAP-ENV:Body>
        <ns1:OpenJob>
            <ns1:job>
                <ns1:id>'.random_jobID().'</ns1:id>
                <ns1:expirationInSeconds>0.00000000000000000000000000000000001</ns1:expirationInSeconds>
                <ns1:category>1</ns1:category>
                <ns1:cores>321</ns1:cores>
            </ns1:job>
            <ns1:script>
                <ns1:name>Script</ns1:name>
                <ns1:script>
                    '.$script2016.'
                </ns1:script>
            </ns1:script>
        </ns1:OpenJob>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>';

$ch = curl_init($RCCS["renders"]["2016"]);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: text/xml"]);
curl_setopt($ch, CURLOPT_TIMEOUT, 2);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml2016);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res2016 = curl_exec($ch);

if(curl_errno($ch)) $continue2016 = false;

curl_close($ch);

if($continue2016) {
    $res2016 = str_replace(["LUA_TTABLE", "LUA_TSTRING"], "", $res2016);

    $res2016 = strstr($res2016, "<ns1:value>");

    $res2016 = str_replace(
        ["<ns1:value>", "</ns1:value></ns1:OpenJobResult><ns1:OpenJobResult><ns1:type></ns1:type><ns1:table></ns1:table></ns1:OpenJobResult></ns1:OpenJobResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>"],
        "",
        $res2016
    );

    file_put_contents($_SERVER["DOCUMENT_ROOT"]."/images/Users/2016_".(int)$id.".png", base64_decode($res2016));
}

// End 2016

echo json_encode(["success"=>true,"timeoutRemaining"=>$timeoutRemaining]);