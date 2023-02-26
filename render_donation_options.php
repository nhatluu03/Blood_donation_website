<?php
include('./db/connect.php');
include('./php/gen_uuid.php');
if (isset($_POST['donation_centre_id'])) {
    $donation_centre_id = $_POST['donation_centre_id'];
    $donor_id = $_POST['donor_id'];
    $current = date("Y-m-d H:i:s");
    $stmt1 = $conn->prepare("SELECT donation_calendar.id, donation_calendar.date_time, donation_calendar.capacity
                            FROM donation_calendar, donation_centre
                            WHERE donation_calendar.donation_centre_id = donation_centre.hospital_id
                            AND donation_centre.hospital_id = ?
                            AND donation_calendar.date_time >= ?
                            AND donation_calendar.id NOT IN (SELECT DISTINCT donation_calendar.id
                                                            FROM donation_calendar, donation_centre, donate
                                                            WHERE donation_calendar.donation_centre_id = donation_centre.hospital_id
                                                            AND donation_centre.hospital_id = ?
                                                            AND donate.donation_calendar_id = donation_calendar.id
                                                            AND donate.donor_id = ?)
                            GROUP BY donation_calendar.id");
    $stmt1->bind_param("ssss", $donation_centre_id, $current, $donation_centre_id, $donor_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($calendar_id, $date_time, $capacity);
    
    if ($stmt1->num_rows() > 0) {
        echo '<option value="selectcard">-- Please book donation calendar --</option>';
        while ($stmt1->fetch()) {
            echo '<option value="'.$calendar_id.'"> '.date_format(date_create($date_time), "h.m -- d.m.20y").'</option>';
        }
    } else {
        echo '<option value="selectcard">-- No donation options available --</option>';
    }
}
?>