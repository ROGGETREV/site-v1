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
    "Hello, {username}!",
    "Welcome back, {username}!",
    "Where have you been, {username}?",
    "It's time to play ROGGET, {username}!",
    "Good to see you again, {username}!",
    "Hey there, {username}!",
    "Glad you could join us, {username}!",
    "Welcome to the party, {username}!",
    "Make yourself at home, {username}!"
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/head.php"); ?>
    <title>Character Editor - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <br>
    <div class="container card card-body">
        <h1>Character Editor</h1>
        <button class="btn btn-primary me-auto" onclick='saveChanges(this);'>Save changes</button>
    </div>
    <script>
    let timeout = null;
    async function saveChanges(btn) {
        clearTimeout(timeout);
        btn.disabled = true;
        btn.className = "btn btn-secondary me-auto";
        btn.innerText = "Saving changes...";
        const req = await fetch("/Api/RenderUser.ashx");
        const res = await req.json();
        btn.disabled = true;
        if(res.success) {
            btn.className = "btn btn-success me-auto";
            btn.innerText = "Saved changes!";
        } else {
            btn.className = "btn btn-danger me-auto";
            btn.innerText = "Failed to save changes!";
        }
        setTimeout(() => {
            btn.disabled = false;
            btn.className = "btn btn-primary me-auto";
            btn.innerText = "Save changes";
        }, res.timeoutRemaining * 1000);
        console.log(res.timeoutRemaining * 1000);
    }
    </script>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>