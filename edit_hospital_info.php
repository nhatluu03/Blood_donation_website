<?php
// getLatLng latitude and longitude
include('./db/connect.php');
if (isset($_POST['edit_hospital_id'])) {
    $hospital_id = $_POST['edit_hospital_id'];
    $name = $_POST['edit_hospital_name'];
    $address = $_POST['edit_hospital_address'];
    $hotline = $_POST['edit_hospital_hotline'];
    $email = $_POST['edit_hospital_email'];
    $latitude = $_POST['edit_hospital_latitude'];
    $longitude = $_POST['edit_hospital_longitude'];
    $stmt = $conn->prepare("UPDATE hospital
                    SET name = ?,
                    address = ?,
                    hotline = ?,
                    email = ?,
                    latitude = ?,
                    longitude = ?
                    WHERE id = ?");
    $stmt->bind_param("sssssss", $name, $address, $hotline, $email, $latitude, $longitude, $hospital_id);
    $stmt->execute();
    echo "1";
}
?>