<?php if(!str_contains($_SERVER["HTTP_USER_AGENT"], "ROBLOX Android App")) { ?>
<!--iframe style="width: 100%;height: 100%;position: fixed;z-index: 0;" src="https://www.youtube.com/embed/xfGwJHW-xy0?si=HfqaJR1JxWvGcLrb" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe-->
<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
    <div class="container-fluid<?php /**/ ?>">
        <a class="navbar-brand" href="/">
            <img src="/images/logo.png" style="height: 28px;" onerror='this.src = "/images/loaderror.png";'>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link<?php if($_SERVER["PHP_SELF"] === "/Home.php") {echo " active";} ?>" href="/Home.aspx">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?php if($_SERVER["PHP_SELF"] === "/Games.php" || $_SERVER["PHP_SELF"] === "/Place.php") {echo " active";} ?>" href="/Games.aspx">Games</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?php if($_SERVER["PHP_SELF"] === "/Catalog.php" || $_SERVER["PHP_SELF"] === "/Item.php") {echo " active";} ?>" href="/Catalog.aspx">Catalog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?php if($_SERVER["PHP_SELF"] === "/People.php" || $_SERVER["PHP_SELF"] === "/User.php") {echo " active";} ?>" href="/People.aspx">People</a>
                </li>
                <?php if($loggedin) { ?>
                <li class="nav-item">
                    <a class="nav-link<?php if($_SERVER["PHP_SELF"] === "/Character.php") {echo " active";} ?>" href="/Character.aspx">Character</a>
                </li>
                <li class="nav-item">
                    <?php
                    $messageCount = "";
                    $q = $con->prepare("SELECT * FROM messages WHERE user2 = :id AND hasBeenRead = 0 AND reply = 0");
                    $q->bindParam(':id', $user["id"], PDO::PARAM_INT);
                    $q->execute();
                    $messages = $q->fetchAll();
                    if(count($messages) >= 1) $messageCount = " (".count($messages).")";
                    ?>
                    <a class="nav-link<?php if($_SERVER["PHP_SELF"] === "/Messages.php" || $_SERVER["PHP_SELF"] === "/Message.php") {echo " active";} ?>" href="/Messages.aspx">Messages<?php echo $messageCount; ?></a>
                </li>
                <?php } ?>
            </ul>
        </div>
        <ul class="navbar-nav">
            <?php if($loggedin) { ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo htmlspecialchars($user["username"]); ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="/User.aspx">Profile</a></li>
                    <li><a class="dropdown-item" href="/Nuggets.aspx"><?php echo (int)$user["nuggets"]; ?> Nuggets</a></li>
                    <li class="dropdown-divider"></li>
                    <?php if(in_array($user["permission"], [
                        "Moderator",
                        "Administrator"
                    ])) { ?>
                    <li><a class="dropdown-item" href="/Management/Panel.aspx">Management Panel</a></li>
                    <?php } ?>
                    <li><a class="dropdown-item" href="/Settings.aspx">Settings</a></li>
                    <li><a class="dropdown-item" href="/UserAuthentication/LogOut.aspx">Log Out</a></li>
                </ul>
            </li>
            <?php } else { ?>
            <li class="nav-item">
                <a class="nav-link<?php if($_SERVER["PHP_SELF"] === "/UserAuthentication/LogIn.php") {echo " active";} ?>" href="/UserAuthentication/LogIn.aspx">Log In</a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?php if($_SERVER["PHP_SELF"] === "/UserAuthentication/SignUp.php") {echo " active";} ?>" href="/UserAuthentication/SignUp.aspx">Sign Up</a>
            </li>
            <?php } ?>
        </ul>
    </div>
</nav>
<div style="width: 100%;height: 58px;"></div>
<?php } ?>
<?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/alerts.php"); ?>