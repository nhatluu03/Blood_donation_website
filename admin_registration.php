<?php
include('./db/connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- css for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- css for font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="./assets/css/base.css">
    <link rel="stylesheet" href="./assets/css/registration.css">
    <link rel="stylesheet" href="./assets/css/headernfooter.css">
</head>

<body>
    <!-- Header section -->
    <?php include './ex_header.php' ?>

    <!-- Main section -->
    <div class="main">
        <div class="registration hr">
            <div class="registration--left">
                <h2 class="registration--left__heading">Welcome system admins Blood mana community</h2>
                <hr>
                <p class="registration--left__desc">Let's build the ecosystem</p>
            </div>
            <form method="POST" class="registration--right form reg-admin-form">
                <h2 class="form-name">Admin registration</h2>
                <div class="form-field">
                    <label for="reg-admin-username" class="form-field__label">Username</label>
                    <input type="text" name="reg_admin_username" id="reg-admin-username" class="form-field__input" placeholder="Enter your username">
                    <span class="form-field__message"></span>
                </div>
                <div class="form-field">
                    <label for="reg-admin-password" class="form-field__label">Password</label>
                    <input type="text" name="reg_admin_password" id="reg-admin-password" class="form-field__input" placeholder="Enter your password">
                    <span class="form-field__message"></span>
                </div>
                <div class="form-field">
                    <label for="reg-admin-name" class="form-field__label">Full name</label>
                    <input type="text" name="reg_admin_name" id="reg-admin-name" class="form-field__input" placeholder="Enter your full name">
                    <span class="form-field__message"></span>
                </div>
                <div class="form-field">
                    <label for="reg-admin-phone" class="form-field__label">Phone</label>
                    <input type="number" name="reg_admin_phone" id="reg-admin-phone" class="form-field__input" placeholder="Enter phone number">
                    <span class="form-field__message"></span>
                </div>
                <div class="form-field">
                    <input type="submit" name="reg_admin_btn" class="form-field__input btn-hover color-9" id="reg-admin-btn" value="Register">
                    <span class="form-field__message"></span>
                </div>
                <p class="form__extra-msg">Already had an account? <a href="./index.php">Sign in</a> </p>
            </form>
        </div>
    </div>

    <script src="./assets/js/preventDefaultSubmission.js"></script>
    <script src="./assets/js/popupMsg.js"></script>
    <script src="./assets/js/validator.js"></script>
    <script>
        function validateAdminRegistrationForm() {
            let username = document.querySelector('#reg-admin-username');
            let password = document.querySelector('#reg-admin-password');
            let name = document.querySelector('#reg-admin-name');

            let usernameVal = username.value.trim();
            let passwordVal = password.value.trim();
            let nameVal = name.value.trim();

            let isValidUsername = isValidPassword = isValidName = false;

            // Username validation
            if (!usernameVal) {
                showError(username, "Username cannot be empty");
            } else if (!checkBetweenLength(usernameVal, 5, 50)) {
                showError(username, "Username length must be between 5 and 50 characters");
            } else if (checkSymbol(usernameVal)) {
                showError(username, "Username cannot contain symbols");
            } else {
                isValidUsername = true;
                showSuccess(username);
            }

            // Password validation
            if (!passwordVal) {
                showError(password, "Password cannot be empty");
            } else if (!checkSymbol(passwordVal)) {
                showError(password, "At least one symbol is required");
            } else if (!checkNumber(passwordVal)) {
                showError(password, "At least one number is required");
            } else {
                isValidPassword = true;
                showSuccess(password);
            }

            // Full name validation
            if (!nameVal) {
                showError(name, "Full name cannot be empty");
            } else if (!checkBetweenLength(nameVal, 5, 50)) {
                showError(name, "Length of full name must be between 5 and 50 characters");
            } else if (checkSymbol(nameVal)) {
                showError(name, "Full name cannot contain symbols");
            } else {
                isValidName = true;
                showSuccess(name);
            }

            return isValidUsername && isValidPassword && isValidName;
        }

        // document.querySelector('.reg-hr-form').onchange = validateAdminRegistrationForm();
        document.querySelector("#reg-admin-btn").addEventListener("click", function() {
            let regForm = document.querySelector('.reg-admin-form');
            let fd = new FormData(regForm);

            // Validation here
            let isValidAdminRegistration = validateAdminRegistrationForm();

            // Validate the field while entering input
            document.querySelectorAll('.reg-admin-form .form-field__input').forEach(item => {
                item.oninput = function() {
                    isValidAdminRegistration = validateAdminRegistrationForm();
                }
            });

            if (isValidAdminRegistration) {
                $.ajax({
                    url: "./add_admin.php",
                    type: "POST",
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // alert(response);
                        if (response == "1") {
                            document.querySelector('.reg-admin-form').reset();
                            createPopupMsg("success", "Successfully register the account");
                        } else if (response == "0") {
                            showError(document.querySelector("#reg-admin-username"), "Username already exists");
                        }
                    },
                    fail: function() {
                        createPopupMsg("fail", "Something went wrong. Please try again!");
                    },
                    error: function() {
                        createPopupMsg("fail", "Something went wrong. Please try again!");
                    }
                })
            }
        })
    </script>
</body>

</html>