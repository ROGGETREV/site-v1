<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");

if($loggedin) {
    header('location: /Home.aspx');
    exit;
}

if(str_contains($_SERVER["HTTP_USER_AGENT"], "ROBLOX Android App")) {
    header('location: /Games.aspx');
    exit;
}

$q = $con->prepare("SELECT count(*) FROM users");
$q->execute();
$userCount = (int)$q->fetch()[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/head.php"); ?>
    <title>Welcome to ROGGET!</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <img src="/images/game.png" style="position: fixed;width: 100%;z-index: -999999999999;border-radius: 15px;filter: blur(10px);">
    <br>
    <div class="<?php echo $containerClasses; ?>">
        <h2>Welcome to ROGGET!</h2>
        <p>A 2010L, 2011E and 2016L revival with <?php echo (int)$userCount; ?> amazing users!</p>
        <div class="d-flex">
            <a href="/UserAuthentication/LogIn.aspx"><button type="submit" id="submitBtn" class="btn btn-primary btn-auto">Log In!</button></a>
            <div style="width: 10px;"></div>
            <span style="margin-top: 4px;">or</span>
            <div style="width: 10px;"></div>
            <a href="/UserAuthentication/SignUp.aspx"><button type="submit" id="submitBtn" class="btn btn-outline-primary btn-auto">Sign Up!</button></a>
        </div>
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>