<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");

if(!$loggedin) {
    header('location: /Default.aspx');
    exit;
}

if(!isset($_REQUEST["ID"])) {
    if($loggedin) {
        $_REQUEST["ID"] = (int)$user["id"];
    } else {
        header('location: /request-error.aspx?code=404');
        exit;
    }
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

if($id !== (int)$user["id"]) {
    $q = $con->prepare("SELECT * FROM friendships WHERE ((user1 = :id AND user2 = :id2) OR (user1 = :id2 AND user2 = :id))");
    $q->bindParam(':id', $user["id"], PDO::PARAM_INT);
    $q->bindParam(':id2', $id, PDO::PARAM_INT);
    $q->execute();
    $friendship = $q->fetch();
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
    <br>
    <div class="container card card-body">
        <div class="d-flex">
            <?php
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
            <button style="position: absolute;top: 9px;right: 9px;" class="btn btn-<?php echo $btnColor; ?> btn-auto" onclick='<?php echo $btnOnclick; ?>'><?php echo $btnText; ?></button>
            <?php if($secondButton) { ?>
            <button style="position: absolute;top: 9px;right: 95px;" class="btn btn-<?php echo $sbtnColor; ?> btn-auto" onclick='<?php echo $sbtnOnclick; ?>'><?php echo $sbtnText; ?></button>
            <?php } ?>
            <?php } ?>
            <img src="/images/Users/Get.ashx?ID=<?php echo (int)$usr["id"]; ?>" onerror='this.src = "/images/loaderror.png";' style="width: 125px;height: 125px;">
            <div style="margin-left: 12px;margin-top: 22px;">
                <h2><?php echo htmlspecialchars($usr["username"]); ?> <?php if($usr["buildersclub"] !== "None") {echo '<img src="/images/'.$usr["buildersclub"].'.png" style="width: 36px;height: 36px;margin-top: -8px;">';} ?></h2>
                <h5><?php echo (int)count($friends); ?> Friend<?php if(count($friends) !== 1) {echo "s";} ?></h5>
            </div>
        </div>
        <br>
        <h4>About</h4>
        <div class="card card-body">
            <?php if($id !== (int)$user["id"]) { ?><button style="position: absolute;top: 9px;right: 9px;" class="btn btn-outline-danger btn-auto">Report Abuse</button><?php } ?>
            <?php echo htmlspecialchars($usr["description"]); ?>
        </div>
        <br>
        <h4>Friends (<?php echo (int)count($friends); ?>)</h4>
        <div class="card card-body d-flex flex-row overflow-x-auto overflow-x-hidden-sm">
            <?php
            if(count($friends) <= 0) {
                echo "Looks like this user has no friends :( Why don't you add him?";
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
    </div>
    <script>
    async function addFriend() {
        await fetch("/Api/Friendship.ashx?ID=<?php echo (int)$id; ?>&type=add");
        location.reload();
    }
    async function removeFriend() {
        await fetch("/Api/Friendship.ashx?ID=<?php echo (int)$id; ?>&type=remove");
        location.reload();
    }
    </script>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>