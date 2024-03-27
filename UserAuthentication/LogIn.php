<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/config.php");

if($loggedin) {
    header('location: /Home.aspx');
    exit;
}

if(str_contains($_SERVER["HTTP_USER_AGENT"], "ROBLOX Android App")) {
    header('location: /Games.aspx');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/head.php"); ?>
    <title>Log In - ROGGET</title>
</head>
<body data-bs-theme="<?php echo $siteTheme; ?>">
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/header.php"); ?>
    <img src="/images/game.png" style="position: fixed;width: 100%;z-index: -999999999999;border-radius: 15px;filter: blur(10px);">
    <br>
    <div class="<?php echo $containerClasses; ?>">
        <h2>Log In to ROGGET</h2>
        <p>Don't have an account? <a href="/UserAuthentication/SignUp.aspx">Sign Up</a>!</p>
        <div class="card card-body">
            <label id="usernameLabel">Username <span class="text-danger"></span></label>
            <input type="text" id="username" class="form-control" maxlength="20" placeholder="OnlyTwentyCharacters">
            <br>
            <label id="passwordLabel">Password <span class="text-danger"></span></label>
            <input type="password" id="password" class="form-control" placeholder="Very!Secret?&=52">
            <br>
            <span id="captchaError" class="text-danger"></span>
            <div class="g-recaptcha" data-theme="<?php echo $siteTheme; ?>" data-sitekey="<?php echo $reCAPTCHA["site"]; ?>"></div>
            <br>
            <button type="submit" id="submitBtn" class="btn btn-primary">Log In!</button>
        </div>
    </div>
    <script>
    const username = document.querySelector("#username");
    const password = document.querySelector("#password");
    const submit = document.querySelector("#submitBtn");

    function clearErrors() {
        document.querySelector("#usernameLabel span").innerText = "";
        document.querySelector("#passwordLabel span").innerText = "";
        document.querySelector("#captchaError").innerText = "";
    }

    function disableSubmit() {
        submit.disabled = true;
        submit.className = "btn btn-secondary";
        submit.innerText = "Logging In...";
    }

    function enableSubmit() {
        submit.disabled = false;
        submit.className = "btn btn-primary";
        submit.innerText = "Log In!";
    }

    function successSubmit() {
        submit.disabled = true;
        submit.className = "btn btn-success";
        submit.innerText = "Welcome back!";
    }

    submit.addEventListener("click", async () => {
        clearErrors();
        disableSubmit();

        if(username.value.length < 3) {
            enableSubmit();
            grecaptcha.reset();
            return document.querySelector("#usernameLabel span").innerText = "must be at least 3 characters";
        }
        if(username.value.length > 20) {
            enableSubmit();
            grecaptcha.reset();
            return document.querySelector("#usernameLabel span").innerText = "must be less than 20 characters";
        }
        if(password.value === username.value) {
            enableSubmit();
            grecaptcha.reset();
            return document.querySelector("#passwordLabel span").innerText = "can't be your username";
        }
        if(password.value.length < 8) {
            enableSubmit();
            grecaptcha.reset();
            return document.querySelector("#passwordLabel span").innerText = "must be at least 8 characters";
        }
        const data = new FormData();
        data.append("username", username.value);
        data.append("password", password.value);
        data.append("g-recaptcha-response", document.querySelector("#g-recaptcha-response").value);
        const req = await fetch("/Api/LogIn.ashx", {
            method: "POST",
            body: data
        });
        const res = await req.json();
        if(res.success) {
            successSubmit();
            document.cookie = ".ROGGETSECURITY=" + res.authentication + "; expires=" + new Date(new Date().getTime() + 365 * 24 * 60 * 60 * 1000).toUTCString() + "; path=/";
            window.location = "/Home.aspx";
        } else {
            enableSubmit();
            grecaptcha.reset();
            if(res.problem !== "captcha") {
                return document.querySelector("#" + res.problem + "Label span").innerText = res.message;
            } else {
                return document.querySelector("#captchaError").innerText = res.message;
            }
        }
        enableSubmit();
    });
    </script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php require_once($_SERVER["DOCUMENT_ROOT"]."/main/footer.php"); ?>
</body>
</html>