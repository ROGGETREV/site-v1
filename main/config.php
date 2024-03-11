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

function filterBadWords($string) {
    $superSafeChat = false;
    global $loggedin;
    if($loggedin) {
        global $user;
        if($user["underage"] == 1) {
            $superSafeChat = true;
        }
    }
    $badWords = [
        "fuck",
        "shit",
        "niga",
        "iga",
        "nigga",
        "igga",
        "niggga",
        "iggga",
        "nigggga",
        "igggga",
        "niger",
        "nigger",
        "niggger",
        "nigggger",
        "stfu",
        "fxck",
        "fawk",
        "bitch",
        "bitche",
        "bitches",
        "bitchs",
        "lmao",
        "lmfao",
        "wtf",
        "tf",
        "kys",
        "kms",
        "ass",
        "dick",
        "boobs",
        "boob",
        "pussy",
        "puss",
        "damn",
        "faggot",
        "fagot",
        "fag",
        "faggt",
        "fagt",

        "yomi",
        "madblox",
        "madblxx",
        "sigma",
        "rizz",
        
        "fdp",
        "ntm",
        "nique ta mère",
        "nique",
        "ta mère",
        "ta mere",
        "pute",
    ];

    if($superSafeChat == true) {
        array_push($badWords,"underage");
    }

    $exceptions = [
        "mini-games",
        "mini games",
        "minigames",
        "classic"
    ];

    $string = preg_replace('/[\x{00}-\x{1F}\x{7F}]/u', '', $string);

    foreach ($badWords as $badWord) {
        if(in_array($badWord, $exceptions)) {
            return $word;
        }
        $badWordPattern = preg_replace('/\s+/', '\s*', preg_quote($badWord, '/'));
        $string = preg_replace_callback('/' . $badWordPattern . '/iu', function ($matches) use ($exceptions) {
            $word = $matches[0];
            return str_repeat('#', strlen($matches[0]));
        }, $string);
    }

    return $string;
}

if($loggedin) {
    if((int)$user["banned"] === 1) {
        if(!in_array($_SERVER["PHP_SELF"], [
            "/UserAuthentication/LogOut.php",
            "/not-approved.php"
        ])) {
            header('location: /not-approved.ashx');
            exit;
        }
    } else {
        if(in_array($_SERVER["PHP_SELF"], [
            "/not-approved.php"
        ])) {
            header('location: /Home.ashx');
            exit;
        }
    }
}

if(!empty($_SERVER["PHP_AUTH_USER"]) && !empty($_SERVER["PHP_AUTH_PW"])) {
    if($_SERVER["PHP_AUTH_USER"] !== "nolanwhy" || $_SERVER["PHP_AUTH_PW"] !== "poopfart46") {
        header('WWW-Authenticate: Basic realm="ROGGET"');
        exit;
    }
} else {
    header('WWW-Authenticate: Basic realm="ROGGET"');
    exit;
}

function datetime($unix) {
    $now = time();
    $diff = $unix - $now;
    
    if($diff < 0) {
        $diff = abs($diff);
        if($diff < 60) {
            return ($diff <= 1) ? 'now' : $diff . ' seconds ago';
        } elseif($diff < 3600) {
            $minutes = floor($diff / 60);
            return ($minutes == 1) ? '1 minute ago' : $minutes . ' minutes ago';
        } elseif($diff < 86400) {
            $hours = floor($diff / 3600);
            return ($hours == 1) ? '1 hour ago' : $hours . ' hours ago';
        } elseif($diff < 2592000) {
            $days = floor($diff / 86400);
            return ($days == 1) ? '1 day ago' : $days . ' days ago';
        } elseif($diff < 31536000) {
            $months = floor($diff / 2592000);
            return ($months == 1) ? '1 month ago' : $months . ' months ago';
        } else {
            $years = floor($diff / 31536000);
            return ($years == 1) ? '1 year ago' : $years . ' years ago';
        }
    } elseif($diff < 60) {
        return ($diff <= 1) ? 'now' : 'in ' . $diff . ' seconds';
    } elseif($diff < 3600) {
        $minutes = floor($diff / 60);
        return ($minutes == 1) ? 'in 1 minute' : 'in ' . $minutes . ' minutes';
    } elseif($diff < 86400) {
        $hours = floor($diff / 3600);
        return ($hours == 1) ? 'in 1 hour' : 'in ' . $hours . ' hours';
    } elseif($diff < 2592000) {
        $days = floor($diff / 86400);
        return ($days == 1) ? 'in 1 day' : 'in ' . $days . ' days';
    } elseif($diff < 31536000) {
        $months = floor($diff / 2592000);
        return ($months == 1) ? 'in 1 month' : 'in ' . $months . ' months';
    } else {
        $years = floor($diff / 31536000);
        return ($years == 1) ? 'in 1 year' : 'in ' . $years . ' years';
    }
}

// TODO: use this in user get and catalog get
function exitFile($file) {
    exit(file_get_contents($file));
}