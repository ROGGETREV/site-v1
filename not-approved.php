<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");

if(!$loggedin) {
    header('location: /Default.aspx');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/head.php"); ?>
    <title>Account Moderated - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <br>
    <div class="<?php echo $containerClasses; ?>">
        <h1>Account Moderated</h1>
        <h3>Your account (<?php echo htmlspecialchars($user["username"]); ?>) has been moderated by a ROGGET moderator.</h3>
        <h6>Reason: <?php echo htmlspecialchars($user["banreason"]); ?></h6>
        <a href="/UserAuthentication/LogOut.ashx">Log Out</a>
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>