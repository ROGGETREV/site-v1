<?php require_once($_SERVER["DOCUMENT_ROOT"]."/Management/inc.php"); ?>
<ul class="nav nav-tabs" style="margin: -1px;">
    <li class="nav-item">
        <a class="nav-link<?php if($_SERVER["PHP_SELF"] === "/Management/Account/Moderate.php") { echo " active"; } ?>" href="/Management/Account/Moderate.aspx">Account Moderation</a>
    </li>
    <li class="nav-item">
        <a class="nav-link<?php if($_SERVER["PHP_SELF"] === "/Management/Account/Unmoderate.php") { echo " active"; } ?>" href="/Management/Account/Unmoderate.aspx">Account Unmoderation</a>
    </li>
    <li class="nav-item">
        <a class="nav-link<?php if($_SERVER["PHP_SELF"] === "/Management/Alerts.php") { echo " active"; } ?>" href="/Management/Alerts.aspx">Alerts</a>
    </li>
</ul>