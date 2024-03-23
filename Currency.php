<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");

if(!$loggedin) {
    header('location: /Default.aspx');
    exit;
}

$q = $con->prepare("SELECT * FROM friendships WHERE ((user1 = :id) OR (user2 = :id)) AND accepted = 1");
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->execute();
$friends = $q->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/head.php"); ?>
    <title>Nuggets - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <br>
    <div class="<?php echo $containerClasses; ?>">
        <h2>Hello, <?php echo htmlspecialchars($user["username"]); ?>.</h2>
        <h5>You have <?php echo (int)$user["nuggets"]; ?> Nuggets.</h5>
        <hr>
        <h2>Where you can spend Nuggets</h2>
        <ul class="list-group">
            <li class="list-group-item" style="cursor: pointer;" onclick='window.location = "/Catalog.aspx";'>The Catalog</li>
            <li class="list-group-item" style="cursor: pointer;" onclick='window.location = "/BuildersClub.aspx";'>Builders Club</li>
        </ul>
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>