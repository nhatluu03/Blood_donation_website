<a href="./campaign.php" class="func-btn"> <i class="fa-solid fa-arrow-left"></i> Back</a>
<section class="info_section__details" id="blood_info__details">
    <table class="details_table" id="blood_table">
        <thead class="details_table__head">
            <tr>
                <th>Order</th>
                <th>Full name</th>
                <th>Blood group</th>
                <th>Amount</th>
                <th>Phone</th>
                <th>Height x Weight</th>
                <th>Alcohol addiction</th>
                <th>Drug addiction</th>
                <th>Verification</th>
            </tr>
        </thead>
        <tbody class="details_table__body donation-book-list">
        </tbody>
    </table>
</section>

<form action="" class="verify-donation-form toggle-form hide">
    <i class="fa-solid fa-xmark close-ic" onclick="hideVerifyDonationForm()"></i>
    <h2 class="form-name">Verify donation</h2>
    <div class="form-field">
        <label for="verify-donation-donor-name" class="form-field__label">Name</label>
        <input type="text" style="background-color: transparent;" id="verify-donation-donor-name" class="form-field__input" readonly value="">
        <span class="form-field__message"></span>
    </div>
    <div class="form-field">
        <label for="verify-donation-blood-group" class="form-field__label">Blood group</label>
        <select name="verify_donation_blood_group" id="verify-donation-blood-group" class="form-field__input">
            <option value="selectcard">-- Please choose blood group --</option>
            <?php
            include('./db/connect.php');
            $query = "SELECT id, name FROM blood_group";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    echo '<option value="' . $row['id'] . '"> ' . strtoupper($row['name']) . ' </option>';
                }
            }
            ?>
        </select>
        <span class="form-field__message"></span>
    </div>
    <div class="form-field">
        <label for="verify-donation-amount" class="form-field__label">Amount</label>
        <input type="number" name="verify_donation_amount" id="verify-donation-amount" class="form-field__input" placeholder="Enter amount (ml)">
        <span class="form-field__message"></span>
    </div>
    <div class="form-field">
        <label for="verify-donation-height" class="form-field__label">Height</label>
        <input type="number" name="verify_donation_height" id="verify-donation-height" class="form-field__input" placeholder="Enter height (cm)">
        <span class="form-field__message"></span>
    </div>
    <div class="form-field">
        <label for="verify-donation-weight" class="form-field__label">Weight</label>
        <input type="number" name="verify_donation_weight" id="verify-donation-weight" class="form-field__input" placeholder="Enter weight (kg)">
        <span class="form-field__message"></span>
    </div>
    <div class="form-field">
        <label for="verify-donation-alcohol" class="form-field__label">Alcohol addiction</label>
        <span class="sys-msg">Yes</span>
        <input type="radio" name="verify_donation_alcohol" id="verify-donation-alcohol-yes" value="1">
        <span class="sys-msg">No</span>
        <input type="radio" name="verify_donation_alcohol" id="verify-donation-alcohol-no" value="0" selected>
        <span class="form-field__message"></span>
    </div>
    <div class="form-field">
        <label for="verify_donation_drug" class="form-field__label">Drug addiction</label>
        <span class="sys-msg">Yes</span>
        <input type="radio" name="verify_donation_drug" id="verify-donation-drug-yes" value="1">
        <span class="sys-msg">No</span>
        <input type="radio" name="verify_donation_drug" id="verify-donation-drug-no" value="0" selected>
        <span class="form-field__message"></span>
    </div>
    <div class="form-field">
        <input type="submit" name="verify_donation_btn" id="verify-donation-btn" value="Verify">
    </div>
</form>

<script>
    function renderDonationList() {
        let fd = new FormData();
        fd.append("view_calendar_id", "<?php echo isset($_GET['view_calendar_id']) ? $_GET['view_calendar_id'] : "1" ?>")
        $.ajax({
            url: "./render_donation_list.php",
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            success: function(response) {
                document.querySelector('.donation-book-list').innerHTML = response;
            },
            fail: function() {
                createPopupMsg("fail", "Something went wrong. Please try again!");
            },
            error: function() {
                createPopupMsg("fail", "Something went wrong. Please try again!");
            }
        })
    }
    renderDonationList();
</script>

