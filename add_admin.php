<?php
// id varchar(50) PK 
// username varchar(50) 
// password varchar(50) 
// name varchar(50) 
// created_at datetime 
// phone varchar(10) 
// email varchar(100)

// address TEXT NULL,
// blood_group_id VARCHAR(50) NOT NULL,

// birth_date DATETIME NULL,
// sex ENUM("male", "female", "other") NULL,
// height INT NULL,
// weight INT NULL,
// is_addicted_alcohol ENUM("1", "0") NULL,
// is_positive_drug ENUM("1", "0") NULL,

include("./db/connect.php");
include("./php/gen_uuid.php");
if (isset($_POST["reg_admin_username"])) {
    $id = gen_uuid();
    $username = $_POST["reg_admin_username"];
    $password = password_hash($_POST["reg_admin_password"], PASSWORD_DEFAULT);
    $name = $_POST["reg_admin_name"];
    $created_at = date('Y-m-d H:i:s');


    // Check if the username already exists
    $stmt1 = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt1->bind_param("s", $username);
    $stmt1->execute();
    $stmt1->store_result();
    if ($stmt1->num_rows() > 0) {
        echo "0";
    } else {
        // Insert to tbl user
        $stmt2 = $conn->prepare("INSERT INTO user (`id`, `username`, `password`, `name`, `created_at`)
                                VALUES (?, ?, ?, ?, ?)");
        $stmt2->bind_param("sssss", $id, $username, $password, $name, $created_at);
        $stmt2->execute();

        // Insert to tbl admin
        $stmt3 = $conn->prepare("INSERT INTO admin (`user_id`, `created_at`) 
                                VALUES (?, ?)");
        $stmt3->bind_param("ss", $id, $created_at);
        $stmt3->execute();
        echo "1";
    }
}
