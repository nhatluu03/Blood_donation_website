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
    <?php include('./ex_header.php') ?>

    <!-- Main section -->
    <main class="main">
        <div class="registration donor">
            <div class="registration--left">
                <div class="registration--left__content">
                    <h2 class="registration--left__heading">Welcome donators to the Blood mana community</h2>
                    <hr>
                    <p class="registration--left__desc">Join hands with 100.000+ blood donors with in our ecosystem</p>
                    <p>Powered by Team Name</p>
                </div>
            </div>
            <form action="POST" class="registration--right form reg-donor-form">
                <h2 class="form-name">Sign up</h2>
                <div class="form-field">
                    <label for="reg-donor-username" class="form-field__label">Username</label>
                    <input type="text" name="reg_donor_username" id="reg-donor-username" class="form-field__input" placeholder="Enter your username">
                    <span class="form-field__message"></span>
                </div>
                <div class="form-field">
                    <label for="reg-donor-password" class="form-field__label">Password</label>
                    <input type="text" name="reg_donor_password" id="reg-donor-password" class="form-field__input" placeholder="Enter your password">
                    <span class="form-field__message"></span>
                </div>
                <div class="form-field">
                    <label for="reg-donor-name" class="form-field__label">Full name</label>
                    <input type="text" name="reg_donor_name" id="reg-donor-name" class="form-field__input" placeholder="Enter your full name">
                    <span class="form-field__message"></span>
                </div>
                <div class="form-field">
                    <label for="reg-donor-blood-group-id" class="form-field__label">Blood group</label>
                    <select name="reg_donor_blood_group_id" id="reg-donor-blood-group-id" class="form-field__input">
                        <option value="selectcard">-- Please select blood group --</option>
                        <?php
                        $query = "SELECT id, name FROM blood_group";
                        $res = mysqli_query($conn, $query);
                        if (mysqli_num_rows($res) > 0) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                echo '<option value="' . $row['id'] . '">' . strtoupper($row['name']) . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <span class="form-field__message"></span>
                </div>
                <div class="form-field check-box-field">
                    <input type="checkbox" name="reg_donor_accept_policy" id="reg-donor-accept-policy" class="form-field__input">
                    <label for="reg-donor-accept-policy" class="form__extra-msg"> Agree with our <a href="./terms.php">Terms and Policies</a></label>
                    <span class="form-field__message"></span>
                </div>
                <div class="form-field">
                    <input type="submit" name="donor_reg_btn" class="form-field__input btn-hover color-4" id="reg-donor-btn" value="Register">
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
        function validateDonorRegistrationForm() {
            let username = document.querySelector('#reg-donor-username');
            let password = document.querySelector('#reg-donor-password');
            let name = document.querySelector('#reg-donor-name');
            let bloodGroupId = document.querySelector('#reg-donor-blood-group-id');
            let isAcceptPolicy = document.querySelector('#reg-donor-accept-policy');

            let usernameVal = username.value.trim();
            let passwordVal = password.value.trim();
            let nameVal = name.value.trim();

            let isValidUsername = isValidPassword = isValidName = isValidAcceptPolicy = isValidBloodGroupId = false;

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

            // Blood group id validation
            isValidBloodGroupId = checkSelect(bloodGroupId);

            // Policy accept checkbox validation
            isValidAcceptPolicy = checkCheckBox(isAcceptPolicy);

            return isValidUsername && isValidPassword && isValidName && isValidBloodGroupId && isValidAcceptPolicy;
        }


        // document.querySelector('.reg-donor-form').onchange = validateDonorRegistrationForm();

        document.querySelector("#reg-donor-btn").addEventListener("click", function() {
            let regForm = document.querySelector('.reg-donor-form');
            let fd = new FormData(regForm);

            // Validation here
            let isValidDonorRegistration = validateDonorRegistrationForm();

            // Validate the field while entering input

            document.querySelectorAll('.reg-donor-form .form-field__input').forEach(item => {
                item.oninput = function() {
                    let isValidDonorRegistration = validateDonorRegistrationForm();
                }
            });

            if (isValidDonorRegistration) {
                console.log(fd.get)
                $.ajax({
                    url: "./add_donor.php",
                    type: "POST",
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert(response);
                        if (response == "1") {
                            document.querySelector('.reg-donor-form').reset();
                            createPopupMsg("success", "Successfully register the account");
                        } else if (response == "0") {
                            showError(document.querySelector("#reg-donor-username"), "Username already exists");
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