<script src="./assets/js/validator.js"></script>
<script>
    var verifyDonationForm = document.querySelector('.verify-donation-form');

    function hideVerifyDonationForm() {
        document.querySelector('.verify-donation-form').classList.add('hide');
        document.querySelector('.overlay').classList.add('hide');
    }

    function validateVerifyDonationForm() {
        let bloodGroup = document.querySelector('#verify-donation-blood-group');
        let amount = document.querySelector('#verify-donation-amount');
        let height = document.querySelector('#verify-donation-height');
        let weight = document.querySelector('#verify-donation-weight');
        let isAlcoholAddiction = document.querySelector('#verify-donation-alcohol-no');
        let isDrugPositive = document.querySelector('#verify-donation-drug-no');

        let amountVal = amount.value.trim();
        let heightVal = height.value.trim();
        let weightVal = weight.value.trim();


        let isValidBloodGroup = isValidAmount = isValidHeight = isValidWeight = isValidAlcoholAddiction = isValidDrugPositive = false;

        // bloodGroup validation
        isValidBloodGroup = checkSelect(bloodGroup);

        // Amount validation
        if (!amountVal) {
            showError(amount, "Please enter the donation amount");
        } else if (amountVal < 0) {
            showError(amount, "Donation amount cannot be negative");
        } else {
            isValidAmount = true;
            showSuccess(amount)
        }

        // Height validation
        if (!heightVal) {
            showError(height, "Please enter height of donor");
        } else if (heightVal < 0) {
            showError(height, "Height (cm) cannot be negative");
        } else {
            isValidHeight = true;
            showSuccess(height)
        }

        // Weight validation
        if (!weightVal) {
            showError(weight, "Please enter weight of donor");
        } else if (weightVal < 0) {
            showError(weight, "weight (cm) cannot be negative");
        } else {
            isValidWeight = true;
            showSuccess(weight)
        }

        // Alcohol addiction validation
        if (!isAlcoholAddiction.checked) {
            showError(isAlcoholAddiction, "Donor must be negative with alcohol addition")
        } else {
            isValidAlcoholAddiction = true;
            showSuccess(isAlcoholAddiction)
        }

        // Drug addiction validation
        if (!isDrugPositive.checked) {
            showError(isDrugPositive, "Donor must be negative with alcohol addition")
        } else {
            isValidDrugPositive = true;
            showSuccess(isDrugPositive)
        }
        console.log(isValidBloodGroup)
        console.log(isValidAmount)
        console.log(isValidHeight)
        console.log(isValidWeight)
        console.log(isValidAlcoholAddiction)
        console.log(isValidDrugPositive)


        return isValidBloodGroup && isValidAmount && isValidHeight && isValidWeight && isValidAlcoholAddiction && isValidDrugPositive
    }

    function verifyDonation(donorId, donorName, bloodGroupId, donationAmount, donorHeight, donorWeight, isAddictedAlcohol, isPositiveDrug) {
        openForm(verifyDonationForm)
        verifyDonationForm.querySelector('#verify-donation-donor-name').value = donorName;
        verifyDonationForm.querySelector('#verify-donation-amount').value = parseFloat(donationAmount);
        verifyDonationForm.querySelector('#verify-donation-height').value = parseFloat(donorHeight);
        verifyDonationForm.querySelector('#verify-donation-weight').value = parseFloat(donorWeight);
        if (isAddictedAlcohol == "1") {
            verifyDonationForm.querySelector('#verify-donation-alcohol-yes').checked = true;
        } else {
            verifyDonationForm.querySelector('#verify-donation-alcohol-no').checked = true;
        }

        if (isPositiveDrug == "1") {
            verifyDonationForm.querySelector('#verify-donation-drug-yes').checked = true;
        } else {
            verifyDonationForm.querySelector('#verify-donation-drug-no').checked = true;
        }

        document.querySelectorAll('#verify-donation-blood-group option').forEach(item => {
            if (item.value == bloodGroupId) {
                item.selected = true;
            }
        })

        document.querySelector('#verify-donation-btn').onclick = function() {
            let fd = new FormData(verifyDonationForm);
            fd.append("donor_id", donorId);
            fd.append("donation_calendar_id", "<?php echo $_GET['view_calendar_id'] ?>");
            fd.append("donation_centre_id", "<?php echo $_SESSION['user']['hospital_id'] ?>");
            let isValidVerifyDonation = validateVerifyDonationForm();

            document.querySelectorAll('.verify-donation-form .form-field__input').forEach(item => {
                item.oninput = function() {
                    isValidVerifyDonation = validateVerifyDonationForm();
                    console.log(isValidVerifyDonation)
                }
            })

            // console.log(fd.get("donor_id"))
            // console.log(fd.get("donation_calendar_id"))
            // console.log(fd.get("donation_centre_id"))
            // console.log(fd.get("verify_donation_blood_group"))
            // console.log(fd.get("verify_donation_amount"))
            // console.log(fd.get("verify_donation_height"))
            // console.log(fd.get("verify_donation_weight"))
            // console.log(fd.get("verify_donation_alcohol"))
            // console.log(fd.get("verify_donation_drug"))
            if (isValidVerifyDonation) {
                $.ajax({
                    url: "./verify_donation.php",
                    type: "POST",
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert(response);
                        hideVerifyDonationForm();
                        if (response == 1) {
                            createPopupMsg("success", "Successfully verified the donation")
                            renderDonationList();
                        } else {
                            createPopupMsg("fail", "Something went wrong. Please try again!")
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
        }
    }
</script>
<script>
    document.querySelector(".donation-campaign").style.display = "none"
</script>