<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");

if(!$loggedin) {
    header('location: /Default.aspx');
    exit;
}

$q = $con->prepare("SELECT * FROM friendships WHERE ((user1 = :id) OR (user2 = :id)) AND accepted = 1");
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->execute();
$friends = array_reverse($q->fetchAll());

$welcomeMessages = [
    "Hello {emoji}, {username}!",
    "Welcome back {emoji}, {username}!",
    "Where have you been, {username}? {emoji}",
    "It's time to play ROGGET {emoji}, {username}!",
    "Good to see you again {emoji}, {username}!",
    "Hey there {emoji}, {username}!",
    "Glad you could join us {emoji}, {username}!",
    "Welcome to the party {emoji}, {username}!",
    "Make yourself at home {emoji}, {username}!"
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/head.php"); ?>
    <title>Home - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <br>
    <div class="<?php echo $containerClasses; ?>">
        <h2>Settings</h2>
        <p>page not done</p>
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>