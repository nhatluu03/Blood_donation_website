<script>
    let changePasswordForm = document.querySelector('.change-password-form');
    let openChangePasswordFormBtn = document.querySelector('.open-change-password-form-btn');
    let closeChangePasswordFormBtn = changePasswordForm.querySelector('.close-ic');
    toggleDisplayForm(changePasswordForm, openChangePasswordFormBtn, closeChangePasswordFormBtn)

    function validateChangePasswordForm() {
        let oldPassword = document.querySelector("#old-password");
        let newPassword = document.querySelector("#new-password");
        let confirmNewPassword = document.querySelector("#confirm-new-password");

        let oldPasswordVal = oldPassword.value.trim();
        let newPasswordVal = newPassword.value.trim();
        let confirmNewPasswordVal = confirmNewPassword.value.trim();

        let idValidOldPassword = isValidNewPassword = isValidConfirmNewPassword = false;

        // Old password validation
        if (!oldPasswordVal) {
            showError(oldPassword, "Please enter old password")
        } else {
            idValidOldPassword = true;
            showSuccess(oldPassword);
        }

        // New password validation
        if (!newPasswordVal) {
            showError(newPassword, "Please enter new password")
        } else {
            // New password validation
            if (!confirmNewPasswordVal) {
                showError(confirmNewPassword, "Please enter new password")
            } else if (confirmNewPasswordVal != newPasswordVal) {
                showError(confirmNewPassword, "Confirmed password not match")
            } else {
                if (oldPasswordVal == newPasswordVal) {
                    showError(newPassword, "No changes found")
                    showError(confirmNewPassword, "No changes found")
                } else {
                    showSuccess(newPassword);
                    showSuccess(confirmNewPassword);
                    isValidNewPassword = true;
                    isValidConfirmNewPassword = true;
                }
            }
        }

        return idValidOldPassword && isValidNewPassword && isValidConfirmNewPassword;
    }

    function changePassword() {
        document.querySelector('#change-password-btn').onclick = function() {
            let oldPasswordSelector = document.querySelector('#old-password');
            let changePasswordForm = document.querySelector('.change-password-form')
            let fd = new FormData(changePasswordForm);
            fd.append("user_id", "<?php echo $_SESSION['user']['id'] ?>");

            let isValidChangePassword = validateChangePasswordForm();
            changePasswordForm.querySelectorAll('.form-field__input').forEach(item => {
                item.oninput = function() {
                    isValidChangePassword = validateChangePasswordForm();
                }
            })

            if (isValidChangePassword) {
                $.ajax({
                    url: "./change_password.php",
                    type: "POST",
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        showSuccess(oldPasswordSelector)
                        if (response == "1") {
                            closeForm(changePasswordForm)
                            createPopupMsg("success", "Successfully changed the password");
                        } else if (response == "0") {
                            showError(oldPasswordSelector, "Wrong password")
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
    }

    changePassword();
</script>