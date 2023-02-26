<?php
session_start();
include('./db/connect.php');
if (isset($_POST['donor_id'])) {
    $donor_id = $_POST['donor_id'];
    $citizen_id = $_POST['edit_donor_citizen_id'];
    $email = $_POST['edit_donor_email'];
    $phone = $_POST['edit_donor_phone'];
    $latitude = $_POST['edit_donor_latitude'];
    $longitude = $_POST['edit_donor_longitude'];
    $address = $_POST['edit_donor_address'];
    $avt = $_FILES['edit_donor_avt']['name'];

    if ($avt) {
        $target_dir = "./db/uploads/users/";
        $target_file = $target_dir . $avt;
        $is_file_uploaded = move_uploaded_file($_FILES["edit_donor_avt"]["tmp_name"], $target_file);
        $stmt = $conn->prepare("UPDATE donor, user
                            SET citizen_id = ?,
                                email = ?,
                                phone = ?,
                                latitude =?,
                                longitude = ?,
                                address = ?,
                                avatar = ?
                            WHERE donor.user_id = user.id
                            AND user.id = ?");
        $stmt->bind_param("ssssssss", $citizen_id, $email, $phone, $latitude, $longitude, $address, $avt, $donor_id);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("UPDATE donor, user
                            SET citizen_id = ?,
                                email = ?,
                                phone = ?,
                                latitude =?,
                                longitude = ?,
                                address = ?
                            WHERE donor.user_id = user.id
                            AND user.id = ?");
        $stmt->bind_param("sssssss", $citizen_id, $email, $phone, $latitude, $longitude, $address, $donor_id);
        $stmt->execute();
        $avt = "default_avatar.png";
    }
    $_SESSION['user']['citizen_id'] = $citizen_id;
    $_SESSION['user']['email'] = $email;
    $_SESSION['user']['phone'] = $phone;
    $_SESSION['user']['latitude'] = $latitude;
    $_SESSION['user']['longitude'] = $longitude;
    $_SESSION['user']['address'] = $address;
    $_SESSION['user']['avatar'] = $avt;
    echo $avt;
}
?>
