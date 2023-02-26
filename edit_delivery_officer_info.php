<?php
session_start();
include('./db/connect.php');
if (isset($_POST['delivery_officer_id'])) {
    $delivery_officer_id = $_POST['delivery_officer_id'];
    $email = $_POST['edit_delivery_officer_email'];
    $phone = $_POST['edit_delivery_officer_phone'];
    $avt = $_FILES['edit_delivery_officer_avt']['name'];

    if ($avt) {
        $target_dir = "./db/uploads/users/";
        $target_file = $target_dir . $avt;
        $is_file_uploaded = move_uploaded_file($_FILES["edit_delivery_officer_avt"]["tmp_name"], $target_file);
        $stmt = $conn->prepare("UPDATE delivery_officer, user
                            SET email = ?,
                                phone = ?,
                                avatar = ?
                            WHERE delivery_officer.user_id = user.id
                            AND user.id = ?");
        $stmt->bind_param("ssss", $email, $phone, $avt, $delivery_officer_id);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("UPDATE delivery_officer, user
                            SET email = ?,
                                phone = ?
                            WHERE delivery_officer.user_id = user.id
                            AND user.id = ?");
        $stmt->bind_param("sss", $email, $phone, $delivery_officer_id);
        $stmt->execute();
    }
    $_SESSION['user']['email'] = $email;
    $_SESSION['user']['phone'] = $phone;
    $_SESSION['user']['avatar'] = $avt;
    echo "1";
}
