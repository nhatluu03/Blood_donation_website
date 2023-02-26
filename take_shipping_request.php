<?php
include('./db/connect.php');
if (isset($_POST['request_id']) && isset($_POST['delivery_officer_id']) && isset($_POST['hospital_supply_id'])) {
    // Check whether delivery officer is in charge of another shipping request
    $request_id = $_POST['request_id'];
    $delivery_officer_id = $_POST['delivery_officer_id'];
    $hospital_supply_id = $_POST['hospital_supply_id'];
    $stmt = $conn->prepare("SELECT *
                    FROM request, delivery_officer
                    WHERE request.delivery_officer_id = delivery_officer.user_id
                    AND delivery_officer.user_id = ?
                    AND request.status = 'delivering'");
    $stmt->bind_param("s", $delivery_officer_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows() > 0) {
        echo "0";
    } else {
        $stmt = $conn->prepare("UPDATE request
        SET delivery_officer_id = ?,
            hospital_supply_id = ?,
            status = 'delivering'
        WHERE request.id = ?");
        $stmt->bind_param("sss", $delivery_officer_id, $hospital_supply_id, $request_id);
        $stmt->execute();
        echo "1";
    }
}
