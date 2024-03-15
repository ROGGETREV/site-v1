<?php
$q = $con->prepare("SELECT * FROM alerts");
$q->execute();
foreach($q->fetchAll() as $alert) { ?>
<br>
<div class="container p-3 bg-<?php echo $alert["color"]; ?> rounded-3">
    <?php echo htmlspecialchars($alert["content"]); ?>
</div>
<?php } ?>