<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/Management/inc.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/head.php"); ?>
    <title>Management - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <br>
    <div class="container card card-body advertisement ad">
        <h1>Management Panel</h1>
        <h4><?php echo htmlspecialchars($user["username"]); ?>, you are an <?php echo htmlspecialchars($user["permission"]); ?>!</h4>
        <div class="card" style="margin-top: 3px;">
            <?php require_once($_SERVER["DOCUMENT_ROOT"]."/Management/tabheader.php"); ?>
            <div class="card-body">
                <?php
                $error = "";
                if(!empty($_POST)) {
                    if(
                        !isset($_REQUEST["id"]) ||
                        empty($_REQUEST["id"])
                    ) {
                        $error = "Missing input";
                    } else {
                        $error = "Unmoderated successfully";
                        $id = (int)$_REQUEST["id"];
                        $q = $con->prepare("UPDATE users SET banned = 0, banreason = '' WHERE id = :id");
                        $q->bindParam(':id', $id, PDO::PARAM_INT);
                        $q->execute();
                    }
                }
                ?>
                <form action method="POST">
                    <span class="text-danger"><?php echo $error; ?></span>
                    <input type="number" name="id" class="form-control" placeholder="ID" style="width: 220px;margin-bottom: 5px;">
                    <button type="submit" class="btn btn-primary me-auto">Unmoderate</button>
                </form>
            </div>
        </div>
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>