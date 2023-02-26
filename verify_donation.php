<?php
include('./db/connect.php');
if (isset($_POST['donor_id']) && isset($_POST['donation_calendar_id'])) {
    $donor_id = $_POST['donor_id'];
    $donation_calendar_id = $_POST['donation_calendar_id'];
    $hospital_id = $_POST['donation_centre_id'];

    $verify_amount = $_POST['verify_donation_amount'];
    $verify_height = $_POST['verify_donation_height'];
    $verify_weight = $_POST['verify_donation_weight'];
    $verify_blood_group_id = $_POST['verify_donation_blood_group'];
    $verify_alcohol = $_POST['verify_donation_alcohol'];
    $verify_drug = $_POST['verify_donation_drug'];

    $stmt1 = $conn->prepare("UPDATE donor
                            SET height = ?,
                                weight = ?,
                                blood_group_id = ?,
                                is_addicted_alcohol = ?,
                                is_positive_drug = ?
                            WHERE user_id = ?");
    $stmt1->bind_param("ssssss", $verify_height, $verify_weight, $verify_blood_group_id, $verify_alcohol, $verify_drug, $donor_id);
    $stmt1->execute();
    $stmt1->store_result();

    // Update status and verify the amount of tbl donate
    $stmt2 = $conn->prepare("UPDATE donate
                SET is_verified = '1',
                    amount = ?
                WHERE donor_id = ?
                AND donation_calendar_id = ?");
    $stmt2->bind_param("sss", $verify_amount, $donor_id, $donation_calendar_id);
    $stmt2->execute();
    $stmt2->store_result();


    // Check if hospital already has a storage to store the blood group and total amount
    $stmt4 = $conn->prepare("SELECT * 
                        FROM store 
                        WHERE hospital_id = ? 
                        AND blood_group_id = ?");
    $stmt4->bind_param("ss", $hospital_id, $verify_blood_group_id);
    $stmt4->execute();
    $stmt4->store_result();

    // if existing --> update amount, otherwise, insert a new blood group storage for the specified hospital
    if ($stmt4->num_rows() < 1) {
        $stmt5 = $conn->prepare("INSERT INTO store(`blood_group_id`, `hospital_id`, `amount`)
                            VALUES (?, ?, ?)");
        $stmt5->bind_param("sss", $verify_blood_group_id, $hospital_id, $verify_amount);
        $stmt5->execute();
        $stmt5->store_result();
    }

    $stmt6 = $conn->prepare("UPDATE store
                        SET amount = amount + ?
                        WHERE hospital_id = ?
                        AND blood_group_id = ?");
    $stmt6->bind_param("sss", $verify_amount, $hospital_id, $verify_blood_group_id);
    $stmt6->execute();
    echo "1";
}
