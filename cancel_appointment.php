<?php
    include('./db/connect.php');
    if (isset($_POST['cancel_donation_calendar_id']) && $_POST['cancel_appointment_donor_id']) {
        $donation_calendar_id = $_POST['cancel_donation_calendar_id'];
        $donor_id = $_POST['cancel_appointment_donor_id'];
        $stmt = $conn->prepare("DELETE FROM donate
                            WHERE donation_calendar_id = ?
                            AND donor_id = ?");
        $stmt->bind_param("ss", $donation_calendar_id, $donor_id);
        $stmt->execute();
        echo '1';
    }
   
