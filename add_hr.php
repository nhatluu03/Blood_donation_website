<?php
// id varchar(50) PK 
// username varchar(50) 
// password varchar(50) 
// name varchar(50) 
// created_at datetime 
// phone varchar(10) 
// email varchar(100)

// user_id varchar(50) PK
// hospital_id varchar(50)
include("./db/connect.php");
include("./php/gen_uuid.php");
if (isset($_POST["reg_hr_name"])) {
    $id = gen_uuid();
    $username = $_POST["reg_hr_username"];
    $password = password_hash($_POST["reg_hr_password"], PASSWORD_DEFAULT);
    $created_at = date('Y-m-d H:i:s');

    $name = $_POST["reg_hr_name"];
    $phone = $_POST["reg_hr_phone"];
    $hospital_id = $_POST["reg_hr_hospital_id"];

    // Check if the username already exists
    $stmt1 = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt1->bind_param("s", $username);
    $stmt1->execute();
    $stmt1->store_result();
    if ($stmt1->num_rows() > 0) {
        echo "0";
    } else {
        // Insert to tbl user
        $stmt2 = $conn->prepare("INSERT INTO user (`id`, `username`, `password`, `name`, `phone`, `created_at`)
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt2->bind_param("ssssss", $id, $username, $password, $name, $phone, $created_at);
        $stmt2->execute();

        // Insert to tbl administrative_manager
        $stmt3 = $conn->prepare("INSERT INTO administrative_manager (`user_id`, `hospital_id`)
                                VALUES (?, ?)");
        $stmt3->bind_param("ss", $id, $hospital_id);
        $stmt3->execute();
        echo "1";
    }
}