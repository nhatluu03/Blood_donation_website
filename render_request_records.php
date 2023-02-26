<?php
include('./db/connect.php');
include('./php/format.php');
if (isset($_POST['hospital_id'])) {
    $hospital_id = $_POST['hospital_id'];
    $stmt = $conn->prepare("SELECT DISTINCT request.id as request_id, h1.name, blood_group.id, blood_group.name, amount, status, request.created_at
    FROM request, hospital h1, blood_group
    WHERE request.hospital_demand_id = h1.id
    AND request.blood_group_id = blood_group.id
    AND request.hospital_demand_id != ?
    ORDER BY (
                     case status 
                     WHEN  'waiting' then 0
                     WHEN 'delivering' then 1
                     WHEN 'delivered' then 2
                     end
                )");
    $stmt->bind_param("s", $hospital_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($request_id, $hospital_demand, $blood_group_id, $blood_group_name, $amount, $status, $request_at);

    if ($stmt->num_rows() > 0) {
        $count = 1;
        while ($stmt->fetch()) {
            echo ' <tr class="data_rows"> 
                <td class="mobile-hide">' . $count++ . '</td>
                <td>' . $hospital_demand . '</td>
                <td>' . strtoupper($blood_group_name) . '</td>
                <td>' . $amount . ' ml</td>
                <td class="mobile-hide">' . format_date_time($request_at) . '</td>
                <td class="pc-hide tablet-hide">' . date_format(date_create($request_at), "d.m.20y") . '</td>
                <td>';

            if ($status == "waiting") {
                echo '<p id = "' . $request_id . '" class="accept-request-btn" onclick="acceptRequest(this.id)"> Accept </p>';
            } else if ($status == "delivering") {
                echo "Delivering";
            } else {
                echo "Delivered";
            }
            echo '</tr>';
        }
    }
}
