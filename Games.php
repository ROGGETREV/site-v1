<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
$sqlFilters = "";
$onlyClient = "";
if($loggedin) if($session["mobileVersion"] !== "None") if($session["mobileVersion"] === "2.271.97572") {
    $sqlFilters = "AND gameClient = '2016L'";
    $onlyClient = "2016L";
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/head.php"); ?>
    <title>Games - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <br>
    <div class="<?php echo $containerClasses; ?>">
        <h2>Games<?php if(!empty($onlyClient)) echo " (".$onlyClient." only)"; ?></h2>
        <div class="row">
            <div class="col-md-2">
                <img src="/images/CatalogAssets/browsebycategory.png" style="width: 100%;">
                <h5 style="cursor: pointer;" onclick='scrollDiv("popularGames");'>Popular</h5>
                <h5 style="cursor: pointer;" onclick='scrollDiv("recentGames");'>Recent</h5>
            </div>
            <div class="col-md-10">
                <div id="popularGames">
                    <h4>Popular Games</h4>
                    <div class="row">
                        <?php
                        $q = $con->prepare("SELECT * FROM games WHERE moderation = 'Accepted' ".$sqlFilters." ORDER BY players DESC");
                        $q->execute();
                        foreach($q->fetchAll() as $game) {
                        $qq = $con->prepare("SELECT * FROM users WHERE id = :id");
                        $qq->bindParam(':id', $game["creator"], PDO::PARAM_INT);
                        $qq->execute();
                        $usr = $qq->fetch();
                        if($usr) {
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
                        <?php }} ?>
                    </div>
                </div>
                <br>
                <div id="recentGames">
                    <h4>Recent Games</h4>
                    <div class="row">
                        <?php
                        $q = $con->prepare("SELECT * FROM games WHERE moderation = 'Accepted' ".$sqlFilters."");
                        $q->execute();
                        foreach($q->fetchAll() as $game) {
                        $qq = $con->prepare("SELECT * FROM users WHERE id = :id");
                        $qq->bindParam(':id', $game["creator"], PDO::PARAM_INT);
                        $qq->execute();
                        $usr = $qq->fetch();
                        if($usr) {
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
                        <?php }} ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    function scrollDiv(div) {
        document.querySelector("#" + div).scrollIntoView({ behavior: "smooth", block: "start" });
    }
    </script>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>