<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");

if(!isset($_REQUEST["ID"])) {
    header('location: /request-error.aspx?code=404');
    exit;
}
$id = (int)$_REQUEST["ID"];

$q = $con->prepare("SELECT * FROM catalog WHERE id = :id");
$q->bindParam(':id', $id, PDO::PARAM_INT);
$q->execute();
$item = $q->fetch();
if(!$item || $item["moderation"] !== "Accepted") {
    header('location: /request-error.aspx?code=404');
    exit;
}

$q = $con->prepare("SELECT * FROM users WHERE id = :id");
$q->bindParam(':id', $item["creator"], PDO::PARAM_INT);
$q->execute();
$usr = $q->fetch();
if(!$usr) {
    header('location: /request-error.aspx?code=404');
    exit;
}

$owned = false;
$q = $con->prepare("SELECT * FROM owneditems WHERE user = :id AND item = :iid");
$q->bindParam(':id', $user["id"], PDO::PARAM_INT);
$q->bindParam(':iid', $id, PDO::PARAM_INT);
$q->execute();
if($q->fetch()) $owned = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/head.php"); ?>
    <title><?php echo htmlspecialchars($item["name"]); ?> - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <br>

    <div class="<?php echo $containerClasses; ?>">
        <!-- Main page -->
        <h2><a href="/Catalog.aspx">< Back to Catalog</a></h2>
        <h3>ROGGET <?php echo htmlspecialchars(ucfirst($item["type"])); ?></h3>
        <div class="row">
            <div class="col-md-3">
                <img src="/images/Catalog/Get.ashx?ID=<?php echo (int)$item["id"]; ?>" onerror='this.src = "/images/loaderror.png";' style="width: 100%;">
            </div>
            <div class="col-md-9">
                <h2><?php echo htmlspecialchars($item["name"]); ?></h2>
                <h6>By <a href="/User.aspx?ID=<?php echo (int)$usr["id"]; ?>"><?php echo htmlspecialchars($usr["username"]); ?></a></h6>
                <br><br><br><br><br><br><br>
                <?php if($loggedin) {
                if(!$owned) { ?>
                <br><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#purchaseModal">Purchase for <?php echo (int)$item["nuggets"]; ?> Nuggets</button>
                <?php } else { ?>
                <span>You already own this item.</span><br>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelPurchaseModal">Cancel Purchase</button>
                <?php }} else { ?>
                <br><button class="btn btn-secondary" onclick='window.location = "/Default.aspx";'>Login to purchase</button>
                <?php } ?>
            </div>
        </div>
        <br>
        <h3>Description</h3>
        <h6><?php echo htmlspecialchars($item["description"]); ?></h6>
    </div>
    <?php
    if($loggedin) {
    if(!$owned) { ?>
    <!-- Purchase modal -->
    <div class="modal fade" id="purchaseModal" tabindex="-1" aria-labelledby="purchaseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="purchaseModalLabel">Purchase</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Would you like to buy <?php echo htmlspecialchars($item["name"]); ?> for <?php echo (int)$item["nuggets"]; ?> Nuggets?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="purchaseModalCancel">Close</button>
                    <button class="btn btn-primary" id="purchaseModalPurchase">Purchase</button>
                </div>
            </div>
        </div>
    </div>
    <script type="module">
    const purchase = document.querySelector("#purchaseModalPurchase");
    const cancel = document.querySelector("#purchaseModalCancel");
    
    purchase.addEventListener("click", async () => {
        purchase.disabled = true;
        cancel.disabled = true;
        purchase.className = "btn btn-secondary";
        purchase.innerText = "Purchasing...";

        const data = new FormData();
        data.append("csrf_token", getCSRFCookie());
        const req = await fetch("/Api/Purchase.ashx?ID=<?php echo (int)$item["id"]; ?>&nuggets=<?php echo (int)$item["nuggets"]; ?>", {
            method: "POST",
            body: data
        });
        const res = await req.json();
        if(res.success) {
            purchase.className = "btn btn-success";
            purchase.innerText = "Purchased!";
            location.reload();
        } else {
            purchase.disabled = false;
            cancel.disabled = false;
            purchase.className = "btn btn-danger";
            purchase.innerText = "Purchase failed!";
            alert("Uh oh! An error occurred while purchasing item: " + res.message);
        }
    });
    </script>
    <?php } else { ?>
    <!-- Cancel Purchase modal -->
    <div class="modal fade" id="cancelPurchaseModal" tabindex="-1" aria-labelledby="cancelPurchaseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="cancelPurchaseModalLabel">Cancel Purchase</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Would you like to remove <?php echo htmlspecialchars($item["name"]); ?> from your inventory? You will not get your nuggets back!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelPurchaseModalClose">Close</button>
                    <button class="btn btn-danger" id="cancelPurchaseModalCancel">Cancel Purchase</button>
                </div>
            </div>
        </div>
    </div>
    <script type="module">
    const cancel = document.querySelector("#cancelPurchaseModalCancel");
    const close = document.querySelector("#cancelPurchaseModalClose");
    
    cancel.addEventListener("click", async () => {
        cancel.disabled = true;
        close.disabled = true;
        cancel.className = "btn btn-secondary";
        cancel.innerText = "Cancelling Purchase...";

        const data = new FormData();
        data.append("csrf_token", getCSRFCookie());
        const req = await fetch("/Api/CancelPurchase.ashx?ID=<?php echo (int)$item["id"]; ?>", {
            method: "POST",
            body: data
        });
        const res = await req.json();
        if(res.success) {
            cancel.className = "btn btn-success";
            cancel.innerText = "Cancelled Purchase!";
            location.reload();
        } else {
            cancel.disabled = false;
            close.disabled = false;
            cancel.className = "btn btn-danger";
            cancel.innerText = "Cancel failed!";
            alert("Uh oh! An error occurred while cancelling purchase: " + res.message);
        }
    });
    </script>
    <?php }} ?>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>