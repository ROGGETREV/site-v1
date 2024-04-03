<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
error_reporting(0);
if(str_contains($_SERVER["HTTP_USER_AGENT"], "ROBLOX Android App")) {
    header('location: /Games.aspx');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/head.php"); ?>
    <title>Download - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>" style="background: url('/images/bluebg.jpg') top repeat-x !important;">
    <br><br><br>
    <center>
        <img src="/images/logo.png" style="width: 350px;"><br><br>
        <h2>Create Games, Play Games</h2>
        <p>Create games and worlds spanning a variety of genres,<br>
        From first-person shooters, survival games, and role-playing adventures.</p>
        <br><br>
        <button class="btn btn-success" style="width: 520px;height: 80px;font-size: 36px;" onclick="dl();">Download Now!</button><br><br><br>
        <img src="/images/e1398f8378eb7e721b3b51fc05f1f961.png">
    </center>
    <script>
    function dl() {
        <?php if($user["permission"] === "Administrator") { ?>
        let res = prompt("Please input the download you want, options are:\n-windows\n-2016Landroid\nPutting any other choice will cancel the download.");
        if(res === "windows") window.location = "/downloadfiles/windows/RoggetInstaller.exe";
        if(res === "2016Landroid") window.location = "/downloadfiles/android/Rogget2016L.apk";
        <?php } else { ?>
        alert("Sorry, downloads will be available when ROGGET releases.");
        <?php } ?>
    }
    </script>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>