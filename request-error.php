<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
$code = 404;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/head.php"); ?>
    <title>Error - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <br>
    <div class="container card card-body advertisement ad">
        <h2>404 Not Found</h2>
        <p>The page you were trying to access does not exist, or you don't have the permission to access it.</p>
        <img src="https://http.cat/images/<?php echo (int)$code; ?>.jpg" style="width: 500px;">
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>