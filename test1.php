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
    <title>ChatTest - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <br>
    <div class="<?php echo $containerClasses; ?>">
        ChatTest<br>
    </div>
    <script>
    const socket = io("realtime.shitblx.cf");
    socket.on("connect", () => {
        socket.emit("auth", "I farted");
        socket.on("auth-error", (a) => {
            alert(a);
        });
    });
    </script>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>