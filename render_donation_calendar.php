<?php
include('./db/connect.php');
include('./php/format.php');
if (isset($_POST['donation_centre_id'])) {
    $donation_centre_id = $_POST['donation_centre_id'];
    $stmt = $conn->prepare("SELECT tbl1.id, tbl1.date_time, tbl1.capacity, COUNT(donate.donor_id)
                    FROM (SELECT * FROM donation_calendar WHERE donation_calendar.donation_centre_id = ?) as tbl1
                    LEFT JOIN donate ON tbl1.id = donate.donation_calendar_id
                    GROUP BY tbl1.id");
    $stmt->bind_param("s", $donation_centre_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $date_time, $capacity, $quantity);
    if ($stmt->num_rows() > 0) {
        $count = 1;
        while ($stmt->fetch()) {
            echo '<tr class="data_rows">
                    <td class="mobile-hide">' . $count++ . '</td>
                    <td class="mobile-hide">' . format_date_time($date_time) . '</td>
                    <td class="pc-hide tablet-hide">' . date_format(date_create($date_time), "d.m.20y") . '</td>
                    <td>' . $quantity . ' / ' . $capacity . '</td>
                    <td> 
                        <a href="./campaign.php?view_calendar_id='.$id.'">  View  </a> 
                        | 
                        <a href="./campaign.php?edit_calendar_id='.$id.'">  Edit </a> 
                        | 
                        <a href="./campaign.php?delete_calendar_id='.$id.'"> Delete </i> </a> 
                    </td>
                </tr>';
        }
    }
}
