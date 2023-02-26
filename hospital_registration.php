<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<form method="post" class="form reg-hospital-form">
    <h2 class="form-name">Registration form</h2>
    <div class="form-field">
        <input type="text" name="reg_hospital_name" id="reg-hospital-name" class="form-field__input" placeholder="Enter hospital name">
        <br>
        <span class="form_field__message"></span>
    </div>
    <div class="form-field">
        <input type="text" name="reg_hospital_address" id="reg-hospital-address" class="form-field__input" placeholder="Enter hospital address">
        <br>
        <span class="form_field__message"></span>
    </div>
    <div class="form-field">
        <input type="submit" name="reg_hospital_submit" id="reg-hospital-submit" class="form-field__input" value="Register">
    </div>
</form>
<script src="./assets/js/preventDefaultSubmission.js"></script>
<script src="./assets/js/popupMsg.js"></script>
<script src="./assets/js/validator.js"></script>
<script>
    document.querySelector("#reg-hospital-submit").addEventListener("click", function() {
        let regForm = document.querySelector('.reg-hospital-form');
        let fd = new FormData(regForm);

        // Validation here

        $.ajax({
            url: "./add_hospital.php",
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response);
                if (response == "1") {
                    document.querySelector('.reg-hospital-form').reset();
                    createPopupMsg("success", "Successfully register the hospital");
                } else if (response == "0") {
                    showError(document.querySelector("#reg-hospital-name"), "Hospital name already exists");
                }
            },
            fail: function() {
                createPopupMsg("fail", "Something went wrong. Please try again!");
            },
            error: function() {
                createPopupMsg("fail", "Something went wrong. Please try again!");
            }
        })
    })
</script>