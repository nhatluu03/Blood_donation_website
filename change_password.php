<?php
include('./db/connect.php');
// $password = "abc123";
// $hashed_password = password_hash($password, PASSWORD_DEFAULT);
// var_dump($hashed_password);
if (isset($_POST['new_password']) && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $old_password = $_POST['old_password'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("SELECT password FROM user WHERE user.id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($hashed_password);
    if ($stmt->num_rows() > 0) {
        $stmt->fetch();
        if (password_verify($old_password, $hashed_password)) {
            $stmt = $conn->prepare("UPDATE user
                                SET password = ?
                                WHERE id = ?");
            $stmt->bind_param("ss", $new_password, $user_id);
            $stmt->execute();
            echo '1';
        } else {
            echo '0';
        }
    }
}