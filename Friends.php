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
    <title>Friends - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <br>
    <div class="<?php echo $containerClasses; ?>">
        <h2>Friends</h2>
        <?php
        $q = $con->prepare("SELECT * FROM friendships WHERE ((user1 = :id) OR (user2 = :id)) AND accepted = 1");
        $q->bindParam(':id', $user["id"], PDO::PARAM_INT);
        $q->execute();
        foreach(array_reverse($q->fetchAll()) as $friendship) {
        
        $otherUserID = 0;

        if((int)$friendship["user1"] === (int)$user["id"]) $otherUserID = (int)$friendship["user2"];
        else $otherUserID = (int)$friendship["user1"];

        $qq = $con->prepare("SELECT * FROM users WHERE id = :id");
        $qq->bindParam(':id', $otherUserID, PDO::PARAM_INT);
        $qq->execute();
        $usr = $qq->fetch();
        ?>
        <div class="card" style="margin-top: 5px;cursor: pointer;" onclick='window.location = "/User.aspx?ID=<?php echo (int)$usr["id"]; ?>";'>
            <div class="d-flex">
                <img src="/images/Users/Get.ashx?ID=<?php echo (int)$usr["id"]; ?>" onerror='this.src = "/images/loaderror.png";' style="width: 80px;height: 80px;">
                <div style="margin-left: 12px;margin-top: 8px;">
                    <h3><?php echo htmlspecialchars($usr["username"]); ?></h3>
                    <h6><?php echo htmlspecialchars($usr["description"]); ?></h6>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>