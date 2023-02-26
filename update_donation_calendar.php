<?php
    include('./db/connect.php');
    if (isset($_POST['edit_donation_calendar_id'])) {
        $edit_calendar_id = $_POST['edit_donation_calendar_id'];
        $edit_calendar_date_time = $_POST['edit_calendar_date_time'];
        $edit_calendar_capacity = $_POST['edit_calendar_capacity'];
        $stmt = $conn->prepare("UPDATE donation_calendar
        SET date_time = ?,
        capacity = ?
        WHERE id = ?");
        $stmt->bind_param("sss", $edit_calendar_date_time, $edit_calendar_capacity, $edit_calendar_id);
        $stmt->execute();
        echo "1";
    } else if (isset($_POST['delete_donation_calendar_id'])) {
        $edit_calendar_id = $_POST['delete_donation_calendar_id'];
        $stmt = $conn->prepare("DELETE FROM donation_calendar WHERE id = ?");
        $stmt->bind_param("s", $edit_calendar_id);
        $stmt->execute();
        echo "1";
    }


?>