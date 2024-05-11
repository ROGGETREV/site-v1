<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");
http_response_code(503);
if(isset($_REQUEST["returnUrl"])) {
    $returnUrl = $_REQUEST["returnUrl"];
} else {
    $returnUrl = "/";
}
if(!$maintenance["enabled"]) {
    header('location: '.$returnUrl);
    exit;
}
$q = $con->prepare("SELECT count(*) FROM users");
$q->execute();
$usersCount = $q->fetchColumn();

$randomuserid1 = rand(1,$usersCount);
$randomuserid2 = rand(1,$usersCount);
$q = $con->prepare("SELECT * FROM users WHERE id = :id");
$q->bindParam(':id',$randomuserid1,PDO::PARAM_INT);
$q->execute();
$randomuser1 = $q->fetch();
$q = $con->prepare("SELECT * FROM users WHERE id = :id");
$q->bindParam(':id',$randomuserid2,PDO::PARAM_INT);
$q->execute();
$randomuser2 = $q->fetch();
?>
<!DOCTYPE html>
<html>
  <head>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/head.php"); ?>
    <title>Maintenance - ROGGET</title>
    <style>
      body {
        background-color: #1f2833;
        font-size: 16px;
        text-align: center;
        background: linear-gradient(-45deg, #008080, #ff1493, #ffd700, #00bfff);
        background-size: 400% 400%;
        animation: gradient 15s ease infinite;
      }
      @keyframes gradient {
        0% {
          background-position: 0% 50%;
        }
        50% {
          background-position: 100% 50%;
        }
        100% {
          background-position: 0% 50%;
        }
      }
      h1 {
        color: #fff;
        font-size: 48px;
        margin-top: 150px;
      }
      p {
        color: #fff;
        font-size: 24px;
        margin-top: 30px;
      }
      img {
        /* width: 200px; */
        height: 200px;
        margin-top: 50px;
        animation: logoanim 2s ease-in-out infinite;
      }
      #character1 {
        position: fixed;
        bottom: 0;
        width: 420px;
        height: 420px;
        background-image: url('/images/Users/Get.ashx?ID=<?php echo $randomuserid1; ?>');
        background-size: cover;
        animation: dance 1s ease-in-out infinite;
      }
      #character2 {
        position: fixed;
        bottom: 0;
        right: 0;
        width: 420px;
        height: 420px;
        background-image: url('/images/Users/Get.ashx?ID=<?php echo $randomuserid2; ?>');
        background-size: cover;
        animation: dance 1s ease-in-out infinite;
      }
      .text {
        /* animation: textanim 2s ease-in-out infinite; */
      }
      @keyframes dance {
        0% {
          transform: rotate(-25deg);
        }
        50% {
          transform: rotate(25deg);
        }
        100% {
          transform: rotate(-25deg);
        }
      }
      @keyframes logoanim {
        0% {
          transform: rotate(-5deg);
        }
        50% {
          transform: rotate(5deg);
        }
        100% {
          transform: rotate(-5deg);
        }
      }
    </style>
  </head>
  <body data-bs-theme="<?php echo $siteTheme; ?>">
    <img src="/images/logo.png" alt="ROGGET">
    <div class="text">
      <h1>Maintenance</h1>
      <p>Sorry, the site is currently undergoing maintenance. We'll be back soon!</p>
      <p id="reason">“<?php echo htmlspecialchars($maintenance["reason"]); ?>”</p>
      <p>You will get redirected when ROGGET is back online.</p>
    </div>
    <div id="character1"><?php echo htmlspecialchars($randomuser1["username"]); ?></div>
    <div id="character2"><?php echo htmlspecialchars($randomuser2["username"]); ?></div>
    <script>
        window.addEventListener('load', function () {
            var audio = new Audio("/audio/party.mp3?rand=<?php echo rand(1,getrandmax()); ?>");
            setInterval(function () {
                audio.play();
            }, 100);
        });
        setInterval(async () => {
            const req = await fetch("/Api/Maintenance.ashx");
            const res = await req.json();
            if(res.enabled === false) window.location = "<?php echo addslashes($returnUrl); ?>";
            document.querySelector("#reason").innerText = `“${res.reason}”`;
        }, 4000);
    </script>
  </body>
</html>