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
if(!$developement) error_reporting(0); else error_reporting(E_ALL);
try{
    $con = new PDO("mysql:host=".$sql["server"].";dbname=".$sql["dbname"], $sql["user"], $sql["pass"]);
} catch(sPDOException $e) {
    echo "Database problem detected! Please wait until the developers fix it and try again.";
    if($developement) echo "<br>Error: ".$e->getMessage();
    exit;
}

$containerClasses = "container card card-body";// advertisement ad";

$cloudflare = false;
if(isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
    $cloudflare = true;
    $_SERVER["CLOUDFLARE_IP"] = $_SERVER["REMOTE_ADDR"];
    $_SERVER["REMOTE_ADDR"] = $_SERVER["HTTP_CF_CONNECTING_IP"];
}

$maintenance = [
    "enabled" => false,
    "reason" => "Currently moving servers, check back soon!"
];

if($maintenance["enabled"] && !in_array($_SERVER["PHP_SELF"], [
    "/maintenance.php",
    "/images/Users/Get.php",
    "/Api/Maintenance.php"
])) {
    header('location: /maintenance.aspx');
    exit;
}

require_once($_SERVER["DOCUMENT_ROOT"]."/Assemblies/Roblox/Grid/Rcc/RCCServiceSoap.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/Assemblies/Roblox/Grid/Rcc/Job.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/Assemblies/Roblox/Grid/Rcc/LuaType.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/Assemblies/Roblox/Grid/Rcc/LuaValue.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/Assemblies/Roblox/Grid/Rcc/ScriptExecution.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/Assemblies/Roblox/Grid/Rcc/Status.php");

$loggedin = false;

$guestEnabled = true;

$enableInviteKeys = true;
$enableDiscordVerification = true;

$roggetServersIPs = [
    "90.78.85.2",
    "2a02:842a:1c4e:f301:3550:6b4:7339:1001"
];

function isRoggetIP($ip) {
    global $roggetServersIPs;
    if(in_array($ip, $roggetServersIPs)) return true;
    return false;
}

$RCCS = [
    "renders" => [
        "2008" => "90.78.85.2:50001",
        "2016" => "90.78.85.2:50002"
    ],
    "gameservers" => [
        "2016" => "90.78.85.2:50002"
    ],
];

$clientKeys = [
    "public" => "BgIAAACkAABSU0ExAAQAAAEAAQCh3lXVMKEjK7WuI8dXeqkoZjaAKJk5fykRACovrc2KZiwpU7e5etfMUeP/9NDkxqRybozh1IX3mhIr8lcrF/u4s3QKuEinYoXiEbcuGGqUr33Z2DJlwkU/xtNAaRcMYzBNeowhRholyFbbpYPQOm2omo3xmmWOk+MBdXRuZ+xmrg==",
    "private" => "-----BEGIN RSA PRIVATE KEY-----
MIICXgIBAAKBgQCuZuxnbnR1AeOTjmWa8Y2aqG060IOl21bIJRpGIYx6TTBjDBdpQNPGP0XCZTLY2X2vlGoYLrcR4oVip0i4CnSzuPsXK1fyKxKa94XU4YxucqTG5ND0/+NRzNd6ubdTKSxmis2tLyoAESl/OZkogDZmKKl6V8cjrrUrI6Ew1VXeoQIDAQABAoGBAJEsGZMLbaNMXDyips8wTTg1BR+VHFC+YOGfiNxh5saTZDi+gupZTS9T0eS8SnQZrrat6xaQJFGd5nw1VaHlCjiEWDEKOYW5ciEvtLZxW4wpLUx+jT8g32SJcNwl6s52Fx4RdLbypLYEa9LJoDZT6ZUNh6qszdXdajtzCQWQXHf1AkEA2OnM3zH8cWyLmxxYIvOMUt4uoszk2Q/gYSCpBL23PnH6/Lc3KuuRFC/zRQkCJejvRcQFq8Gm5oAllh96iRL86wJBAM3UFOz0XPWu0EcrM1nBk2kLkI7RS2Ch91Yv2tSfafRScFuO1MY2f/OdFygxJr3c7ebSGicOeIUZ7UC2oPHDP6MCQQChUaAQDjjUkglxni7eL4sYxiyg3wkDdY9GLOgGoqF5S4OCFzBsNy16ef7ORNjYINhyZkphZnAd1QgfEeIrt3dpAkEAh+4k96wV7EbL1ARqwD7/7CKwEDGWdzXf03J9MWgqICmFfGHikRiS/b7j+S4kqMTL9GES1nJPE4/gyJkTxzYrwwJAIg0A3UiB6Xx6Uq9vK+srPzyamk3hX4M6mg/k2sdZINS+yJzjlr3Lu3R+LFbSLUcdLp6uXfieFDe4D9Bn9+FQpA==
-----END RSA PRIVATE KEY-----"
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
        setcookie(".ROGGETSECURITY", "", -1, "/");
    }
}

