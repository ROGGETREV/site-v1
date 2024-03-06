<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
    <div class="container-fluid<?php /**/ ?>">
        <a class="navbar-brand" href="/">
            <img src="/images/logo.png" style="height: 28px;">
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
                    <a class="nav-link<?php if($_SERVER["PHP_SELF"] === "/Games.php") {echo " active";} ?>" href="/Games.aspx">Games</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?php if($_SERVER["PHP_SELF"] === "/Catalog.php" || $_SERVER["PHP_SELF"] === "/Item.php") {echo " active";} ?>" href="/Catalog.aspx">Catalog</a>
                </li>
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
                    <li><a class="dropdown-item" href="/Currency.aspx"><?php echo (int)$user["nuggets"]; ?> Nuggets</a></li>
                    <li><a class="dropdown-item" href="/Settings.aspx">Settings</a></li>
                    <li class="dropdown-divider"></li>
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