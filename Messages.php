<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");

if(!$loggedin) {
    header('location: /Default.aspx');
    exit;
}


$csrf = true;
if(!isset($_REQUEST["csrf_token"])) {
    $csrf = false;
} else if(!isCorrectCSRF($_REQUEST["csrf_token"])) {
    $csrf = false;
}

if($csrf) {
    $q = $con->prepare("SELECT * FROM messages WHERE user2 = :id AND hasBeenRead = 0 AND reply = 0");
    $q->bindParam(':id', $user["id"], PDO::PARAM_INT);
    $q->execute();
    $unread = $q->fetchAll();

    $q = $con->prepare("SELECT * FROM messages WHERE user1 = :id AND reply = 0");
    $q->bindParam(':id', $user["id"], PDO::PARAM_INT);
    $q->execute();
    $sent = $q->fetchAll();

    $q = $con->prepare("SELECT * FROM messages WHERE user2 = :id AND hasBeenRead = 1 AND reply = 0");
    $q->bindParam(':id', $user["id"], PDO::PARAM_INT);
    $q->execute();
    $read = $q->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/head.php"); ?>
    <title>Messages - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <br>
    <div class="<?php echo $containerClasses; ?>">
        <button class="btn btn-outline-primary float-end ms-auto" style="position: absolute;right: 10px;top: 10px;" onclick='window.location = "/MessageSend.aspx";'><i class="bi bi-send-fill"></i></button>
        <h1>Messages</h1>
        <?php if($csrf) { ?>
        <h3>Unread Messages</h3>
        <?php if(count($unread) >= 1) {
        ?>
        <div class="card">
            <table class="table table-striped" style="margin: 0;">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">User</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Date</th>
                        <th scope="col">Read</th>
                    </tr>
                </thead>
                <tbody>
        <?php
        $count = 0;
        foreach($unread as $message) {
        $q = $con->prepare("SELECT * FROM users WHERE id = :id");
        $q->bindParam(':id', $message["user1"], PDO::PARAM_INT);
        $q->execute();
        $usr = $q->fetch();
        if($usr) {
        $count++;
        ?>
        <tr style="cursor: pointer;">
            <th scope="row" onclick='window.location = "/Message.aspx?ID=<?php echo (int)$message["id"]; ?>";'><?php echo (int)$count; ?></th>
            <td onclick='window.location = "/User.aspx?ID=<?php echo (int)$usr["id"]; ?>";'><?php echo htmlspecialchars($usr["username"]); ?></td>
            <td onclick='window.location = "/Message.aspx?ID=<?php echo (int)$message["id"]; ?>";'><?php echo htmlspecialchars($message["subject"]); ?></td>
            <td onclick='window.location = "/Message.aspx?ID=<?php echo (int)$message["id"]; ?>";'><?php echo htmlspecialchars(datetime($message["created"])); ?></td>
            <td onclick='window.location = "/Message.aspx?ID=<?php echo (int)$message["id"]; ?>";'><?php if($message["hasBeenRead"]) {echo "Yes";} else {echo "No";}; ?></td>
        </tr>
        <?php }} ?>
        </tbody>
            </table>
        </div>
        <?php } else { ?>
        <h6>You have read all of your messages. What a business man!</h6>
        <?php } ?>
        <br>
        <h3>Sent Messages</h3>
        <?php if(count($sent) >= 1) {
        ?>
        <div class="card">
            <table class="table table-striped" style="margin: 0;">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">User</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Date</th>
                        <th scope="col">Read</th>
                    </tr>
                </thead>
                <tbody>
        <?php
        $count = 0;
        foreach($sent as $message) {
        $q = $con->prepare("SELECT * FROM users WHERE id = :id");
        $q->bindParam(':id', $message["user1"], PDO::PARAM_INT);
        $q->execute();
        $usr = $q->fetch();
        if($usr) {
        $count++;
        ?>
        <tr style="cursor: pointer;">
            <th scope="row" onclick='window.location = "/Message.aspx?ID=<?php echo (int)$message["id"]; ?>";'><?php echo (int)$count; ?></th>
            <td onclick='window.location = "/User.aspx?ID=<?php echo (int)$usr["id"]; ?>";'><?php echo htmlspecialchars($usr["username"]); ?></td>
            <td onclick='window.location = "/Message.aspx?ID=<?php echo (int)$message["id"]; ?>";'><?php echo htmlspecialchars($message["subject"]); ?></td>
            <td onclick='window.location = "/Message.aspx?ID=<?php echo (int)$message["id"]; ?>";'><?php echo htmlspecialchars(datetime($message["created"])); ?></td>
            <td onclick='window.location = "/Message.aspx?ID=<?php echo (int)$message["id"]; ?>";'><?php if($message["hasBeenRead"]) {echo "Yes";} else {echo "No";}; ?></td>
        </tr>
        <?php }} ?>
        </tbody>
            </table>
        </div>
        <?php } else { ?>
        <h6>You didn't send any messages.</h6>
        <?php } ?>
        <br>
        <h3>Read Messages</h3>
        <?php if(count($read) >= 1) {
        ?>
        <div class="card">
            <table class="table table-striped" style="margin: 0;">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">User</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Date</th>
                        <th scope="col">Read</th>
                    </tr>
                </thead>
                <tbody>
        <?php
        $count = 0;
        foreach($read as $message) {
        $q = $con->prepare("SELECT * FROM users WHERE id = :id");
        $q->bindParam(':id', $message["user1"], PDO::PARAM_INT);
        $q->execute();
        $usr = $q->fetch();
        if($usr) {
        $count++;
        ?>
        <tr style="cursor: pointer;">
            <th scope="row" onclick='window.location = "/Message.aspx?ID=<?php echo (int)$message["id"]; ?>";'><?php echo (int)$count; ?></th>
            <td onclick='window.location = "/User.aspx?ID=<?php echo (int)$usr["id"]; ?>";'><?php echo htmlspecialchars($usr["username"]); ?></td>
            <td onclick='window.location = "/Message.aspx?ID=<?php echo (int)$message["id"]; ?>";'><?php echo htmlspecialchars($message["subject"]); ?></td>
            <td onclick='window.location = "/Message.aspx?ID=<?php echo (int)$message["id"]; ?>";'><?php echo htmlspecialchars(datetime($message["created"])); ?></td>
            <td onclick='window.location = "/Message.aspx?ID=<?php echo (int)$message["id"]; ?>";'><?php if($message["hasBeenRead"]) {echo "Yes";} else {echo "No";}; ?></td>
        </tr>
        <?php }} ?>
        </tbody>
            </table>
        </div>
        <?php } else { ?>
        <h6>You didn't read any messages.</h6>
        <?php } ?>
        <?php } else { ?>
        <h3>Loading messages...</h3>
        <form id="csrfForm" action="" method="POST" hidden>
            <input type="text" name="csrf_token" hidden>
        </form>
        <script>
        document.querySelector("#csrfForm input").value = getCSRFCookie();
        document.querySelector("#csrfForm").submit();
        </script>
        <?php } ?>
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>