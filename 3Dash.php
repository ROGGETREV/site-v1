
<?php
/*
- level id
- name
- creator
- difficulty
```
 0     1     2     3      4      5
easy normal hard harder insane demon
```
recent level limit: 30
*/
$url = "http://delugedrip.com:30924/3Dash";
$version = "1.2.1";
$token = "n";
if(isset($_REQUEST["api"]) || isset($_REQUEST["url"])) {
    $url = $_REQUEST["api"] ?? $_REQUEST["url"];
}
javascript('console.log("API is '.$url.'");');
if(isset($_REQUEST["ver"])) {
    $version = $_REQUEST["ver"];
}
javascript('console.log("Version is '.$version.'");');
if(isset($_REQUEST["token"])) {
    $token = $_REQUEST["token"];
    javascript('console.log("Token is '.$token.'");');
}
if(isset($_REQUEST["dl"])) {
    // header('Content-Type: application/json');
}

function javascript($code) {
    echo "<script>".$code."</script>";
}

function postRequest($url, $data) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_TIMEOUT, 2000);
    return $ch;
}

function authenticate(&$ch, $token) {
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: $token"
    ));
}

function applyVersion(&$ch, $version) {
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Version: $version"
    ));
}

function authenticationRoutine() {
    global $url, $version, $token;

    $ch = postRequest($url."/login", "bean");
    curl_setopt($ch, CURLOPT_TIMEOUT, 2000);
    applyVersion($ch, $version);

    $response = curl_exec($ch);

    if ($response !== false) {
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode === 200 && !isset($_REQUEST["token"])) {
            $token = $response;
            javascript('console.log("Token is '.$token.'");');
        }
    }

    curl_close($ch);
}

function fixStr($str) {
    return str_replace("\n", "<br>", $str);
}

authenticationRoutine();
echo "Token: $token<br>Trying to get recent...";

if(isset($_REQUEST["dl"])) {
    echo "<br>Requested download";
    $ch = curl_init($url."/download/".(int)$_REQUEST["dl"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: $token",
        "Version: $version"
    ));
    curl_setopt($ch, CURLOPT_TIMEOUT, 2000);
    echo "<br><strong>".fixStr(curl_exec($ch))."</strong>";
    curl_close($ch);
} else {
    echo "<br>Did not request download";
    $ch = curl_init($url."/recent");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: $token",
        "Version: $version"
    ));
    curl_setopt($ch, CURLOPT_TIMEOUT, 2000);
    echo "<br><strong>".fixStr(curl_exec($ch))."</strong>";
    curl_close($ch);
}