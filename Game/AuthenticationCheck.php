<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
error_reporting(0);
header('Content-Type: text/plain');
if($_REQUEST["apiKey"] === "EHbKaHdKKrWlRfxneJkbEUWo9vZVLE64" && isset($_REQUEST["authentication"])) {
    if(!empty($_REQUEST["authentication"])) {
        if(str_starts_with($_REQUEST["authentication"], "guest-") && $guestEnabled) {
            $guestId = (int)str_replace("guest-", "", $_REQUEST["authentication"]);
            if($guestId > 9999 || $guestId < 1) exit("false");
            exit("true;-".(int)$guestId.";Guest ".(int)$guestId.";http://shitblx.cf/Game/CharacterFetch.ashx?userId=-".(int)$guestId."&game=".(int)$_REQUEST["game"]."&noredir&guest");
        }
        $q = $con->prepare("SELECT * FROM users WHERE gameAuthentication = :auth");
        $q->bindParam(':auth', $_REQUEST["authentication"], PDO::PARAM_STR);
        $q->execute();
        $usr = $q->fetch();
        if($usr) {
            echo "true;".(int)$usr["id"].";".$usr["username"].";http://shitblx.cf/Game/CharacterFetch.ashx?userId=".(int)$usr["id"]."&game=".(int)$_REQUEST["game"]."&noredir";
        } else {
            echo "false";
        }
    } else {
        echo "false";
    }
} else {
    echo "false";
}
/*
if($_REQUEST["apiKey"] === "EHbKaHdKKrWlRfxneJkbEUWo9vZVLE64") {
    echo "function waitForChild(instance, name)
    while not instance:findFirstChild(name) do
        instance.ChildAdded:wait()
    end
end\n";
    $q = $con->prepare("SELECT * FROM users WHERE gameAuthentication = :auth");
    $q->bindParam(':auth', $_REQUEST["authentication"], PDO::PARAM_STR);
    $q->execute();
    $usr = $q->fetch();
    if($usr) {
        echo "print('Authentication check success')
waitForChild(game.Players, '".addslashes($_REQUEST["authentication"])."')
plr = game.Players:findFirstChild('".addslashes($_REQUEST["authentication"])."')
plr.Name = '".addslashes($usr["username"])."'
plr.userId = ".(int)$usr["id"];
    } else {
        echo "checkFail = true
print('Authentication check failed')
waitForChild(game.Players, '".addslashes($_REQUEST["authentication"])."')
plr = game.Players:findFirstChild('".addslashes($_REQUEST["authentication"])."')
pcall(function() kickPlayer(plr, \"Authentication check failed\") end)
pcall(function()
    --plr.Name = 'Auth check fail'
    --plr:remove()
end)";
    }
} else {
    echo "print('API Key is incorrect! Could not check authentication.')";
}
*/