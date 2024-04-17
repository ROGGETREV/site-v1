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
    if(!isset($_REQUEST["ID"])) {
        header('location: /Messages.aspx');
        exit;
    }
    $id = (int)$_REQUEST["ID"];

    $q = $con->prepare("SELECT * FROM messages WHERE id = :id");
    $q->bindParam(':id', $id, PDO::PARAM_INT);
    $q->execute();
    $message = $q->fetch();

    if(!$message) {
        header('location: /Messages.aspx');
        exit;
    }

    if((int)$message["user1"] !== (int)$user["id"] && (int)$message["user2"] !== (int)$user["id"]) {
        header('location: /Messages.aspx');
        exit;
    }

    if((int)$message["reply"] !== 0) {
        header('location: /Message.aspx?ID='.(int)$message["reply"]);
        exit;
    }

    $q = $con->prepare("UPDATE messages SET hasBeenRead = 1 WHERE id = :id");
    $q->bindParam(':id', $id, PDO::PARAM_INT);
    $q->execute();

    $sender = $user;
    $receiver = $user;

    if((int)$message["user1"] === (int)$user["id"]) {
        $q = $con->prepare("SELECT * FROM users WHERE id = :id");
        $q->bindParam(':id', $message["user2"], PDO::PARAM_INT);
        $q->execute();
        $receiver = $q->fetch();
    } else if((int)$message["user2"] === (int)$user["id"]) {
        $q = $con->prepare("SELECT * FROM users WHERE id = :id");
        $q->bindParam(':id', $message["user1"], PDO::PARAM_INT);
        $q->execute();
        $sender = $q->fetch();
    }

    $sentmessages = [];
    array_push($sentmessages, $message);

    $q = $con->prepare("SELECT * FROM messages WHERE reply = :id");
    $q->bindParam(':id', $id, PDO::PARAM_INT);
    $q->execute();
    foreach($q->fetchAll() as $msg) array_push($sentmessages, $msg);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/head.php"); ?>
    <title><?php echo htmlspecialchars($message["subject"]); ?> - Messages - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <br>
    <div class="<?php echo $containerClasses; ?>">
        <a href="/Messages.aspx"><h2>< Back to Messages</h2></a>
        <?php if($csrf) { ?>
        <h4>Messages between <?php echo htmlspecialchars($sender["username"]); ?> and <?php echo htmlspecialchars($receiver["username"]); ?></h4>
        <?php foreach($sentmessages as $msg) {
        $sender = $user;
        $receiver = $user;
        
        if((int)$msg["user1"] === (int)$user["id"]) {
            $q = $con->prepare("SELECT * FROM users WHERE id = :id");
            $q->bindParam(':id', $msg["user2"], PDO::PARAM_INT);
            $q->execute();
            $receiver = $q->fetch();
        } else if((int)$msg["user2"] === (int)$user["id"]) {
            $q = $con->prepare("SELECT * FROM users WHERE id = :id");
            $q->bindParam(':id', $msg["user1"], PDO::PARAM_INT);
            $q->execute();
            $sender = $q->fetch();
        }
        ?>
        <div class="card card-body" style="margin-top: 10px;">
            <button class="btn btn-outline-primary float-end ms-auto" style="position: absolute;right: 10px;top: 10px;" onclick='window.location = "/MessageReply.aspx?ID=<?php echo (int)$message["id"]; ?>";'><i class="bi bi-reply-fill"></i></button>
            <div class="d-flex">
                <img src="/images/Users/Get.ashx?ID=<?php echo (int)$sender["id"]; ?>" onerror='this.src = "/images/loaderror.png";' onclick='window.location = "/User.aspx?ID=<?php echo (int)$user["id"]; ?>";' style="width: 60px;height: 60px;cursor: pointer;">
                <div style="margin-left: 12px;">
                    <h5><?php echo htmlspecialchars($sender["username"]); ?></h5>
                    <h6 class="text-muted"><?php echo datetime($msg["created"]); ?></h6>
                </div>
            </div>
            <h3><?php echo htmlspecialchars($msg["subject"]); ?></h3>
            <h6><?php echo nl2br(htmlspecialchars($msg["content"])); ?></h6>
        </div>
        <?php } ?>
        <?php } else { ?>
        <h3>Loading message...</h3>
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