if(isset($_COOKIE["_gameAuthentication"]) && !$loggedin) {
    if(!empty($_COOKIE["_gameAuthentication"])) {
        $q = $con->prepare("SELECT * FROM users WHERE gameAuthentication = :auth");
        $q->bindParam(':auth', $_COOKIE["_gameAuthentication"], PDO::PARAM_STR);
        $q->execute();
        $user = $q->fetch();
        if($user) {
            $loggedin = true;
        }
    }
}

if(isset($_REQUEST["authentication"]) && !$loggedin) {
    if(!empty($_REQUEST["authentication"])) {
        $q = $con->prepare("SELECT * FROM users WHERE gameAuthentication = :auth");
        $q->bindParam(':auth', $_REQUEST["authentication"], PDO::PARAM_STR);
        $q->execute();
        $user = $q->fetch();
        if($user) {
            $loggedin = true;
        }
    }
}

function setCSRFCookie() {
    $new = bin2hex(random_bytes(40));
    setcookie('.csrftoken', $new, time() + 31536000, "/");
    setcookie('.csrftoken', $new, time() + 31536000, "/", "shitblx.cf");
    setcookie('.csrftoken', $new, time() + 31536000, "/", ".shitblx.cf");
    $_COOKIE["_csrftoken"] = $new;
    return $new;
}

function getCSRFCookie() {
    if(!isset($_COOKIE["_csrftoken"])) return null;
    return $_COOKIE["_csrftoken"];
}

function isCorrectCSRF($cookie) {
    if(!isset($_COOKIE["_csrftoken"])) return false;
    if($cookie !== $_COOKIE["_csrftoken"]) return false;
    return true;
}

function warnCSRF($site) {
    global $con;
    global $user;
    global $loggedin;
    if(!$loggedin || !$user) return false;
    $warns = json_decode($user["csrfWarns"], true);
    if(!in_array($site, $warns)) array_push($warns, $site);
    $warns = json_encode($warns);
    $q = $con->prepare("UPDATE users SET csrfWarns = :warns WHERE id = :id");
    $q->bindParam(':warns', $warns, PDO::PARAM_STR);
    $q->bindParam(':id', $user["id"], PDO::PARAM_INT);
    $q->execute();
    return true;
}

if(!getCSRFCookie()) setCSRFCookie();

$siteTheme = "dark";//"light";

if($loggedin) $siteTheme = $user["theme"];

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
    "clientsecret" => "VxBulJ6UdEFweAkmetv9NvV_6DhVTW8b",
    "serverid" => "1206722089005092864"
];

function getDiscordUserInfoFromAccessToken($token) {
    $ch = curl_init("https://discord.com/api/users/@me");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [ "Authorization: Bearer ".$token ]);

    return json_decode(curl_exec($ch), true);
}

function getDiscordServersFromAccessToken($token) {
    $ch = curl_init("https://discord.com/api/users/@me/guilds");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [ "Authorization: Bearer ".$token ]);

    return json_decode(curl_exec($ch), true);
}

