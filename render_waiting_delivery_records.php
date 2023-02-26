<?php
include('./db/connect.php');
if (isset($_POST['hospital_supply_id'])) {
    $hospital_supply_id = $_POST['hospital_supply_id'];
    $stmt = $conn->prepare("SELECT request.id, hospital_demand.name, hospital_demand.address, blood_group.name, request.amount, request.temperature_before, request.temperature_after, request.created_at
        FROM request, hospital hospital_demand, blood_group
        WHERE request.hospital_supply_id = ?
        AND request.blood_group_id = blood_group.id
        AND request.hospital_demand_id = hospital_demand.id
        AND request.status = 'delivering'");
    $stmt->bind_param("s", $hospital_supply_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($request_id, $hospital_demand_name, $hospital_demand_address, $blood_group, $amount, $temperature_before, $temperature_after, $created_at);

    if ($stmt->num_rows() > 0) {
        $count = 1;
        while ($stmt->fetch()) {
            echo '<tr>
            <td class="phone-hide">' . $count++ . '</td>
            <td>' . $hospital_demand_name . '</td>
            <td>' . $hospital_demand_address . '</td>
            <td>' . strtoupper($blood_group) . '</td>
            <td>' . $amount . '</td>
            <td>' . $temperature_before . '</td>
            <td>
                <button id="' . $request_id . '"class="func-btn take-shipping-request" onclick="takeShippingRequest(this.id)"> Take </button>
            </td>
        </tr>';
        }
    }
}
?>