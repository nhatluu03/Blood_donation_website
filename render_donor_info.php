<?php
include('./db/connect.php');
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $stmt = $conn->prepare("SELECT avatar, citizen_id, phone, email, address, blood_group.name, height, weight, birth_date, is_addicted_alcohol, is_positive_drug
                    FROM donor, user, blood_group
                    WHERE donor.user_id = user.id
                    AND donor.blood_group_id = blood_group.id
                    AND donor.user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($avatar, $citizen_id, $phone, $email, $address, $blood_group, $height, $weight, $birth_date, $is_addicted_alcohol, $is_positive_drug);
    if ($stmt->num_rows() > 0) {
        $stmt->fetch();
        $avatar = $avatar ? $avatar : "default_avatar.png";
        $citizen_id = $citizen_id  ? $citizen_id  : "Unset";
        $phone = $phone  ? $phone  : "Unset";
        $email = $email  ? $email  : "Unset";
        $address = $address  ? $address  : "Unset";
        $blood_group = $blood_group ? strtoupper($blood_group) : "Unset";
        $height = $height ? $height : "Unset";
        $weight = $weight ? $weight : "Unset";
        $birth_date = $birth_date ? $birth_date : "Unset";
        $is_addicted_alcohol = $is_addicted_alcohol ? ($is_addicted_alcohol == "1" ? "Yes" : "No") : "Unset";
        $is_positive_drug = $is_positive_drug ? ($is_positive_drug == "1" ? "Yes" : "No") : "Unset";

        echo '<div class="user-profile--left">
        <i class="fa-regular fa-pen-to-square edit-ic edit-donor-ic" onclick="openEditDonorForm()"></i>
        <img src="./db/uploads/users/'.$avatar.'" alt="" class="user-profile__avt">
        <h3 class="user-profile__name">Nguyen Van A</h3>
        <hr>
        <p class="user-profile__info">Citizen ID: ' . $citizen_id . '</p>
        <p class="user-profile__info">Phone: ' . $phone . '</p>
        <p class="user-profile__info">Email: ' . $email . '</p>
        <p class="user-profile__info">Address: ' . $address . '</p>
    </div>

    <form class="user-profile--right health-condition-form">
        <h4 class="form-name">Health condition</h4>
        <div class="health-condition-content">
            <div class="health-condition-content--left">
                <div class="form-field">
                    <label for="" class="form-field__label">Blood group: </label>
                    <input type="text" class="form-field__input" value="'.$blood_group.'" readonly>
                </div>
                <div class="form-field">
                    <label for="" class="form-field__label">Height: </label>
                    <input type="text" class="form-field__input" value="'.$height.'" readonly>
                </div>
                <div class="form-field">
                    <label for="" class="form-field__label">Weight: </label>
                    <input type="text" class="form-field__input" value="'.$weight.'" readonly>
                </div>
            </div>

            <div class="health-condition-content--right">
                <div class="form-field">
                    <label for="" class="form-field__label">Date of birth: </label>
                    <input type="text" class="form-field__input" value="'.$birth_date.'" readonly>
                </div>
                <div class="form-field">
                    <label for="" class="form-field__label">Alcohol addiction: </label>
                    <input type="text" class="form-field__input" value="'.$is_addicted_alcohol.'" readonly>
                </div>
                <div class="form-field">
                    <label for="" class="form-field__label">Drug addiction: </label>
                    <input type="text" class="form-field__input" value="'.$is_positive_drug.'" readonly>
                </div>
            </div>
        </div>
    </form>';
    } else {
        echo '0';
    }
}
