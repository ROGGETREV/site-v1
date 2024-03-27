<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/head.php"); ?>
    <title>Catalog - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <br>
    <div class="<?php echo $containerClasses; ?>">
        <h2>Catalog</h2>
        <div class="row">
            <div class="col-md-2">
                <img src="/images/CatalogAssets/browsebycategory.png" style="width: 100%;">
            </div>
            <div class="col-md-10">
                <h4>Featured Items on ROGGET</h4>
                <div class="row">
                    <?php
                    $q = $con->prepare("SELECT * FROM catalog WHERE moderation = 'Accepted'");
                    $q->execute();
                    foreach($q->fetchAll() as $item) {
                    $owned = false;
                    $qq = $con->prepare("SELECT * FROM owneditems WHERE user = :id AND item = :iid");
                    $qq->bindParam(':id', $user["id"], PDO::PARAM_INT);
                    $qq->bindParam(':iid', $item["id"], PDO::PARAM_INT);
                    $qq->execute();
                    if($qq->fetch()) $owned = true;
                    ?>
                    <div class="col-md-2" style="cursor: pointer;" onclick='window.location = "/Item.aspx?ID=<?php echo (int)$item["id"]; ?>";'>
                        <div class="card">
                            <div style="height: 0; padding-top: 100%; position: relative;">
                                <img src="/images/Catalog/Get.ashx?ID=<?php echo (int)$item["id"]; ?>" class="card-img-top" style="position: absolute; top: 0; bottom: 0; left: 0; right: 0; width: 100%; height: 100%;">
                            </div>
                            <div class="card-body" style="padding: 6px;">
                                <h6 class="card-title"><?php echo htmlspecialchars($item["name"]); ?></h6>
                                <p class="card-text"><?php echo htmlspecialchars(ucfirst($item["type"])); ?> - <?php if(!$owned) {echo (int)$item["nuggets"]." Nuggets";} else {echo "Owned";} ?></p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>