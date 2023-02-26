<?php
// 	id VARCHAR(50) NOT NULL,
// donation_centre_id VARCHAR(50) NOT NULL,
// date_time DATETIME NOT NULL,
// capacity INT NOT NULL,
// created_at DATETIME NOT NULL,

include('./db/connect.php');
include('./php/gen_uuid.php');

if (isset($_POST['donation_centre_id'])) {
    $id = gen_uuid();
    $donation_centre_id = $_POST['donation_centre_id'];
    $donation_datetime = date_format(date_create($_POST['donation_datetime']), 'Y-m-d H:i:s');
    $capacity = $_POST['donation_capacity'];
    $created_at = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO donation_calendar (`id`, `donation_centre_id`, `date_time`, `capacity`, `created_at`)
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $id, $donation_centre_id, $donation_datetime, $capacity, $created_at);
    $stmt->execute();
    echo "1";
}
?>