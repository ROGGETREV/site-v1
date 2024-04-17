<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");

if(!isset($_REQUEST["ID"])) {
    if($loggedin) {
        $_REQUEST["ID"] = (int)$user["id"];
    } else {
        header('location: /request-error.aspx?code=404');
        exit;
    }
}

if(str_contains($_SERVER["HTTP_USER_AGENT"], "ROBLOX Android App") && !$loggedin) {
    header('location: /Games.aspx');
    exit;
}

$id = (int)$_REQUEST["ID"];

$q = $con->prepare("SELECT * FROM users WHERE id = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$usr = $q->fetch();
if(!$usr) {
    header('location: /request-error.aspx?code=404');
    exit;
}

$q = $con->prepare("SELECT * FROM friendships WHERE ((user1 = :id) OR (user2 = :id)) AND accepted = 1");
$q->bindParam(':id', $usr["id"], PDO::PARAM_INT);
$q->execute();
$friends = array_reverse($q->fetchAll());

$friendship = false;
if($loggedin) {
    if($id !== (int)$user["id"]) {
        $q = $con->prepare("SELECT * FROM friendships WHERE ((user1 = :id AND user2 = :id2) OR (user1 = :id2 AND user2 = :id))");
        $q->bindParam(':id', $user["id"], PDO::PARAM_INT);
        $q->bindParam(':id2', $id, PDO::PARAM_INT);
        $q->execute();
        $friendship = $q->fetch();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/head.php"); ?>
    <title><?php echo htmlspecialchars($usr["username"]); ?> - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <?php if((int)$usr["banned"] === 1) { ?>
    <br>
    <div class="container p-3 bg-danger rounded-3">
        This user has been moderated from ROGGET.
    </div>
    <?php } ?>
    <br>
    <div class="<?php echo $containerClasses; ?>">
        <div class="d-flex">
            <?php
            if($loggedin) {
            if($id !== (int)$user["id"]) {
            $secondButton = false;
            $btnText = "Add Friend";
            $btnColor = "primary";
            $btnOnclick = "addFriend();";
            if($friendship) {
                if($friendship["accepted"] === 1) {
                    $btnText = "Remove Friend";
                    $btnColor = "danger";
                    $btnOnclick = "removeFriend();";
                } else {
                    if((int)$friendship["user1"] === (int)$user["id"]) {
                        $btnText = "Pending";
                        $btnColor = "outline-secondary";
                        $btnOnclick = "removeFriend();";
                    } else {
                        $btnText = "Decline";
                        $btnColor = "danger";
                        $btnOnclick = "removeFriend();";

                        $secondButton = true;
                        $sbtnText = "Accept";
                        $sbtnColor = "success";
                        $sbtnOnclick = "addFriend();";
                    }
                }
            }
            ?>
            <button style="position: absolute;top: 9px;right: 9px;" class="btn btn-primary btn-auto" onclick='window.location = "/MessageSend.aspx?ID=<?php echo (int)$usr["id"]; ?>";'><i class="bi bi-send-fill"></i></button>
            <button style="position: absolute;top: 9px;right: 56px;" class="btn btn-<?php echo $btnColor; ?> btn-auto" onclick='<?php echo $btnOnclick; ?>'><?php echo $btnText; ?></button>
            <?php if($secondButton) { ?>
            <button style="position: absolute;top: 9px;right: 143px;" class="btn btn-<?php echo $sbtnColor; ?> btn-auto" onclick='<?php echo $sbtnOnclick; ?>'><?php echo $sbtnText; ?></button>
            <?php } ?>
            <?php }} ?>
            <img src="/images/Users/Get.ashx?ID=<?php echo (int)$usr["id"]; ?>" onerror='this.src = "/images/loaderror.png";' style="width: 125px;height: 125px;">
            <div style="margin-left: 12px;margin-top: 22px;">
                <h2><?php echo htmlspecialchars($usr["username"]); ?> <?php if($usr["buildersclub"] !== "None") {echo '<img src="/images/'.$usr["buildersclub"].'.png" style="width: 36px;height: 36px;margin-top: -8px;" onerror=\'this.src = "/images/loaderror.png";\'>';} ?></h2>
                <h5><?php echo (int)count($friends); ?> Friend<?php if(count($friends) !== 1) {echo "s";} ?></h5>
            </div>
        </div>
        <br>
        <h4>About</h4>
        <div class="card card-body">
            <?php if($loggedin) {if($id !== (int)$user["id"]) { ?><button style="position: absolute;top: 9px;right: 9px;" class="btn btn-outline-danger btn-auto" onclick='window.location = "/AbuseReport/User.aspx";'>Report Abuse</button><?php }} ?>
            <?php echo htmlspecialchars($usr["description"]); ?>
        </div>
        <br>
        <h4>Friends (<?php echo (int)count($friends); ?>)</h4>
        <div class="card card-body d-flex flex-row overflow-x-auto overflow-x-hidden-sm">
            <?php
            if(count($friends) <= 0) {
                if($id !== (int)$user["id"]) echo "Looks like this user has no friends :( Why don't you add him?";
                else echo "Looks like you have no friends :( Try finding some!";
            } else {
                $showed = 0;
                $limit = 13;
                foreach($friends as $friend) {
                    if($showed >= $limit) break;
                    $targetId = (int)$friend["user1"];
                    if($targetId === (int)$usr["id"]) $targetId = (int)$friend["user2"];
                    $q = $con->prepare("SELECT * FROM users WHERE id = :id");
                    $q->bindParam(':id', $targetId, PDO::PARAM_INT);
                    $q->execute();
                    $frienduser = $q->fetch();
                    if($frienduser) { ?>
                    <div class="text-center" style="width: 100px;cursor: pointer;" onclick='window.location = "/User.aspx?ID=<?php echo (int)$frienduser["id"]; ?>";'>
                        <img src="/images/Users/Get.ashx?ID=<?php echo (int)$frienduser["id"]; ?>" onerror='this.src = "/images/loaderror.png";' style="width: 100px;height: 100px;">
                        <h6><?php echo htmlspecialchars($frienduser["username"]); ?></h6>
                    </div>
                    <?php $showed++; if($showed < $limit) echo '<div style="width: 10px;"></div>'; }
                }
            }
            ?>
        </div>
        <br>
        <h4>Recent</h4>
        <?php
        $gameList = "";
        ob_start();
        $count = 0;
        $limit = 6;
        foreach(array_reverse(json_decode($usr["playedGames"], true)) as $gameID) {
        $qq = $con->prepare("SELECT * FROM games WHERE id = :id");
        $qq->bindParam(':id', $gameID, PDO::PARAM_INT);
        $qq->execute();
        $game = $qq->fetch();
        $qq = $con->prepare("SELECT * FROM users WHERE id = :id");
        $qq->bindParam(':id', $game["creator"], PDO::PARAM_INT);
        $qq->execute();
        $usr = $qq->fetch();
        if($game && $usr) {
        $count++;
        if($count <= $limit) {
        ?>
        <div class="col-md-2" style="cursor: pointer;" onclick='window.location = "/Place.aspx?ID=<?php echo (int)$game["id"]; ?>";'>
            <div class="card">
                <div style="height: 0; padding-top: 60%; position: relative;">
                    <img src="/images/Games/Get.ashx?ID=<?php echo (int)$game["id"]; ?>" class="card-img-top" style="position: absolute; top: 0; bottom: 0; left: 0; right: 0; width: 100%; height: 100%;">
                </div>
                <div class="gameClientCard gameClientCard-small"><?php echo htmlspecialchars($game["gameClient"]); ?></div>
                <div class="card-body" style="padding: 6px;">
                    <h6 class="card-title" style="margin-bottom: 0;"><?php echo htmlspecialchars($game["name"]); ?></h6>
                    <p class="card-text">by <strong><?php echo htmlspecialchars($usr["username"]); ?></strong><?php if((int)$game["players"] >= 1) { ?><br><strong><?php echo (int)$game["players"]; ?></strong> playing<?php } ?></p>
                </div>
            </div>
        </div>
        <?php } else $count--;}} $gameList = ob_get_clean(); if($count < 1) echo "This user has played no games."; else echo "<div class=\"row\">".$gameList."</div>"; ?>
        </div>
    <script>
    async function addFriend() {
        const data = new FormData();
        data.append("csrf_token", getCSRFCookie());
        const req = await fetch("/Api/Friendship.ashx?ID=<?php echo (int)$id; ?>&type=add", {
            method: "POST",
            body: data
        });
        const res = await req.json();
        if(res.success) location.reload();
        else alert("Uh oh! An error occurred while adding friend: " + res.message);
    }
    async function removeFriend() {
        const data = new FormData();
        data.append("csrf_token", getCSRFCookie());
        const req = await fetch("/Api/Friendship.ashx?ID=<?php echo (int)$id; ?>&type=remove", {
            method: "POST",
            body: data
        });
        const res = await req.json();
        if(res.success) location.reload();
        else alert("Uh oh! An error occurred while removing friend: " + res.message);
    }
    </script>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>