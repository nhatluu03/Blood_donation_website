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
    <main class="main">
        <div class="registration hr">
            <div class="registration--left">
                <h2 class="registration--left__heading">Welcome donators to the Blood mana community</h2>
                <hr>
                <p class="registration--left__desc">Collaborate with 50+ hospitals in our ecosystem</p>
            </div>
            <form method="POST" class="registration--right form reg-hr-form">
                <h2 class="form-name">Sign up</h2>
                <div class="form-field">
                    <label for="reg-hr-username" class="form-field__label">Username</label>
                    <input type="text" name="reg_hr_username" id="reg-hr-username" class="form-field__input" placeholder="Enter your username">
                    <span class="form-field__message"></span>
                </div>
                <div class="form-field">
                    <label for="reg-hr-password" class="form-field__label">Password</label>
                    <input type="text" name="reg_hr_password" id="reg-hr-password" class="form-field__input" placeholder="Enter your password">
                    <span class="form-field__message"></span>
                </div>
                <div class="form-field">
                    <label for="reg-hr-name" class="form-field__label">Full name</label>
                    <input type="text" name="reg_hr_name" id="reg-hr-name" class="form-field__input" placeholder="Enter your full name">
                    <span class="form-field__message"></span>
                </div>
                <div class="form-field">
                    <label for="reg-hr-phone" class="form-field__label">Phone</label>
                    <input type="number" name="reg_hr_phone" id="reg-hr-phone" class="form-field__input" placeholder="Enter phone number">
                    <span class="form-field__message"></span>
                </div>
                <div class="form-field">
                    <label for="reg-hr-hospital-id" class="form-field__label">Hospital</label>
                    <select name="reg_hr_hospital_id" id="reg-hr-hospital-id" class="form-field__input">
                        <option value="selectcard">-- Please select hospital --</option>
                        <?php
                        $query = "SELECT id, name FROM hospital";
                        $res = mysqli_query($conn, $query);
                        if (mysqli_num_rows($res) > 0) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <span class="form-field__message"></span>
                </div>
                <div class="form-field check-box-field">
                    <input type="checkbox" name="reg_hr_accept_policy" id="reg-hr-accept-policy" class="form-field__input">
                    <label for="is-accept-policy" class="form__extra-msg"> Agree with our <a href="./terms.php">Terms and Policies</a></label>
                    <span class="form-field__message"></span>
                </div>
                <div class="form-field">
                    <input type="submit" name="reg_hr_btn" class="form-field__input btn-hover color-9" id="reg-hr-btn" value="Register">
                    <span class="form-field__message"></span>
                </div>
                <p class="form__extra-msg">Already had an account? <a href="./index.php">Sign in</a> </p>
            </form>
        </div>
    </main>

    <script src="./assets/js/preventDefaultSubmission.js"></script>
    <script src="./assets/js/popupMsg.js"></script>
    <script src="./assets/js/validator.js"></script>
    <script>
        function validateHrRegistrationForm() {
            let username = document.querySelector('#reg-hr-username');
            let password = document.querySelector('#reg-hr-password');
            let name = document.querySelector('#reg-hr-name');
            let phone = document.querySelector('#reg-hr-phone');
            let hospitalId = document.querySelector('#reg-hr-hospital-id');
            let isAcceptPolicy = document.querySelector('#reg-hr-accept-policy');


            let usernameVal = username.value.trim();
            let passwordVal = password.value.trim();
            let nameVal = name.value.trim();
            let phoneVal = phone.value.trim();

            let isValidUsername = isValidPassword = isValidName = isValidPhone = isValidHospitalId = isValidAcceptPolicy = false;

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

            // Phone validation
            if (!phoneVal) {
                showError(phone, "Phone number cannot be empty");
            } else if (phoneVal.length != 10 || !checkOnlyDigits(phoneVal)) {
                showError(phone, "Invalid phone number");
            } else {
                isValidPhone = true;
                showSuccess(phone);
            }

            // Hospital id validation
            isValidHospitalId = checkSelect(hospitalId);

            // Policy accept checkbox validation
            isValidAcceptPolicy = checkCheckBox(isAcceptPolicy);

            return isValidUsername && isValidPassword && isValidName && isValidHospitalId && isValidAcceptPolicy;
        }

        // document.querySelector('.reg-hr-form').onchange = validateHrRegistrationForm();
        document.querySelector("#reg-hr-btn").addEventListener("click", function() {
            let regForm = document.querySelector('.reg-hr-form');
            let fd = new FormData(regForm);

            // Validation here
            let isValidHrRegistration = validateHrRegistrationForm();

            // Validate the field while entering input
            document.querySelectorAll('.reg-hr-form .form-field__input').forEach(item => {
                item.oninput = function() {
                    isValidHrRegistration = validateHrRegistrationForm();
                }
            });

            if (isValidHrRegistration) {
                $.ajax({
                    url: "./add_hr.php",
                    type: "POST",
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert(response);
                        if (response == "1") {
                            document.querySelector('.reg-hr-form').reset();
                            createPopupMsg("success", "Successfully register the account");
                        } else if (response == "0") {
                            showError(document.querySelector("#reg-hr-username"), "Username already exists");
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