<?php
include('./db/connect.php');
if (isset($_POST['request_id']) && isset($_POST['confirm_temperature_after'])) {
    $request_id = $_POST['request_id'];
    $temperature_after = $_POST['confirm_temperature_after'];

    $stmt1 = $conn->prepare("UPDATE request 
                            SET status = 'delivered',
                            temperature_after = ?
                            WHERE request.id = ?");
    $stmt1->bind_param("ss", $temperature_after, $request_id);
    $stmt1->execute();
    $stmt1->store_result();

    // Get hospital_demand_id, demand_blood_group_id, and demand_amount
    $stmt2 = $conn->prepare("SELECT hospital_demand_id, blood_group_id, amount
                            FROM request
                            WHERE request.id = ?");
    $stmt2->bind_param("s", $request_id);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($hospital_demand_id, $demand_blood_group_id, $demand_amount);
    $stmt2->fetch();

    // Check if the hospital demand has the storage for the blood_group_demand_id
    // If no, create a storage and update the amount
    $stmt3 = $conn->prepare("SELECT * 
                        FROM store 
                        WHERE hospital_id = ? 
                        AND blood_group_id = ?");
    $stmt3->bind_param("ss", $hospital_demand_id, $demand_blood_group_id);
    $stmt3->execute();
    $stmt3->store_result();

    if ($stmt3->num_rows() < 1) {
        $stmt3->fetch();
        $stmt6 = $conn->prepare("INSERT INTO store(`blood_group_id`, `hospital_id`, `amount`)
                                        VALUES (?, ?, '0')");
        $stmt6->bind_param("ss", $demand_blood_group_id, $hospital_demand_id);
        $stmt6->execute();
    }

    $stmt7 = $conn->prepare("UPDATE store
                            SET amount = amount + ?
                            WHERE hospital_id = ?
                            AND blood_group_id = ?");
    $stmt7->bind_param("sss", $demand_amount, $hospital_demand_id, $demand_blood_group_id);
    $stmt7->execute();
    echo '1';
}
