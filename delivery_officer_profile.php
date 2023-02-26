<?php
session_start();
// print_r($_SESSION['user']);
if (!(isset($_SESSION['is_logged']) && $_SESSION['is_logged'] && $_SESSION['user']['role'] == "delivery_officer")) {
    header('Location: ./index.php');
}
include('./db/connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="shortcut icon" href="./assets/img/logo.png">

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
    <link rel="stylesheet" href="./assets/css/profile.css">
    <link rel="stylesheet" href="./assets/css/form.css">
    <!-- css for header and footer -->
    <link rel="stylesheet" href="./assets/css/headernfooter.css">
</head>

<body>
    <!-- Header section -->
    <?php include('./header.php') ?>

    <!-- Main section -->
    <main class="main">
        <div class="page-header-container">
            <span href="./donor_profile.php" class="page-header-item active">Profile</span>
            <span class="page-header-item open-change-password-form-btn">Change password</span>
        </div>
        <section class="user-profile">
            <div class="user-profile--left">
                <i class="fa-regular fa-pen-to-square edit-ic"></i>
            </div>

            <form class="user-profile--right health-condition-form">
                <h4 class="form-name">Resume</h4>
                <div class="health-condition-content">
                    <div class="health-condition-content--left">
                        <div class="form-field">
                            <label for="" class="form-field__label">Position: </label>
                            <input type="text" name="" id="" class="form-field__input" value="Delivery officer" readonly>
                        </div>
                        <div class="form-field">
                            <label for="" class="form-field__label">Working since: </label>
                            <input type="text" name="" id="" class="form-field__input" value="<?php echo $_SESSION['user']['created_at'] ? date_format(date_create($_SESSION['user']['created_at']), "d.m.20y") : "Unset" ?>" readonly>
                        </div>
                        <div class="form-field">
                            <label for="" class="form-field__label">Salary: </label>
                            <input type="text" name="" id="" class="form-field__input" value="1.000$" readonly>
                        </div>
                    </div>

                    <!-- <div class="health-condition-content--right">
                        <div class="form-field">
                            <label for="" class="form-field__label">Date of birth: </label>
                            <input type="text" name="" id="" class="form-field__input" value="<?php echo $_SESSION['user']['birth_date'] ? $_SESSION['user']['birth_date'] : "Unset" ?>" readonly>
                        </div>
                        <div class="form-field">
                            <label for="" class="form-field__label">Alcohol addiction: </label>
                            <input type="text" name="" id="" class="form-field__input" value="<?php echo $_SESSION['user']['is_addicted_alcohol'] ? $_SESSION['user']['is_addicted_alcohol'] : "Unset" ?>" readonly>
                        </div>
                        <div class="form-field">
                            <label for="" class="form-field__label">Drug addiction: </label>
                            <input type="text" name="" id="" class="form-field__input" value="<?php echo $_SESSION['user']['is_positive_drug'] ? $_SESSION['user']['is_positive_drug'] : "Unset" ?>" readonly>
                        </div>
                    </div> -->
                </div>
            </form>
        </section>

        <div class="overlay hide"></div>

        <form action="" class="change-password-form toggle-form hide">
            <i class="fa-solid fa-xmark close-ic"></i>
            <h4 class="form-name">Change password</h4>
            <div class="form-field">
                <label for="old-password" class="form-field__label">Old password</label>
                <input type="text" name="old_password" id="old-password" class="form-field__input" placeholder="Enter old password">
                <span class="form-field__message"></span>
            </div>
            <div class="form-field">
                <label for="new-password" class="form-field__label">New password</label>
                <input type="text" name="new_password" id="new-password" class="form-field__input" placeholder="Enter new password">
                <span class="form-field__message"></span>
            </div>
            <div class="form-field">
                <label for="confirm-new-password" class="form-field__label">Confirm password</label>
                <input type="text" name="confirm_new_password" id="confirm-new-password" class="form-field__input" placeholder="Confirm new password">
                <span class="form-field__message"></span>
            </div>
            <div class="form-field">
                <input type="submit" name="change_password_btn" id="change-password-btn" class="func-btn" value="Change">
            </div>
        </form>

        <form action="" method="POST" class="edit-delivery-officer-form toggle-form hide">
            <h2 class="form-name">Edit profile</h2>
            <i class="fa-solid fa-xmark close-ic" onclick="closeEditDeliveryOfficerForm()"></i>
            <input type="hidden" name="delivery_officer_id" value="<?php echo $_SESSION['user']['id'] ?>">
            <input type="hidden" name="edit_delivery_officer_latitude" id="edit-delivery-officer-longitude" value="<?php echo isset($_SESSION['user']['latitude']) ? $_SESSION['user']['latitude'] : "" ?>">
            <input type="hidden" name="edit_delivery_officer_longitude" id="edit-delivery-officer-latitude" value="<?php echo isset($_SESSION['user']['longitude']) ? $_SESSION['user']['longitude'] : "" ?>">
            <div class="form-field">
                <label for="edit-delivery-officer-email" class="form-field__label">Email</label>
                <input type="text" name="edit_delivery_officer_email" id="edit-delivery-officer-email" class="form-field__input" placeholder="Enter email address" value="<?php echo $_SESSION['user']['email'] ?>">
                <span class="form-field__message"></span>
            </div>
            <div class="form-field">
                <label for="edit-delivery-officer-phone" class="form-field__label">Phone</label>
                <input type="text" name="edit_delivery_officer_phone" id="edit-delivery-officer-phone" class="form-field__input" placeholder="Enter phone number" value="<?php echo $_SESSION['user']['phone'] ?>">
                <span class="form-field__message"></span>
            </div>
            <div class="form-field">
                <label for="edit-delivery-officer-avt" class="form-field__label">Avatar</label>
                <input type="file" name="edit_delivery_officer_avt" style="background-color: transparent" id="edit-delivery-officer-avt" class="form-field__input" placeholder="Enter email address" value="<?php echo $_SESSION['user']['email'] ?>">
                <span class="form-field__message"></span>
            </div>
            <div class="form-field">
                <input type="submit" name="edit_delivery_officer_btn" id="edit-delivery-officer-btn" class="btn-hover color-4" value="Accept changes">
            </div>
        </form>
    </main>



    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5gsTNEfqLgbnuVhYVzoybUoBpVMUN63I&libraries=places,geometry&callback=initMap">
    </script>
    <script src="./assets/js/map.js"></script>
    <script src="./assets/js/toggleVerNavDb.js"></script>
    <script src="./assets/js/preventDefaultSubmission.js"></script>
    <script src="./assets/js/popupMsg.js"></script>
    <script src="./assets/js/validator.js"></script>
    <script src="./assets/js/toggleDisplayForm.js"></script>
    <?php include('./change_password_script.php') ?>
    <!-- Toggle display form-->
    <!-- Toggle display form-->
    <script>
        var editDeliveryOfficerFormSelector = document.querySelector('.edit-delivery-officer-form');

        function openEditDeliveryOfficerForm() {
            editDeliveryOfficerFormSelector.classList.remove('hide');
            document.querySelector('.overlay').classList.remove('hide');
        }

        function closeEditDeliveryOfficerForm() {
            editDeliveryOfficerFormSelector.classList.add('hide');
            document.querySelector('.overlay').classList.add('hide');
        }
    </script>

    <!-- Manipulation -->
    <script>
        function validateEditDeliveryOfficerForm() {
            let email = document.querySelector('#edit-delivery-officer-email');
            let phone = document.querySelector('#edit-delivery-officer-phone');
            let emailVal = email.value.trim();
            let phoneVal = phone.value.trim();

            let isValidEmail = isValidPhone = false;

            // Email address Validation
            if (emailVal) {
                if (!checkEmail(emailVal)) {
                    showError(email, "Invalid email address");
                } else {
                    isValidEmail = true;
                    showSuccess(email)
                }
            } else {
                isValidEmail = true;
                showSuccess(email)
            }

            // Phone number Validation
            if (phoneVal) {
                if (phoneVal.length != 10 || !checkOnlyDigits(phoneVal)) {
                    showError(phone, "Invalid phone number");
                } else {
                    isValidPhone = true;
                    showSuccess(phone)
                }
            } else {
                isValidPhone = true;
                showSuccess(phone)
            }

            console.log(isValidEmail)
            console.log(isValidPhone)

            if (!isValidEmail || !isValidPhone) {
                return false;
            }
            return true;
        }

        document.querySelector("#edit-delivery-officer-btn").onclick = function() {
            let editDeliveryOfficerForm = document.querySelector(".edit-delivery-officer-form");
            let fd = new FormData(editDeliveryOfficerForm);

            // Validation here
            let isValidEditDeliveryOfficer = validateEditDeliveryOfficerForm();

            // Validate the field while entering input
            editDeliveryOfficerForm.querySelectorAll('.form-field__input').forEach(item => {
                item.oninput = function() {
                    isValidEditDeliveryOfficer = validateEditDeliveryOfficerForm();
                }
            });

            if (isValidEditDeliveryOfficer) {
                $.ajax({
                    url: "./edit_delivery_officer_info.php",
                    type: "POST",
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response == "1") {
                            closeForm(editDeliveryOfficerForm);
                            createPopupMsg("success", "Successfully updated your information")
                            renderDeliveryOfficerInfo();
                        } else {
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
    <script>
        function renderDeliveryOfficerInfo() {
            let fd = new FormData();
            fd.append("user_id", "<?php echo $_SESSION['user']['id'] ?>");
            console.log(fd.get("user_id"))
            $.ajax({
                url: "./render_delivery_officer_info.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                success: function(response) {
                    // alert(response);
                    document.querySelector('.user-profile--left').innerHTML = response;
                },
                fail: function() {
                    alert("Something went wrong. Please try again!")
                },
                error: function() {
                    alert("Something went wrong. Please try again!")
                }
            })
        }
        renderDeliveryOfficerInfo();
    </script>
</body>

</html>