<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
header("Content-Type: application/json");

if(!$loggedin) {
    exit(json_encode(["success"=>false,"message"=>"Please login"]));
}

if(!isset($_REQUEST["csrf_token"])) exit(json_encode(["success"=>false,"message"=>"Please put the csrf_token"]));

if(!isCorrectCSRF($_REQUEST["csrf_token"])) {
    if(isset($_SERVER["HTTP_REFERER"])) warnCSRF($_SERVER["HTTP_REFERER"]);
    exit(json_encode(["success"=>false,"message"=>"Invalid csrf_token"]));
}

$id = (int)$user["id"];
if(isset($_REQUEST["ID"])) {
    if($user["permission"] === "Administrator") {
        $id = (int)$_REQUEST["ID"];
    } else {
        exit(json_encode(["success"=>false,"message"=>"You can't render other users without being an administrator"]));
    }
}
$renderUser = $user;
if($id !== (int)$user["id"]) {
    $q = $con->prepare("SELECT * FROM users WHERE id = :id");
    $q->bindParam(':id', $id, PDO::PARAM_INT);
    $q->execute();
    $renderUser = $q->fetch();
    if(!$renderUser) {
        exit(json_encode(["success"=>false,"message"=>"User doesn't exist"]));
    }
}

$timeoutRemaining = 0;
if((time() - (int)$renderUser["lastRender"]) < 10) {
    $timeoutRemaining = 10 - (time() - (int)$renderUser["lastRender"]);
    exit(json_encode(["success"=>false,"message"=>"Timed out","timeoutRemaining"=>$timeoutRemaining]));
}
$time = time();
$q = $con->prepare("UPDATE users SET lastRender = :time WHERE id = :id");
$q->bindParam(':time', $time, PDO::PARAM_INT);
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$user["lastRender"] = $time;
$timeoutRemaining = 10;

$bodyColors = json_decode($renderUser["bodyColors"], true);

$characterScript = '
bodyColors = Instance.new("BodyColors", plr.Character)
bodyColors.HeadColor = BrickColor.new('.(int)$bodyColors["head"].')
bodyColors.TorsoColor = BrickColor.new('.(int)$bodyColors["torso"].')
bodyColors.LeftArmColor = BrickColor.new('.(int)$bodyColors["leftarm"].')
bodyColors.RightArmColor = BrickColor.new('.(int)$bodyColors["rightarm"].')
bodyColors.LeftLegColor = BrickColor.new('.(int)$bodyColors["leftleg"].')
bodyColors.RightLegColor = BrickColor.new('.(int)$bodyColors["rightleg"].')
';

$characterScript2008 = $characterScript;

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
            $shit = '
