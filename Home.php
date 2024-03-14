<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");

if(!$loggedin) {
    header('location: /Default.aspx');
    exit;
}

$q = $con->prepare("SELECT * FROM friendships WHERE ((user1 = :id) OR (user2 = :id)) AND accepted = 1");
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->execute();
$friends = array_reverse($q->fetchAll());

$welcomeMessages = [
    "Hello {emoji}, {username}!",
    "Welcome back {emoji}, {username}!",
    "Where have you been, {username}? {emoji}",
    "It's time to play ROGGET {emoji}, {username}!",
    "Good to see you again {emoji}, {username}!",
    "Hey there {emoji}, {username}!",
    "Glad you could join us {emoji}, {username}!",
    "Welcome to the party {emoji}, {username}!",
    "Make yourself at home {emoji}, {username}!"
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/head.php"); ?>
    <title>Home - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <br>
    <div class="container card card-body">
        <div class="d-flex">
            <img src="/images/Users/Get.ashx?ID=<?php echo (int)$user["id"]; ?>" onerror='this.src = "/images/loaderror.png";' onclick='window.location = "/User.aspx?ID=<?php echo (int)$user["id"]; ?>";' style="width: 125px;height: 125px;cursor: pointer;">
            <div style="margin-left: 12px;margin-top: 22px;">
                <h2><?php echo str_replace("{emoji}", '<img src="/images/emojis/grinning-face.png" style="width: 36px;height: 36px;margin-top: -8px;" onerror=\'this.src = "/images/loaderror.png";\'>', htmlspecialchars(str_replace("{username}", $user["username"], $welcomeMessages[array_rand($welcomeMessages)]))); ?> <?php if($user["buildersclub"] !== "None") {echo '<img src="/images/'.$user["buildersclub"].'.png" style="width: 36px;height: 36px;margin-top: -8px;" onerror=\'this.src = "/images/loaderror.png";\'>';} ?></h2>
                <h5>Placeholder</h5>
            </div>
        </div>
        <br>
        <h4>Friends (<?php echo (int)count($friends); ?>)</h4>
        <div class="card card-body d-flex flex-row overflow-x-auto overflow-x-hidden-sm">
            <?php
            if(count($friends) <= 0) {
                echo "Looks like you have no friends :( Try finding some!";
            } else {
                $showed = 0;
                $limit = 13;
                foreach($friends as $friend) {
                    if($showed >= $limit) break;
                    $targetId = (int)$friend["user1"];
                    if($targetId === (int)$user["id"]) $targetId = (int)$friend["user2"];
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
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>