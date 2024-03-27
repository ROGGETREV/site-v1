<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");

if(!$loggedin) {
    header('location: /Default.aspx');
    exit;
}
if($user["discord_verified"] === 1) {
    header('location: /Home.aspx');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/head.php"); ?>
    <title>Discord Verification - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <br>
    <div class="<?php echo $containerClasses; ?>">
        <h1>Discord Verification</h1>
        <h3>Your account (<?php echo htmlspecialchars($user["username"]); ?>) needs to be verified using Discord to play ROGGET.</h3>
        <!-- <h6 class="text-danger">You must verify now or your account will be permanently deleted from ROGGET.</h6> -->
        <a href="https://discord.com/oauth2/authorize?client_id=<?php echo (int)$discord["clientid"]; ?>&response_type=code&redirect_uri=http%3A%2F%2F<?php echo $_SERVER["SERVER_NAME"]; ?>%2FApi%2FDiscordVerification.ashx&scope=guilds+identify">Click here to verify using your Discord account</a>
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>