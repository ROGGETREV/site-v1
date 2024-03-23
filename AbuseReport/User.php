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
    <title>Report Abuse - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <br>
    <div class="<?php echo $containerClasses; ?>">
        todo: faire cette putain de page
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>