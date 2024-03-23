<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/head.php"); ?>
    <title>Privacy Policy - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <br>
    <div class="<?php echo $containerClasses; ?>">
        <h1>Privacy Policy</h1>
        <p>Welcome to ROGGET. By using our website, you agree to comply with and be bound by the following privacy policy. Please read these terms carefully:</p>

        <h2>Updates of Privacy Policy</h2>
        <p>ROGGET has the right to change the Privacy Policy at any moment without telling users.</p>
        
        <h2>IP Address</h2>
        <p>We log your IP Address in SHA512 in every account session.</p>
        
        <h2>User Agent</h2>
        <p>We log your User Agent in plain text in every account session.</p>

        <p>By using our website, you acknowledge that you have read, understood, and agree to be bound by this Privacy Policy.</p>
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>