<?php
    include('./db/connect.php');
    include('./php/format.php');
    if (isset($_POST["calendar_start_date"]) && isset($_POST["calendar_end_date"])) {
        $start_date = $_POST["calendar_start_date"];
        $end_date = $_POST["calendar_end_date"];
        $donation_centre_id = $_POST["donation_centre_id"];

        $stmt = $conn->prepare("SELECT tbl1.id, tbl1.date_time, tbl1.capacity, COUNT(donate.donor_id)
                            FROM (SELECT * FROM donation_calendar WHERE donation_calendar.donation_centre_id = ?
                            	AND donation_calendar.date_time BETWEEN ? AND ?) as tbl1
                            LEFT JOIN donate ON tbl1.id = donate.donation_calendar_id
                            GROUP BY tbl1.id");
        $stmt->bind_param("sss", $donation_centre_id, $start_date, $end_date);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $date_time, $capacity, $quantity);

        if ($stmt->num_rows() > 0) {
            $count = 0;
            while ($stmt->fetch()) {
                echo '<tr class="data_rows">
                        <td>' . $count ++. '</td>
                        <td>' . format_date_time($date_time) . '</td>
                        <td>' . $quantity . ' / ' . $capacity . '</td>
                        <td> 
                            <a href="./donation_calendar.php?view_calendar_id='.$id.'">  View  </a> 
                            | 
                            <a href="./donation_calendar.php?edit_hospital_id='.$id.'">  Edit </a> 
                            | 
                            <a href="./donation_calendar.php?delete_hospital_id='.$id.'"> Delete </i> </a> 
                        </td>
                    </tr>';
            }
        }
    }
