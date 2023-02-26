<?php
include('./db/connect.php');
include('./php/format.php');
if (isset($_POST['donor_id'])) {
    $donor_id = $_POST['donor_id'];
    $stmt = $conn->prepare("SELECT blood_group.name, donate.amount, hospital.name, donate.created_at
                    FROM donor, donate, donation_calendar, donation_centre, hospital, blood_group
                    WHERE donate.donor_id = donor.user_id
                    AND donate.donation_calendar_id = donation_calendar.id
                    AND donation_calendar.donation_centre_id = donation_centre.hospital_id
                    AND donation_centre.hospital_id = hospital.id
                    AND donor.blood_group_id = blood_group.id
                    AND donate.is_verified = '1'
                    AND donate.donor_id = ?");
    $stmt->bind_param('s', $donor_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($blood_group, $amount, $donation_centre, $donated_at);
    if ($stmt->num_rows() > 0) {
        $count = 0;
        while ($row = $stmt->fetch()) {
            $count += 1;
            echo '<tr>
                <td class="phone-hide">' . $count . '</td>
                <td>' . strtoupper($blood_group) . '</td>
                <td>' . $amount . ' ml</td>
                <td>' . $donation_centre . '</td>
                <td>' . format_date_time($donated_at) . '</td>
            </tr>';
        }
    }
}
