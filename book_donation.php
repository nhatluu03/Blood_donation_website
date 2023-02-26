<?php
include('./db/connect.php');
// donation_calendar_id VARCHAR(50) NOT NULL,
// donor_id VARCHAR(50) NOT NULL,
// amount INT NOT NULL,
// created_at DATETIME NOT NULL,
// is_verified ENUM("0", "1"),

if (isset($_POST['user_id'])) {
    $donation_calendar_id = $_POST['book_calendar_id'];
    $donor_id = $_POST['user_id'];
    $amount = $_POST['book_amount'];
    $is_verified = "0";
    $created_at = date('Y-m-d H:i:s');

    // Insert into tbl donation
    $stmt1 = $conn->prepare("INSERT INTO donate (`donor_id`, `donation_calendar_id`, `amount`, `is_verified`, `created_at`)
                        VALUES (?, ?, ?, ?, ?)");
    $stmt1->bind_param("sssss", $donor_id, $donation_calendar_id, $amount, $is_verified, $created_at);
    $stmt1->execute();
    $stmt1->store_result();

    echo "1";
}
?>