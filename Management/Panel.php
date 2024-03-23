<?php require_once($_SERVER["DOCUMENT_ROOT"]."/Management/inc.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/head.php"); ?>
    <title>Management - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <br>
    <div class="<?php echo $containerClasses; ?>">
        <h1>Management Panel</h1>
        <h4><?php echo htmlspecialchars($user["username"]); ?>, you are an <?php echo htmlspecialchars($user["permission"]); ?>!</h4>
        <div class="card" style="margin-top: 3px;">
            <?php require_once($_SERVER["DOCUMENT_ROOT"]."/Management/tabheader.php"); ?>
            <div class="card-body">
                <h2>Please choose a tab.</h2>
            </div>
        </div>
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>