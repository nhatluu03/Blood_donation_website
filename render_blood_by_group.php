<?php
include('./db/connect.php');
if (isset($_POST['blood_group_id'])) {
    $blood_group_id = $_POST['blood_group_id'];
    $donation_centre_id = $_POST['donation_centre_id'];
    $stmt = $conn->prepare("SELECT user.name, blood_group.name, donate.amount, user.phone, donation_calendar.date_time
                        FROM user, donor, donate, donation_calendar, blood_group
                        WHERE donate.donor_id = donor.user_id
                        AND donate.donation_calendar_id = donation_calendar.id
                        AND donor.blood_group_id = blood_group.id
                        AND donor.user_id = user.id
                        AND donate.is_verified = '1'
                        AND donation_calendar.donation_centre_id = ?
                        AND blood_group.id = ?");
    $stmt->bind_param("ss", $donation_centre_id, $blood_group_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($donor_name, $blood_group, $amount, $donor_phone, $created_at);
    if ($stmt->num_rows() > 0) {
        $count = 1;
        while ($stmt->fetch()) {
            $current_dt = date('m/d/Y h:i:s');
            $expire_dt = date('Y-m-d', strtotime($created_at . ' + 180 days'));

            if ($expire_dt < $current_dt) {
                $status = "Expired";
            } else {
                $status = "Available";
            }

            $blood_group = $blood_group ? $blood_group : "Null";
            $amount = $amount ? $amount : "Null";
            $donor_phone = $donor_phone ? $donor_phone : "Null";
            $donor_name = $donor_name ? $donor_name : "Null";

            echo ' <tr class="data_rows">
                        <td class="mobile-hide">' . $count++ . '</td>
                        <td>' . strtoupper($blood_group) . '</td>
                        <td>' . $amount . ' ml</td>
                        <td class="mobile-hide">' . $donor_phone . '</td>
                        <td class="mobile-hide">' . $donor_name . '</td>
                        <td class="mobile-hide">' . $created_at . '</td>
                        <td>' . $expire_dt . '</td>
                        <td>'.$status.'</td>
                    </tr>';
        }
    } else {
        echo '<tr class="data_rows"> 
                    <td> No records of blood group found </td>
                </tr>';
    }
}
