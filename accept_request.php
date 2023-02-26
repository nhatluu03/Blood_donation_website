<?php
include('./db/connect.php');
if (isset($_POST['request_id']) && isset($_POST['delivery_officer_id']) && isset($_POST['hospital_supply_id'])) {
    $request_id = $_POST['request_id'];
    $hospital_supply_id = $_POST['hospital_supply_id'];
    $delivery_officer_id = $_POST['delivery_officer_id'];

    // Get demand_blood_group, and demand_amount
    $stmt1 = $conn->prepare("SELECT hospital_demand_id, blood_group_id, amount
                    FROM request
                    WHERE request.id = ?");
    $stmt1->bind_param("s", $request_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($hospital_demand_id, $demand_blood_group_id, $demand_amount);

    if ($stmt1->num_rows() > 0) {
        $stmt1->fetch();
        // Check if the supplier has enough blood amount to be transfered
        $stmt2 = $conn->prepare("SELECT amount FROM store WHERE hospital_id = ? AND blood_group_id = ?");
        $stmt2->bind_param("ss", $hospital_supply_id, $demand_blood_group_id);
        $stmt2->execute();
        $stmt2->store_result();
        $stmt2->bind_result($supply_amount);

        if ($stmt2->num_rows() > 0) {
            $stmt2->fetch();
            // If enough blood to supply, update status of request and exchange the amount from to hospital in need. Otherwise, return error msg
            if ($supply_amount >= $demand_amount) {
                $stmt3 = $conn->prepare("UPDATE request
                                SET status = 'delivering',
                                    hospital_supply_id = ?,
                                    delivery_officer_id = ?
                                WHERE id = ?");
                $stmt3->bind_param("sss", $hospital_supply_id, $delivery_officer_id, $request_id);
                $stmt3->execute();

                // Temporarily minus the amount of hospital supply
                $stmt4 = $conn->prepare("UPDATE store
                                SET amount = amount - ?
                                WHERE hospital_id = ?
                                AND blood_group_id = ?");
                $stmt4->bind_param("sss", $demand_amount, $hospital_supply_id, $demand_blood_group_id);
                $stmt4->execute();
                echo '1';
            } else {
                echo '0'; // The amount of blood in the inventory is not enough to supply
            }
        } else {
            echo '0'; // The storage of hospital does not have any item for this blood group
        }
    }
}
