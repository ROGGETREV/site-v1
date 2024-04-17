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
                <button class="btn btn-success" onclick='play();' data-bs-toggle="modal" data-bs-target="#playModal">Play</button>
                <?php } else {
                if(!$guestEnabled) {
                ?>
                <button class="btn btn-secondary" onclick='window.location = "/Default.aspx";'>Login to play</button>
                <?php } else { ?>
                <button class="btn btn-success" onclick='play();' data-bs-toggle="modal" data-bs-target="#playModal">Play as guest</button>
                <?php }} ?>
            </div>
        </div>
        <br>
        <h3>Description</h3>
        <h6><?php echo htmlspecialchars($game["description"]); ?></h6>
    </div>
    <?php if($loggedin || $guestEnabled) { ?>
    <script>
    let closeModalTimeout = null;
    function play() {
        setTimeout(() => {
            window.location = "/games/start?placeid=<?php echo (int)$game["id"]; ?>&csrf_token=" + getCSRFCookie();
        }, 1000);

        clearTimeout(closeModalTimeout);
        closeModalTimeout = setTimeout(() => {
            document.querySelector("#playModalCancel").click();
        }, 10000);
    }
    </script>
    <div class="modal fade" id="playModal" tabindex="-1" aria-labelledby="playModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="playModalLabel">Launching ROGGET</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <center class="modal-body">
                        <img src="/images/logosmall.png" style="width: 130px;height: 130px;animation: loadingClientAnim 1.5s ease-in-out infinite;"><br>
                        ROGGET is currently launching as "<?php if($loggedin) echo htmlspecialchars($user["username"]); else echo "Guest"; ?>". Prepare for action!
                </center>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick='window.location = "/download";'>Download</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="playModalCancel">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>