if($loggedin && $enableDiscordVerification) {
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
        if($user["discord_verify_required"]) {
            if(!$user["discord_verified"] && !in_array($_SERVER["PHP_SELF"], [
                "/Api/DiscordVerification.php",
                "/DiscordVerify.php",
                "/UserAuthentication/LogOut.php"
            ])) {
                header('location: /DiscordVerify.ashx');
                exit;
            }
            if($user["discord_verified"] && time() >= ($user["discord_last_server_check"] + 1800)) {
                $time = time();
                $guilds = getDiscordServersFromAccessToken($user["discord_access_token"]);
                $joinedROGGET = false;
                $somethingWrongHappened = false;
                foreach($guilds as $guild) {
                    if(!is_array($guild)) $somethingWrongHappened = true;
                    if(!$somethingWrongHappened) if($guild["id"] == $discord["serverid"]) $joinedROGGET = true;
                }
                if(!$somethingWrongHappened) {
                    $q = $con->prepare("UPDATE users SET discord_last_server_check = :time WHERE id = :id");
                    $q->bindParam(':time', $time, PDO::PARAM_INT);
                    $q->bindParam(':id', $user["id"], PDO::PARAM_INT);
                    $q->execute();
                    if(!$joinedROGGET) {
                        $q = $con->prepare("UPDATE users SET discord_verified = false, discord_time_since_no_verification = :time WHERE id = :id");
                        $q->bindParam(':time', $time, PDO::PARAM_INT);
                        $q->bindParam(':id', $user["id"], PDO::PARAM_INT);
                        $q->execute();
                        header('location: /DiscordVerify.ashx');
                        exit;
                    }
                }
            }
            if($user["discord_verified"] && (time() - 300000) >= $user["discord_expires_in"]) {
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
            }/* else {
                if((time() - $user["discord_time_since_no_verification"]) >= 86400) {
                    $q = $con->prepare("DELETE FROM users WHERE id = :id");
                    $q->bindParam(':id', $user["id"], PDO::PARAM_INT);
                    $q->execute();
                    header('location: /UserAuthentication/LogOut.ashx');
                    exit;
                }
            }*/
        } else {
            $user["discord_verify_required"] = false;
        }
    }
}

function filterBadWords($string) {
    $superSafeChat = false;
    global $loggedin;
    if($loggedin) {
        global $user;
        $user["underage"] = 0;
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
        //"niger", it's a country but still
        "nigger",
        "niggger",
        "nigggger",
        "n1gga",
        "1gga",
        "n1ggga",
        "1ggga",
        "n1gggga",
        "1gggga",
        "n1gger",
        "n1ggger",
        "n1gggger",
        "stfu",
        "fxck",
        "fawk",
        "bitch",
        "bitche",
        "bitches",
        "bitchs",
        "b1tch",
        "b1tche",
        "b1tches",
        "b1tchs",
        "lmao",
        "lmfao",
        "wtf",
        "tf",
        "kys",
        "kms",
        "ass",
        "dick",
        "d1ck",
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

        /*"yomi",
        "madblox",
        "madblxx",
        "sigma",          these are too SIGMA to block
        "rizz",
        "gyatt",
        "xxxtentation",*/

        "caleb",
        "carly",
        "caleb lesley",
        "caleblesley",

        "casey",
        "cave story",
        
        "fdp",
        "ntm",
        "nique ta mère",
        "nique",
        "ta mère",
        "ta mere",
        "pute",
    ];

    if($superSafeChat) {
        array_push($badWords, "underage");
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

/*if(!empty($_SERVER["PHP_AUTH_USER"]) && !empty($_SERVER["PHP_AUTH_PW"])) {
    if($_SERVER["PHP_AUTH_USER"] !== "nolanwhy" || $_SERVER["PHP_AUTH_PW"] !== "poopfart46") {
        header('WWW-Authenticate: Basic realm="ROGGET"');
        exit;
    }
} else {
    header('WWW-Authenticate: Basic realm="ROGGET"');
    exit;
}*/

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

function exitFile($file) {
    exit(file_get_contents($file));
}

function exitHTTPCode($code) {
    http_response_code($code);
    $_REQUEST["code"] = $code;
    $_GET["code"] = $code;
    require_once($_SERVER["DOCUMENT_ROOT"]."/request-error.php");
    exit;
}