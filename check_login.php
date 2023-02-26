<?php
include('./db/connect.php');
session_start();
if (isset($_POST["log_username"])  && $_POST["log_password"]) {
    $log_username = $_POST['log_username'];
    $log_password = $_POST['log_password'];

    $stmt = $conn->prepare("SELECT id, password, name, avatar, phone, email, created_at
                        FROM user WHERE username = ?");
    $stmt->bind_param("s", $log_username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password, $name, $avatar, $phone, $email, $created_at);
    $stmt->fetch();   // must fetch to get binded results
    $tmp_avatar = $avatar;

    if (!$tmp_avatar) {
        $tmp_avatar = 'default_avatar.png';
    }
    if ($stmt->num_rows() < 1  || !password_verify($log_password, $hashed_password)) {
        echo '0';
        // $log_err = "Tài khoản hoặc mật khẩu không chính xác!";
    } else {
        $_SESSION['is_logged'] = true;
        $_SESSION['user'] = [
            "id" => $id,
            "name" => $name,
            "avatar" => $tmp_avatar,
            "email" => $email,
            "phone" => $phone,
            "created_at" => $created_at,
        ];

        // Is donor account
        $stmt2 = $conn->prepare("SELECT citizen_id, blood_group.name, address, latitude, longitude, birth_date, weight, height, is_addicted_alcohol, is_positive_drug  
                                FROM donor, blood_group
                                WHERE donor.blood_group_id = blood_group.id
                                AND user_id = ?");
        $stmt2->bind_param("s", $id);
        $stmt2->execute();
        $stmt2->store_result();
        $stmt2->bind_result($citizen_id, $blood_group, $address, $latitude, $longitude, $birth_date, $weight, $height, $is_addicted_alcohol, $is_positive_drug);

        if ($stmt2->num_rows() > 0) {
            $stmt2->fetch();
            $_SESSION['user']['role'] = "donor";
            $_SESSION['user']['citizen_id'] = $citizen_id;
            $_SESSION['user']['blood_group'] = strtoupper($blood_group);
            $_SESSION['user']['latitude'] = $latitude;
            $_SESSION['user']['longitude'] = $longitude;
            $_SESSION['user']['address'] = $address;
            $_SESSION['user']['birth_date'] = $birth_date;
            $_SESSION['user']['weight'] = $weight;
            $_SESSION['user']['height'] = $height;
            $_SESSION['user']['is_addicted_alcohol'] = $is_addicted_alcohol;
            $_SESSION['user']['is_positive_drug'] = $is_positive_drug;
            echo '2';
            // header("location: ./donor_profile.php");
            exit;
        }

        // // Is hospital database staff account
        $stmt3 = $conn->prepare("SELECT hospital.id 
                            FROM database_officer, hospital
                            WHERE database_officer.hospital_id = hospital.id
                            AND user_id = ?");
        $stmt3->bind_param("s", $id);
        $stmt3->execute();
        $stmt3->store_result();
        $stmt3->bind_result($hospital_id);

        if ($stmt3->num_rows() > 0) {
            $stmt3->fetch();
            $_SESSION['user']['role'] = "database_officer";
            $_SESSION['user']['hospital_id'] = $hospital_id;
            echo '3';
            // header("location: ./database_officer_workspace.php");
            exit;
        }

        // // Is hospital delivery staff account
        $stmt4 = $conn->prepare("SELECT hospital.id
                            FROM delivery_officer, hospital
                            WHERE delivery_officer.user_id = ?
                            AND delivery_officer.hospital_id = hospital.id;");
        $stmt4->bind_param("s", $id);
        $stmt4->execute();
        $stmt4->store_result();
        $stmt4->bind_result($hospital_id);

        if ($stmt4->num_rows() > 0) {
            $stmt4->fetch();
            $_SESSION['user']['role'] = "delivery_officer";
            $_SESSION['user']['hospital_id'] = $hospital_id;
            echo '4';
            // header("location: ./delivery_officer_profile.php");
            exit;
        }

        // // Is hospital hospital hr account
        $stmt5 = $conn->prepare("SELECT hospital.id
                            FROM administrative_manager, hospital
                            WHERE administrative_manager.user_id = ?
                            AND administrative_manager.hospital_id = hospital.id;");
        $stmt5->bind_param("s", $id);
        $stmt5->execute();
        $stmt5->store_result();
        $stmt5->bind_result($hospital_id);

        if ($stmt5->num_rows() > 0) {
            $stmt5->fetch();
            $_SESSION['user']['role'] = "hr";
            $_SESSION['user']['hospital_id'] = $hospital_id;
            echo '5';
            // header("location: ./hr_officer_workspace.php");
            exit;
        }

        // // Is admin account
        $stmt6 = $conn->prepare("SELECT user_id FROM admin WHERE user_id = ?");
        $stmt6->bind_param("s", $id);
        $stmt6->execute();
        $stmt6->store_result();

        if ($stmt6->num_rows() > 0) {
            $stmt6->fetch();
            $_SESSION['user']['role'] = "admin";
            echo '6';
            // header("location: ./dashboard/user_db.php");
            exit;
        }
    }
}
