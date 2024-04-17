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
    <div class="<?php echo $containerClasses; ?>">
        <h1>Character Editor</h1>
        <div class="row">
            <div class="col-md-2">
                <img src="/images/Users/Get.ashx" id="preview" style="width: 100%;">
                <button class="btn btn-primary me-auto" onclick='renderUser(this);'>Render</button>
                <div style="height: 10px;"></div>
                <select class="form-select" aria-label="Render Year" id="renderYearSelector">
                    <option value="2008"<?php if($user["renderYear"] === "2008") echo " selected"; ?>>2008</option>
                    <option value="2011"<?php if($user["renderYear"] === "2011") echo " selected"; ?>>2011 (unstable)</option>
                    <option value="2011edited2016"<?php if($user["renderYear"] === "2011edited2016") echo " selected"; ?>>2011edited2016</option>
                    <option value="2016"<?php if($user["renderYear"] === "2016") echo " selected"; ?>>2016</option>
                </select>
            </div>
            <div class="col-md-10">
                <h4>Wearing</h4>
                <div class="card card-body">
                    <div class="row">
                        <?php
                        $q = $con->prepare("SELECT * FROM wearing WHERE user = :id");
                        $q->bindParam(':id', $user["id"], PDO::PARAM_INT);
                        $q->execute();
                        $count = 0;
                        foreach($q->fetchAll() as $wear) {
                        $qq = $con->prepare("SELECT * FROM catalog WHERE id = :id AND moderation = 'Accepted'");
                        $qq->bindParam(':id', $wear["item"], PDO::PARAM_INT);
                        $qq->execute();
                        $item = $qq->fetch();
                        if($item) {
                        $count++;
                        ?>
                        <div class="col-md-2">
                            <div class="card">
                                <div style="height: 0; padding-top: 100%; position: relative;">
                                    <img src="/images/Catalog/Get.ashx?ID=<?php echo (int)$item["id"]; ?>" class="card-img-top" style="position: absolute; top: 0; bottom: 0; left: 0; right: 0; width: 100%; height: 100%; cursor: pointer;" onclick='window.location = "/Item.aspx?ID=<?php echo (int)$item["id"]; ?>";'>
                                </div>
                                <div class="card-body" style="padding: 6px;">
                                    <h6 class="card-title"><?php echo htmlspecialchars($item["name"]); ?></h6>
                                    <button class="btn btn-outline-secondary" style="position: absolute;right: 0;top: 0;" onclick='unwear(<?php echo (int)$item["id"]; ?>);'>Unwear</button>
                                </div>
                            </div>
                        </div>
                        <?php }} if($count <= 0) {echo "You are not wearing anything.";} ?>
                    </div>
                </div>
                <br>
                <h4>Inventory</h4>
                <div class="card card-body">
                    <div class="row">
                        <?php
                        $q = $con->prepare("SELECT * FROM owneditems WHERE user = :id");
                        $q->bindParam(':id', $user["id"], PDO::PARAM_INT);
                        $q->execute();
                        $count = 0;
                        foreach($q->fetchAll() as $owned) {
                        $qq = $con->prepare("SELECT * FROM catalog WHERE id = :id AND moderation = 'Accepted'");
                        $qq->bindParam(':id', $owned["item"], PDO::PARAM_INT);
                        $qq->execute();
                        $item = $qq->fetch();
                        if($item) {
                        $qq = $con->prepare("SELECT * FROM wearing WHERE user = :id AND item = :iid");
                        $qq->bindParam(':id', $user["id"], PDO::PARAM_INT);
                        $qq->bindParam(':iid', $owned["item"], PDO::PARAM_INT);
                        $qq->execute();
                        $wearing = $qq->fetch();
                        if(!$wearing) {
                        $count++;
                        ?>
                        <div class="col-md-2">
                            <div class="card">
                                <div style="height: 0; padding-top: 100%; position: relative;">
                                    <img src="/images/Catalog/Get.ashx?ID=<?php echo (int)$item["id"]; ?>" class="card-img-top" style="position: absolute; top: 0; bottom: 0; left: 0; right: 0; width: 100%; height: 100%; cursor: pointer;" onclick='window.location = "/Item.aspx?ID=<?php echo (int)$item["id"]; ?>";'>
                                </div>
                                <div class="card-body" style="padding: 6px;">
                                    <h6 class="card-title"><?php echo htmlspecialchars($item["name"]); ?></h6>
                                    <button class="btn btn-outline-secondary" style="position: absolute;right: 0;top: 0;" onclick='wear(<?php echo (int)$item["id"]; ?>);'>Wear</button>
                                </div>
                            </div>
                        </div>
                        <?php }}} if($count <= 0) {echo "You do not have anything here.";} ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.querySelector("#renderYearSelector").addEventListener("change", () => {
        setRenderYear(document.querySelector("#renderYearSelector").value);
    })
    let timeout = null;
    async function renderUser(btn) {
        clearTimeout(timeout);
        btn.disabled = true;
        btn.className = "btn btn-secondary me-auto";
        btn.innerText = "Rendering...";
        const data = new FormData();
        data.append("csrf_token", getCSRFCookie())
        const req = await fetch("/Api/RenderUser.ashx", {
            method: "POST",
            body: data
        });
        const res = await req.json();
        btn.disabled = true;
        if(res.success) {
            btn.className = "btn btn-success me-auto";
            btn.innerText = "Rendered!";
            document.querySelector("#preview").src = "/images/Users/Get.ashx?" + Date.now();
        } else {
            btn.className = "btn btn-danger me-auto";
            btn.innerText = "Failed to render!";
            alert("Uh oh! An error occurred while rendering: " + res.message);
        }
        setTimeout(() => {
            btn.disabled = false;
            btn.className = "btn btn-primary me-auto";
            btn.innerText = "Render";
        }, res.timeoutRemaining * 1000);
    }
    async function unwear(id) {
        const data = new FormData();
        data.append("ID", id)
        data.append("csrf_token", getCSRFCookie())
        const req = await fetch("/Api/UserUnwear.ashx", {
            method: "POST",
            body: data
        });
        const res = await req.json();
        if(res.success) location.reload();
        else alert("Uh oh! An error occurred while unwearing: " + res.message);
    }
    async function wear(id) {
        const data = new FormData();
        data.append("ID", id)
        data.append("csrf_token", getCSRFCookie())
        const req = await fetch("/Api/UserWear.ashx", {
            method: "POST",
            body: data
        });
        const res = await req.json();
        if(res.success) location.reload();
        else alert("Uh oh! An error occurred while wearing: " + res.message);
    }
    async function setRenderYear(year) {
        const data = new FormData();
        data.append("year", year)
        data.append("csrf_token", getCSRFCookie())
        const req = await fetch("/Api/SetUserRenderYear.ashx", {
            method: "POST",
            body: data
        });
        const res = await req.json();
        if(res.success) location.reload();
        else alert("Uh oh! An error occurred while setting render year: " + res.message);
    }
    </script>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>