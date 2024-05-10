<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/head.php"); ?>
    <title>People - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <br>
    <div class="<?php echo $containerClasses; ?>">
        <h2>Users</h2>
        <?php
        $q = $con->prepare("SELECT * FROM users WHERE banned = false ORDER BY lastonline DESC");
        $q->execute();
        foreach($q->fetchAll() as $usr) { ?>
        <div class="card" style="margin-top: 5px;cursor: pointer;" onclick='window.location = "/User.aspx?ID=<?php echo (int)$usr["id"]; ?>";'>
            <div class="d-flex">
                <img src="/images/Users/Get.ashx?ID=<?php echo (int)$usr["id"]; ?>" onerror='this.src = "/images/loaderror.png";' style="width: 80px;height: 80px;">
                <div style="margin-left: 12px;margin-top: 8px;">
                    <h3><?php echo htmlspecialchars($usr["username"]); ?></h3>
                    <h6><?php echo htmlspecialchars($usr["description"]); ?></h6>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>