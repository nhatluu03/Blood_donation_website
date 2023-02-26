<?php
include('./db/connect.php');
include('./php/gen_uuid.php');

// id VARCHAR(50) NOT NULL,
// hospital_demand_id VARCHAR(50) NOT NULL,
// hospital_supply_id VARCHAR(50) NULL,
// delivery_officer_id VARCHAR(50) NULL,
// blood_group_id VARCHAR(50) NOT NULL,
// status ENUM("waiting", "processing", "processed") NOT NULL,
// amount INT NOT NULL,
// temperature_before INT NULL,
// temperature_after INT NULL,
// created_at DATETIME NOT NULL

if (isset($_POST['amount'])) {
    $id = gen_uuid();
    $hospital_demand_id = $_POST['hospital_demand_id'];
    $blood_group_id = $_POST['blood_group_id'];
    $amount = $_POST['amount'];
    $status = "waiting";
    $created_at = date("Y-m-d H:i:s");
    // Insert into tbl request
    $stmt = $conn->prepare("INSERT INTO request (`id`, `hospital_demand_id`, `blood_group_id`, `amount`, `status`, `created_at`)
                                VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $id, $hospital_demand_id, $blood_group_id, $amount, $status, $created_at);
    $stmt->execute();
    echo "1";
}
?>