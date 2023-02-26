<?php
include('./db/connect.php');
if (isset($_POST['request_id'])) {
    $request_id = $_POST['request_id'];

    // Get hospital_supply_id, demand_blood_group_id, and demand_amount
    $stmt2 = $conn->prepare("SELECT hospital_supply_id, blood_group_id, amount
                            FROM request
                            WHERE request.id = ?");
    $stmt2->bind_param("s", $request_id);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($hospital_supply_id, $demand_blood_group_id, $demand_amount);

    if ($stmt2->num_rows() > 0) {
        $stmt2->fetch();
        $stmt3 = $conn->prepare("UPDATE store
                                SET amount = amount + ?
                                WHERE hospital_id = ?
                                AND blood_group_id = ?");
        $stmt3->bind_param("sss", $demand_amount, $hospital_supply_id, $demand_blood_group_id);
        $stmt3->execute();

        $stmt1 = $conn->prepare("UPDATE request
                        SET status = 'waiting',
                            hospital_supply_id = null,
                            delivery_officer_id = null
                        WHERE request.id = ?");
        $stmt1->bind_param("s", $request_id);
        $stmt1->execute();
        $stmt1->store_result();
        echo '1';
    }
}
