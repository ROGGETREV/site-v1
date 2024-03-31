<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");

if(!isset($_REQUEST["ID"])) {
    header('location: /request-error.aspx?code=404');
    exit;
}
$id = (int)$_REQUEST["ID"];

$q = $con->prepare("SELECT * FROM games WHERE id = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$game = $q->fetch();
if(!$game || $game["moderation"] !== "Accepted") {
    header('location: /request-error.aspx?code=404');
    exit;
}

$q = $con->prepare("SELECT * FROM users WHERE id = :id");
$q->bindParam(':id', $game["creator"], PDO::PARAM_INT);
$q->execute();
$usr = $q->fetch();
if(!$usr) {
    header('location: /request-error.aspx?code=404');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/head.php"); ?>
    <title><?php echo htmlspecialchars($game["name"]); ?> - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <br>

    <div class="<?php echo $containerClasses; ?>">
        <!-- Main page -->
        <h2><a href="/Games.aspx">< Back to Games</a></h2>
        <h3>ROGGET Game</h3>
        <div class="row">
            <div class="col-md-4">
            <div class="gameClientCard gameClientCard-big"><?php echo htmlspecialchars($game["gameClient"]); ?></div>
                <img src="/images/Games/Get.ashx?ID=<?php echo (int)$game["id"]; ?>" onerror='this.src = "/images/loaderror.png";' style="width: 100%;">
            </div>
            <div class="col-md-8">
                <h2><?php echo htmlspecialchars($game["name"]); ?></h2>
                <h6>By <a href="/User.aspx?ID=<?php echo (int)$usr["id"]; ?>"><?php echo htmlspecialchars($usr["username"]); ?></a></h6>
                <div style="height: 87px;"></div>
                <?php if($loggedin) { ?>
                <button class="btn btn-success" onclick='play();'>Play</button>
                <?php } else { ?>
                <button class="btn btn-secondary" onclick='window.location = "/Default.aspx";'>Login to play</button>
                <?php } ?>
            </div>
        </div>
        <br>
        <h3>Description</h3>
        <h6><?php echo htmlspecialchars($game["description"]); ?></h6>
    </div>
    <?php if($loggedin) { ?>
    <script>
        function play() {
            window.location = "/games/start?placeid=<?php echo (int)$game["id"]; ?>";
        }
    </script>
    <?php } ?>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>