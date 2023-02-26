<?php
session_start();
// print_r($_SESSION['user']);
if (!(isset($_SESSION['is_logged']) && $_SESSION['is_logged'] && $_SESSION['user']['role'] == "donor")) {
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
        <?php
        if (isset($_GET['change_pwd_id'])) {
            echo '<section>   
                    
                </section>';
        } else if (isset($_GET['change_avt_id'])) {
        }
        ?>
        <section class="user-profile">
            <!-- User profile will be rendered here -->
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

        <form action="" method="POST" class="edit-donor-form toggle-form hide">
            <h2 class="form-name">Edit profile</h2>
            <i class="fa-solid fa-xmark close-ic" onclick="closeEditDonorForm()"></i>
            <input type="hidden" name="donor_id" value="<?php echo $_SESSION['user']['id'] ?>">
            <input type="hidden" name="edit_donor_latitude" id="edit-donor-latitude" value="<?php echo isset($_SESSION['user']['latitude']) ? $_SESSION['user']['latitude'] : "" ?>">
            <input type="hidden" name="edit_donor_longitude" id="edit-donor-longitude" value="<?php echo isset($_SESSION['user']['longitude']) ? $_SESSION['user']['longitude'] : "" ?>">
            <div class="form-field">
                <label for="edit-donor-citizen-id" class="form-field__label">Citizen ID</label>
                <input type="text" name="edit_donor_citizen_id" id="edit-donor-citizen-id" class="form-field__input" placeholder="Enter citizen ID" value="<?php echo $_SESSION['user']['citizen_id'] ?>">
                <span class="form-field__message"></span>
            </div>
            <div class="form-field">
                <label for="edit-donor-avt" class="form-field__label">Avatar</label>
                <input type="file" name="edit_donor_avt" style="background-color: transparent" id="edit-donor-avt" class="form-field__input">
                <span class="form-field__message"></span>
            </div>
            <div class="form-field">
                <label for="edit-donor-email" class="form-field__label">Email</label>
                <input type="text" name="edit_donor_email" id="edit-donor-email" class="form-field__input" placeholder="Enter email address" value="<?php echo $_SESSION['user']['email'] ?>">
                <span class="form-field__message"></span>
            </div>
            <div class="form-field">
                <label for="edit-donor-phone" class="form-field__label">Phone</label>
                <input type="text" name="edit_donor_phone" id="edit-donor-phone" class="form-field__input" placeholder="Enter phone number" value="<?php echo $_SESSION['user']['phone'] ?>">
                <span class="form-field__message"></span>
            </div>
            <div class="form-field">
                <label for="edit-donor-address" class="form-field__label">Address</label>
                <input type="text" name="edit_donor_address" id="location-input" class="form-field__input" placeholder="Enter donor address" value="<?php echo $_SESSION['user']['address'] ? $_SESSION['user']['address'] : "" ?>">
                <span class="form-field__message"></span>
            </div>
            <!-- Add a div to hold the input field and autocomplete -->
            <div id="map"></div>
            <div class="form-field">
                <input type="submit" name="edit_donor_btn" id="edit-donor-btn" class="btn-hover color-4" value="Accept changes">
            </div>
        </form>
    </main>


    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWd9Wx6tr76oMUe4pWLQ8-FOJZfdkrNus&libraries=places,geometry&callback=initMap">
    </script>
    <script src="./assets/js/map.js"></script>
    <script src="./assets/js/toggleVerNavDb.js"></script>
    <script src="./assets/js/preventDefaultSubmission.js"></script>
    <script src="./assets/js/popupMsg.js"></script>
    <script src="./assets/js/validator.js"></script>
    <script src="./assets/js/toggleDisplayForm.js"></script>
    <?php  include('./change_password_script.php') ?>
    
    <!-- Toggle display form-->
    <script>
        var editDonorFormSelector = document.querySelector('.edit-donor-form');
        function openEditDonorForm() {  
            editDonorFormSelector.classList.remove('hide');
            document.querySelector('.overlay').classList.remove('hide');
        }

        function closeEditDonorForm() {
            editDonorFormSelector.classList.add('hide');
            document.querySelector('.overlay').classList.add('hide');
        }

        document.querySelectorAll('.page-header-container span').forEach(item => {
            item.addEventListener("click", function() {
                document.querySelectorAll('.page-header-container span').forEach(item1 => {
                    item1.classList.remove("active");
                })
                item.classList.add("active");
            })
        })

        // var editHospitalInfoFormSelector = document.querySelector(".edit-hospital-form");
        // var openEditHospitalInfoFormSelector = document.querySelector(".edit-hospital-ic");
        // var closeEditHospitalInfoFormSelector = editHospitalInfoFormSelector.querySelector(".close-ic");
        // toggleDisplayForm(editHospitalInfoFormSelector, openEditHospitalInfoFormSelector, closeEditHospitalInfoFormSelector)
    </script>
    <script>
        function renderDonorInfo() {
            let fd = new FormData();
            fd.append("user_id", "<?php echo $_SESSION['user']['id'] ?>");
            console.log(fd.get("user_id"))
            $.ajax({
                url: "./render_donor_info.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                success: function(response) {
                    // alert(response);
                    document.querySelector('.user-profile').innerHTML = response;
                },
                fail: function() {
                    alert("Something went wrong. Please try again!")
                },
                error: function() {
                    alert("Something went wrong. Please try again!")
                }
            })
        }
        renderDonorInfo();
    </script>
    <!-- Manipulation -->
    <script>
        function validateEditDonorForm() {
            let email = document.querySelector('#edit-donor-email');
            let phone = document.querySelector('#edit-donor-phone');
            let address = document.querySelector('#location-input');
            let latitude = document.querySelector('#edit-donor-latitude');
            let longitude = document.querySelector('#edit-donor-longitude');

            let emailVal = email.value.trim();
            let phoneVal = phone.value.trim();
            let addressVal = address.value.trim();
            let latitudeVal = latitude.value.trim();
            let longitudeVal = longitude.value.trim();


            let isValidEmail = isValidPhone = isValidAddress = false;

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

            if (addressVal) {
                if (!latitudeVal || !longitudeVal) {
                    isValidAddress = false;
                    showError(address, "Invalid address");
                } else {
                    isValidAddress = true;
                    showSuccess(address)
                }
            } else {
                isValidAddress = true;
                showSuccess(address)
            }

            return isValidEmail && isValidPhone && isValidAddress;
        }

        document.querySelector("#edit-donor-btn").onclick = function() {
            let editDonorForm = document.querySelector(".edit-donor-form");

            // Validation here
            let isValidEditDonor = validateEditDonorForm();

            // Validate the field while entering input
            editDonorForm.querySelectorAll('.form-field__input').forEach(item => {
                item.oninput = function() {
                    isValidEditDonor = validateEditDonorForm();
                }
            });

            if (isValidEditDonor) {
                let fd = new FormData(editDonorForm);
                $.ajax({
                    url: "./edit_donor_info.php",
                    type: "POST",
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        let avtSrc = response;
                        closeForm(editDonorForm);
                        createPopupMsg("success", "Successfully updated your information")
                        renderDonorInfo();
                        document.querySelector('.ver-nav-item__user-avt').src = `./db/uploads/users/${avtSrc}`;
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
</body>

</html>