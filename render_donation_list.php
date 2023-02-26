<?php
include('./db/connect.php');
if (isset($_POST['view_calendar_id'])) {
    $donation_calendar_id = $_POST['view_calendar_id'];
    $stmt = $conn->prepare("SELECT donor.user_id, donation_calendar.id, user.name, blood_group.id, blood_group.name, donate.amount, user.phone, donor.height, donor.weight, donor.is_addicted_alcohol, donor.is_positive_drug, donate.is_verified
                            FROM donate, donation_calendar, donor, user, blood_group
                            WHERE donate.donor_id = donor.user_id
                            AND donate.donation_calendar_id = donation_calendar.id
                            AND donor.user_id = user.id
                            AND donor.blood_group_id = blood_group.id
                            AND donate.donation_calendar_id = ?");
    $stmt->bind_param("s", $donation_calendar_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($donor_id, $donation_calendar_id, $donor_full_name, $blood_group_id, $donor_blood_group, $donation_amount, $user_phone, $donor_height, $donor_weight, $is_donor_addicted_alcohol, $is_donor_positive_drug, $is_donation_verified);

    if ($stmt->num_rows() > 0) {
        $count = 1;
        while ($stmt->fetch()) {
            $donor_full_name = $donor_full_name ? $donor_full_name : "Null";
            $donor_blood_group = $donor_blood_group ? $donor_blood_group : "Null";
            $donation_amount = $donation_amount ? $donation_amount . " ml" : "Null";
            $user_phone = $user_phone ? $user_phone : "Null";
            $donor_height = $donor_height ? $donor_height : "Null";
            $donor_weight = $donor_weight ? $donor_weight : "Null";
            if ($is_donor_addicted_alcohol == "0") {
                $is_donor_addicted_alcohol = "No";
            } else if ($is_donor_addicted_alcohol) {
                $is_donor_addicted_alcohol = "Yes";
            } else {
                $is_donor_addicted_alcohol = "Unset";
            }

            if ($is_donor_positive_drug == "0") {
                $is_donor_positive_drug = "No";
            } else if ($is_donor_positive_drug) {
                $is_donor_positive_drug = "Yes";
            } else {
                $is_donor_positive_drug = "Unset";
            }

            echo '<tr class="data_rows">
                    <td>' . $count . '</td>
                    <td  class="">' . $donor_full_name . '</td>
                    <td>' . strtoupper($donor_blood_group) . '</td>
                    <td>' . $donation_amount . '</td>
                    <td>' . $user_phone . '</td>
                    <td>' . $donor_height . ' x ' . $donor_weight . '</td>
                    <td>' . $is_donor_addicted_alcohol . '</td>
                    <td>' . $is_donor_positive_drug . '</td>
                    <td>';
            if ($is_donation_verified == "0") {
                echo '<button id="' . $donor_id . '"  class="verify-donation-btn" onclick="verifyDonation(
                    \''.$donor_id.'\', \''.$donor_full_name.'\', \''.$blood_group_id.'\', \''.$donation_amount.'\', \''.$donor_height.'\', \''.$donor_weight.'\', \''.$is_donor_addicted_alcohol.'\', \''.$is_donor_positive_drug.'\')"> 
                        Verify 
                    </button>';
            } else {
                echo 'Verified';
            }
            echo '</td>
                </tr>';
            $count++;
        }
    }
}

?>