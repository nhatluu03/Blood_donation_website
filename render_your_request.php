<?php
include('./db/connect.php');
if (isset($_POST['hospital_id'])) {
    $hospital_id = $_POST['hospital_id'];
    $stmt1 = $conn->prepare("SELECT request.id, status, hospital.name, hospital.address
    FROM request, hospital
    WHERE request.hospital_demand_id = hospital.id
    AND hospital.id = ?
    ORDER BY (
                     case request.status 
                     WHEN  'delivering' then 0
                     WHEN 'waiting' then 1
                     end
                );");
    $stmt1->bind_param("s", $hospital_id);
    $stmt1->execute();
    $stmt1->store_result();
    $stmt1->bind_result($request_id, $request_status, $hospital_demand_name, $hospital_demand_addres);
    if ($stmt1->num_rows() > 0) {
        $count = 0;
        while ($stmt1->fetch()) {
            switch ($request_status) {
                case "waiting":
                    echo '<div class="shipping-process">
                            <div class="shipping-step active">
                                <i class="fa-solid fa-check-to-slot"></i>
                                <p>Waiting for suppliers</p>
                            </div>
                            <div class="shipping-step">
                                <i class="fa-solid fa-truck-medical"></i>
                                <p>Being processed</p>
                            </div>
                            <div class="shipping-step">
                                <i class="fa-solid fa-download"></i>
                                <p>Being processed</p>
                            </div>
                        </div>';
                    $count++;
                    break;
                case "delivering":
                    $stmt2 = $conn->prepare("SELECT hospital.name, hospital.address, blood_group.name, request.amount, user.name, user.phone
                                        FROM request, hospital, delivery_officer, user, blood_group
                                        WHERE request.hospital_supply_id = hospital.id
                                        AND request.delivery_officer_id = delivery_officer.user_id
                                        AND user.id = delivery_officer.user_id
                                        AND request.blood_group_id = blood_group.id
                                        AND request.id =?");
                    $stmt2->bind_param("s", $request_id);
                    $stmt2->execute();
                    $stmt2->store_result();
                    $stmt2->bind_result($hospital_supply_name, $hospital_supply_address, $request_blood, $request_amount, $delivery_officer_name, $delivery_officer_phone);
                    $stmt2->fetch();

                    echo '<div class="shipping-process">
                            <div class="shipping-step active">
                            <i class="fa-solid fa-check-to-slot"></i>
                            <p>Request accepted by</p>
                            <p><strong>' . $hospital_supply_name . '</strong></p>
                            <p><strong>' . $hospital_supply_address . '</strong></p>
                        </div>
                        <div class="shipping-step active">
                            <i class="fa-solid fa-truck-medical"></i>
                            <p>Being delivered by</p>
                            <p><strong>' . $delivery_officer_name . '</strong></p>
                            <p><strong>' . $delivery_officer_phone . '</strong></p>
                        </div>
                        <div class="shipping-step">
                            <i class="fa-solid fa-download"></i>
                            <p>Receive procedure</p>
                            <p><strong>' . $hospital_demand_name . '</strong></p>
                            <button class="func-btn" onclick="confirmShippingRequest(\'' . $request_id . '\', \'' . strtoupper($request_blood) . '\', \'' . $request_amount . '\')"> Confirm </button>
                        </div>
                        </div>';
                    $count++;
                    break;
            }
        }
        if ($count == 0) {
            echo '<p class="sys-msg"> No requests found.</p>';
        }
    } else {
        echo '<p class="sys-msg> No requests found.</p>';
    }
}
?>