'.$name.' = Instance.new("Shirt", plr.Character)
'.$name.'.Name = "'.addslashes($item["name"]).'"
'.$name.'.ShirtTemplate = "http://shitblx.cf/Asset/?redir=/Asset/assets/shirt/'.(int)$item["id"].'.png"
';
            $characterScript .= $shit;
            $characterScript2008 .= $shit;
        } else if($item["type"] === "pants") {
            $shit = '
'.$name.' = Instance.new("Pants", plr.Character)
'.$name.'.Name = "'.addslashes($item["name"]).'"
'.$name.'.PantsTemplate = "http://shitblx.cf/Asset/?redir=/Asset/assets/pants/'.(int)$item["id"].'.png"
';
            $characterScript .= $shit;
            $characterScript2008 .= $shit;
        } else if($item["type"] === "face") {
            $characterScript .= '
plr.Character.Head.face.Texture = "http://shitblx.cf/Asset/?redir=/Asset/assets/face/'.(int)$item["id"].'.png"
';
            $characterScript2008 .= '
plr.Character.Head.face.Texture = "http://shitblx.cf/Asset/?redir=/Asset/assets/face/'.(int)$item["id"].'_stretch.png"
';
        } else if($item["type"] === "tshirt") {
            $shit = '
'.$name.' = Instance.new("Decal", plr.Character.Torso)
'.$name.'.Name = "'.addslashes($item["name"]).'"
'.$name.'.Texture = "http://shitblx.cf/Asset/?redir=/Asset/assets/tshirt/'.(int)$item["id"].'.png"
';
            $characterScript .= $shit;
            $characterScript2008 .= $shit;
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

'.$characterScript2008.'

print("Rendering user ID '.$id.' (2008)")
b64 = game:GetService("ThumbnailGenerator"):Click("PNG", 1024, 1024, true)
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

$script2011 = 'local plr = game.Players:CreateLocalPlayer(0)
plr.CharacterAppearance = "http://shitblx.cf/Game/CharacterFetch.ashx?userId='.(int)$id.'"
plr:LoadCharacter()

';

$q = $con->prepare("SELECT * FROM renderqueue WHERE `remote` = :id AND `type` = 'user'");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$renderQueue = $q->fetch();
if(!$renderQueue) {
    $q = $con->prepare("INSERT INTO `renderqueue` (`id`, `remote`, `type`, `client`, `script`) VALUES (NULL, :id, 'user', '2011', :script)");
    $q->bindParam(':id', $id, PDO::PARAM_INT);
    $q->bindParam(':script', $script2011, PDO::PARAM_STR);
    $q->execute();
}

// End 2011
// Start 2011edited2016
$script2011edited2016 = '
game:GetService("ContentProvider"):SetBaseUrl("http://shitblx.cf/")
game:GetService("ScriptContext").ScriptsDisabled = true

local plr = game.Players:CreateLocalPlayer(0)
--plr.CharacterAppearance = "http://shitblx.cf/Asset/?redir=/Game/CharacterFetch.ashx?userId='.(int)$id.'"
plr:LoadCharacter()

'.$characterScript.'

for i, v in pairs(plr.Character:GetChildren()) do
    if v.ClassName == "Part" then
        v.Material = "SmoothPlastic"
    end
end

print("Rendering user ID '.$id.' (2011edited2016)")
b64 = game:GetService("ThumbnailGenerator"):Click("PNG", 1024, 1024, true)
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

local plr = game.Players:CreateLocalPlayer(0)
--plr.CharacterAppearance = "http://shitblx.cf/Asset/?redir=/Game/CharacterFetch.ashx?userId='.(int)$id.'"
plr:LoadCharacter()

'.$characterScript.'

--local FOV = 40 --52.5
--local AngleOffsetX = 0
--local AngleOffsetY = 0
--local AngleOffsetZ = 0
--
--local areThereAccessories = false
--local largestSize = Vector3.new(0, 0, 0)
--local accessorySize = Vector3.new(0, 0, 0)
--for i, accessory in pairs(plr.Character:GetChildren()) do
--    if accessory.ClassName == "Accessory" then
--    areThereAccessories = true
--        local accessoryHandle = accessory.Handle
--        if accessoryHandle then
--            accessorySize = accessoryHandle.Size
--        end
--        if accessorySize.y > largestSize.y then
--            largestSize = accessorySize
--        end
--    end
--end
--
--local CameraAngle = plr.Character.Head.CFrame * CFrame.new(AngleOffsetX, AngleOffsetY, AngleOffsetZ)
--local CameraPosition = plr.Character.Head.CFrame + Vector3.new(0, 0, 0) + (CFrame.Angles(0, -3.4, 0).lookVector.unit * -3)
--
--if areThereAccessories == true then
--    print("Old FOV: "..FOV)
--    FOV = (FOV + (largestSize.y / 0.2))
--    print("New FOV: "..FOV)
--    CameraAngle = plr.Character.Head.CFrame * CFrame.new(AngleOffsetX, AngleOffsetY, AngleOffsetZ)
--    --CameraPosition = plr.Character.Head.CFrame + Vector3.new(0, largestSize.y/2, 0) + (CFrame.Angles(0, -3.4, 0).lookVector.unit * -3)
--end
--
--local Camera = Instance.new("Camera", plr.Character)
--Camera.Name = "ThumbnailCamera"
--Camera.CameraType = Enum.CameraType.Scriptable
--
--Camera.CoordinateFrame = CFrame.new(CameraPosition.p, CameraAngle.p)
--Camera.FieldOfView = FOV
--workspace.CurrentCamera = Camera

print("Rendering user ID '.$id.' (2016)")
b64 = game:GetService("ThumbnailGenerator"):Click("PNG", 1024, 1024, true)
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