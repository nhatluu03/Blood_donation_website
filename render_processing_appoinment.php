<?php
include('./db/connect.php');
if (isset($_POST['donor_id'])) {
    $donor_id = $_POST['donor_id'];
    $current = date("Y-m-d H:i:s");
    $stmt = $conn->prepare("SELECT donation_calendar.id, hospital.name, hospital.address, donation_calendar.date_time, donate.amount, donation_calendar.capacity
                        FROM donate, donor, donation_calendar, hospital
                        WHERE donate.donor_id = donor.user_id
                        AND donate.donation_calendar_id = donation_calendar.id
                        AND donation_calendar.donation_centre_id = hospital.id
                        AND donor.user_id = ?
                        AND donation_calendar.date_time >= ?
                        AND donate.is_verified = '0'");
    $stmt->bind_param("ss", $donor_id, $current);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($donation_calendar_id, $donation_centre_name, $donation_centre_address, $donation_date_time, $donation_amount, $donation_capacity);

    if ($stmt->num_rows() > 0) {
        while ($stmt->fetch()) {
            echo '<div class="donation-appointment-content">
            <i class="fa-solid fa-xmark close-ic" id="'.$donation_calendar_id.'" onclick="openCancelAppointmentForm(this.id)"></i>
            <ul class="appointment-info-container">
                <h4>Appointment info</h4>
                <li class="appointment-info-item">
                    <span>Date - time: </span>
                    <span>' . date_format(date_create($donation_date_time), 'h:m - d.m.y') . '</span>
                </li>
                <li class="appointment-info-item">
                    <span>Donation centre:</span>
                    <span>' . $donation_centre_name . '</span>
                </li>
                <li class="appointment-info-item">
                    <span>Address:</span>
                    <span>' . $donation_centre_address . '</span>
                </li>   
                <li class="appointment-info-item">
                    <span>Amount registered: </span>
                    <span>' . $donation_amount . 'ml</span>
                </li>
                <li class="appointment-info-item">
                    <span>Capacity: </span>
                    <span>Donate with ' . ($donation_capacity - 1) . ' other donors.</span>
                </li>
            </ul>
            <ul class="appointment-note-container">
                <h4>Notes</h4>
                <li class="appointment-note-item">
                    - Remember to bring your ID when you go
                </li>
                <li class="appointment-note-item">
                    - Should eat light, DO NOT eat foods high in protein, high in fat.
                </li>
                <li class="appointment-note-item">
                    - DO NOT drink alcohol or beer.
                </li>
                <li class="appointment-note-item">
                    - Don\'t stay up too late the night before donating blood (sleep for at least 6 hours).
                </li>
            </ul>
            </div>';
        }
    } else {
        echo "<p class='sys-msg'> There is no donation appointment found.</p>";
    }
}
