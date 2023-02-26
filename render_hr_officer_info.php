<?php
include('./db/connect.php');
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $stmt = $conn->prepare("SELECT avatar, phone, email
                    FROM administrative_manager, user 
                    WHERE administrative_manager.user_id = user.id
                    AND administrative_manager.user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($avatar, $phone, $email);
    if ($stmt->num_rows() > 0) {
        $stmt->fetch();
        $avatar = $avatar ? $avatar : "default_avatar.png";
        $phone = $phone  ? $phone  : "Unset";
        $email = $email  ? $email  : "Unset";

        echo '<i class="fa-regular fa-pen-to-square edit-ic" onclick="openEditHrOfficerForm()"></i>
        <img src="./db/uploads/users/'.$avatar.'" alt="" class="user-profile__avt">
        <h3 class="user-profile__name">Nguyen Van A</h3>
        <hr>
        <p class="user-profile__info">Phone: '.$phone.'</p>
        <p class="user-profile__info">Email: '.$email.'</p>
        ';
    } else {
        echo '0';
    }
}
