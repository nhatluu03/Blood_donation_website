<style>
    .hor-nav {
        margin: 0 10%;
    }
</style>
<header>
    <nav class="hor-nav">
        <a href="./index.php" class="brand">
            <img src="./assets/img/logo.png" alt="" class="brand__logo">
            <span class="brand__name">Blood Mana</span>
        </a>
        <div class="hor-nav-container mobile-hide">
            <a href="./index.php" class="hor-nav-item">Home</a>
            <a href="./about.php" class="hor-nav-item">About</a>
            <a href="./contact.php" class="hor-nav-item">Contact</a>
            <a href="./terms.php" class="hor-nav-item">Terms</a>
            <a href="./qna.php" class="hor-nav-item">Q&A</a>
            <?php
            $current_page = ltrim($_SERVER['REQUEST_URI'], "/");
            if (str_ends_with($current_page, "registration.php")) {
                echo '<button class="hor-nav-item open-login-form-btn hide">Sign in</button>';
            } else {
                echo '<button class="hor-nav-item open-login-form-btn">Sign in</button>';
            }
            ?>
        </div>
        <i class="open-menu-ic fa-solid fa-bars pc-hide" onclick="openMobileNav()"></i>
        <i class="close-menu-ic fa-solid fa-xmark hide pc-hide" onclick="hideMobileNav()"></i>
        <div class="mobile-hor-nav-container hide pc-hide">
            <a href="./index.php" class="mobile-hor-nav-item">Home</a>
            <a href="./about.php" class="mobile-hor-nav-item">About</a>
            <a href="./contact.php" class="mobile-hor-nav-item">Contact</a>
            <a href="./terms.php" class="mobile-hor-nav-item">Terms</a>
            <a href="./qna.php" class="mobile-hor-nav-item">Q&A</a>
            <?php
            $current_page = ltrim($_SERVER['REQUEST_URI'], "/");
            if (str_ends_with($current_page, "registration.php")) {
                echo '<div class="mobile-hor-nav-item open-login-form-btn non-display">Sign in</div>';
            } else {
                echo '<div class="mobile-hor-nav-item open-login-form-btn">Sign in</div>';
            }
            ?>
            <a href="./donor_registration.php" class="mobile-hor-nav-item">Sign up</a>
        </div>
    </nav>
</header>
<div class="nav-overlay hide"></div>
<div class="overlay hide"></div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="login-form toggle-form hide">
    <h2 class="form-name">Sign in</h2>
    <i class="fa-solid fa-xmark close-ic"></i>
    <div class="form-field">
        <label for="log-username" class="form-field__label">Username</label>
        <input type="text" name="log_username" id="log-username" class="form-field__input" placeholder="Enter your username">
        <span class="form-field__message"></span>
    </div>
    <div class="form-field">
        <label for="log-password" class="form-field__label">Password</label>
        <input type="password" name="log_password" id="log-password" class="form-field__input" placeholder="Enter your password">
        <span class="form-field__message"></span>
    </div>
    <div class="form-field">
        <input type="submit" name="log_btn" class="form-field__input btn-hover color-4" id="log-btn" value="Login">
    </div>
    <p class="form__extra-msg">Don't have an account yet? <a href="./donor_registration.php">Sign up</a> </p>
    <br>
    <p class="form__extra-msg">Forgot password?</p>
</form>

<script src="./assets/js/preventDefaultSubmission.js"></script>
<script src="./assets/js/validator.js"></script>
<script src="./assets/js/toggleDisplayForm.js"></script>

<script>
    let loginFormSelector = document.querySelector('.login-form');
    let openLoginFormSelector = document.querySelectorAll('.open-login-form-btn');
    let closeLoginFormSelector = loginFormSelector.querySelector('.close-ic');

    function validateLoginForm() {
        let username = document.querySelector('#log-username');
        let password = document.querySelector('#log-password');

        let usernameVal = username.value.trim();
        let passwordVal = password.value.trim();

        let isValidUsername = isValidPassword = false;
        // Username validation
        if (!usernameVal) {
            showError(username, 'Username cannot be empty')
        } else {
            isValidUsername = true;
            showSuccess(username)
        }

        // Password validation
        if (!passwordVal) {
            showError(password, 'Password cannot be empty')
        } else {
            isValidPassword = true;
            showSuccess(password)
        }

        return isValidUsername && isValidPassword
    }

    document.querySelector('#log-btn').onclick = function() {
        let loginForm = document.querySelector(".login-form");
        let isValidLoginForm = validateLoginForm();
        let fd = new FormData(loginForm);
        let passwordField = document.querySelector('#log-password');

        if (isValidLoginForm) {
            $.ajax({
                url: "./check_login.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                success: function(response) {
                    switch (response) {
                        case "0":
                            showError(passwordField, "Wrong username or password");
                            break;
                        case "2":
                            location.replace('./donor_profile.php');
                            break;
                        case "3":
                            location.replace('./database_officer_workspace.php');
                            break;
                        case "4":
                            location.replace('./delivery_officer_workspace.php');
                            break;
                        case "5":
                            location.replace('./hr_officer_workspace.php');
                            break;
                        case "6":
                            location.replace('./dashboard/user_db.php');
                            break;
                        default:
                            alert("Something went wrong. Please try again!")
                    }
                },
                fail: function() {
                    alert("Something went wrong. Please try again!")
                },
                error: function() {
                    alert("Something went wrong. Please try again!")
                }
            })
        }
    }
</script>
<script src="./assets/js/toggleDisplayForm.js"></script>
<script src="./assets/js/validator.js"></script>

<script>
    let mobileNavContainer = document.querySelector('.mobile-hor-nav-container');
    let overlayNav = document.querySelector('.nav-overlay');
    let openMenuIc = document.querySelector('.open-menu-ic');
    let closeMenuIc = document.querySelector('.close-menu-ic');

    function openMobileNav() {
        mobileNavContainer.classList.remove('hide');
        overlayNav.classList.remove('hide');
        closeMenuIc.classList.remove('hide');
        openMenuIc.classList.add('hide');
    }

    function hideMobileNav() {
        mobileNavContainer.classList.add('hide');
        overlayNav.classList.add('hide');
        openMenuIc.classList.remove('hide');
        closeMenuIc.classList.add('hide');
    }
    overlayNav.onclick = hideMobileNav;

    Array.from(openLoginFormSelector).forEach(item => {
        item.addEventListener("click", () => {
            openForm(loginFormSelector);
            hideMobileNav();
        });
    })
    closeLoginFormSelector.addEventListener("click", () => {
        closeForm(loginFormSelector);
    });
</script>