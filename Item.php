<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");

if(!$loggedin) {
    header('location: /Default.aspx');
    exit;
}

if(!isset($_REQUEST["ID"])) {
    header('location: /request-error.aspx?code=404');
    exit;
}
$id = (int)$_REQUEST["ID"];

$q = $con->prepare("SELECT * FROM catalog WHERE id = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$item = $q->fetch();
if(!$item || $item["moderation"] !== "Accepted") {
    header('location: /request-error.aspx?code=404');
    exit;
}

$q = $con->prepare("SELECT * FROM users WHERE id = :id");
$q->bindParam(':id', $item["creator"], PDO::PARAM_INT);
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
    <title><?php echo htmlspecialchars($item["name"]); ?> - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <br>
    <div class="container card card-body">
    <h2><a href="/Catalog.aspx">< Back to Catalog</a></h2>
        <div class="row">
            <div class="col-md-3">
                <img src="/images/Catalog/Get.ashx?ID=<?php echo (int)$item["id"]; ?>" onerror='this.src = "/images/loaderror.png";' style="width: 100%;">
            </div>
            <div class="col-md-9">
                <h2><?php echo htmlspecialchars($item["name"]); ?></h2>
                <h6>By <a href="/User.aspx?ID=<?php echo (int)$usr["id"]; ?>"><?php echo htmlspecialchars($usr["username"]); ?></a></h6>
            </div>
        </div>
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>