<?php
/*
    ROGGET Website Source Code and APIs

    Make sure to have 2 databases: roggetdev and roggetprod.
*/
$developement = true;
$sql = [
    "server" => "localhost",
    "dbname" => "roggetdev",
    "user" => "root",
    "pass" => "NeverGonnaGiveYouUp!?69fg-"
];
$developement ? $sql["dbname"] = "roggetdev" : $sql["dbname"] = "roggetprod";
if(!$developement) error_reporting(0);
try{
    $con = new PDO("mysql:host=".$sql["server"].";dbname=".$sql["dbname"], $sql["user"], $sql["pass"]);
} catch(PDOException $e) {
    if($developement) exit("Database problem detected! Please wait until the developers fix it and try again.<br>Error: ".$e->getMessage());
    exit("Database problem detected! Please wait until the developers fix it and try again.");
}

$loggedin = false;

$siteTheme = "dark";//"light";

$RCCS = [
    "renders" => [
        "2008" => "26.41.174.225:8541",
        "2016" => "26.41.174.225:8542"
    ]
];

$reCAPTCHA = [
    "site" => "6LfsGoIpAAAAAFXTH4Gfwx-un3YB1H7d_3YtCgAm",
    "secret" => "6LfsGoIpAAAAAKcVjMKXd02bEpdhZo3vKZS6jGfc"
];

if(isset($_COOKIE["_ROGGETSECURITY"])) {
    $q = $con->prepare("SELECT * FROM sessions WHERE sessKey = :sessKey");
    $q->bindParam(':sessKey', $_COOKIE["_ROGGETSECURITY"], PDO::PARAM_STR);
    $q->execute();
    $session = $q->fetch();
    if($session) {
        $q = $con->prepare("SELECT * FROM users WHERE id = :id");
        $q->bindParam(':id', $session["userId"], PDO::PARAM_INT);
        $q->execute();
        $user = $q->fetch();
        if($user) {
            $loggedin = true;
        }
    } else {
        setcookie(".ROGGETSECURITY", null, -1, "/");
    }
}

if($loggedin) {
    $time = time();
    $q = $con->prepare("UPDATE users SET lastonline = :time WHERE id = :id");
    $q->bindParam(':time', $time, PDO::PARAM_INT);
    $q->bindParam(':id', $user["id"], PDO::PARAM_INT);
    $q->execute();
}

$serverAPIKey = "EHbKaHdKKrWlRfxneJkbEUWo9vZVLE64";

function random_jobID() {
    return random_int(1, getrandmax()).bin2hex(random_bytes(200)).rand(1, getrandmax());
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        rand(0, 0xffff), rand(0, 0xffff),
        rand(0, 0xffff),
        random_int(0, 0x0fff) | 0x4000,
        random_int(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

$discord = [
    "clientid" => "1214360705889996900",
    "clientsecret" => "VxBulJ6UdEFweAkmetv9NvV_6DhVTW8b"
];

function getDiscordUserInfoFromAccessToken($token) {
    $ch = curl_init("https://discord.com/api/users/@me");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [ "Authorization: Bearer ".$token ]);

    return json_decode(curl_exec($ch), true);
}

if($loggedin) {
    if(!$user["discord_verified"] && !in_array($_SERVER["PHP_SELF"], [
        "/Api/DiscordVerification.php",
        "/DiscordVerify.php",
        "/UserAuthentication/LogOut.php"
    ])) {
        header('location: /DiscordVerify.ashx');
        exit;
    }
    if($user["discord_verified"] && (time() - 100000) >= $user["discord_expires_in"]) {
        $ch = curl_init("https://discord.com/api/oauth2/token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            "grant_type" => "refresh_token",
            "refresh_token" => $user["discord_refresh_token"]
        ]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [ "Content-Type: application/x-www-form-urlencoded" ]);
        curl_setopt($ch, CURLOPT_USERPWD, $discord["clientid"].":".$discord["clientsecret"]);

        $res = json_decode(curl_exec($ch), true);

        if(!curl_errno($ch) && !isset($res["error"])){
            $expires = time() + $res["expires_in"];
            $q = $con->prepare("UPDATE users SET discord_access_token = :atoken, discord_refresh_token = :rtoken, discord_expires_in = :expire WHERE id = :id");
            $q->bindParam(':atoken', $res["access_token"], PDO::PARAM_STR);
            $q->bindParam(':rtoken', $res["refresh_token"], PDO::PARAM_STR);
            $q->bindParam(':expire', $expires, PDO::PARAM_INT);
            $q->bindParam(':id', $user["id"], PDO::PARAM_INT);
            $q->execute();
        } else {
            $time = time();
            $q = $con->prepare("UPDATE users SET discord_verified = false, discord_time_since_no_verification = :time WHERE id = :id");
            $q->bindParam(':time', $time, PDO::PARAM_INT);
            $q->bindParam(':id', $user["id"], PDO::PARAM_INT);
            $q->execute();
            header('location: /DiscordVerify.ashx');
            exit;
        }

        curl_close($ch);
    } else {
        if((time() - $user["discord_time_since_no_verification"]) >= 86400) {
            $q = $con->prepare("DELETE FROM users WHERE id = :id");
            $q->bindParam(':id', $user["id"], PDO::PARAM_INT);
            $q->execute();
            header('location: /UserAuthentication/LogOut.ashx');
            exit;
        }
    }
}