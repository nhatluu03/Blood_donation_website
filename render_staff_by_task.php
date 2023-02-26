<?php
include('./db/connect.php');
if (isset($_POST['hospital_id'])) {
    $hospital_id = $_POST['hospital_id'];
    if (isset($_POST['*'])) {
        $stmt = $conn->prepare("SELECT user.id as staff_id, user.name as staff_name, user.phone, user.email, user.created_at as staff_created_at
                        FROM hospital, administrative_manager, database_officer, delivery_officer, user
                        WHERE hospital.id = ?
                        AND ((user.id = administrative_manager.user_id AND administrative_manager.hospital_id = hospital.id)
                        OR (user.id = database_officer.user_id AND database_officer.hospital_id = hospital.id)
                        OR (user.id = delivery_officer.user_id AND delivery_officer.hospital_id = hospital.id))
                        GROUP BY user.id");
    } else if (isset($_POST['database_task'])) {
        $stmt = $conn->prepare("SELECT user.id as staff_id, user.name as staff_name, user.phone, user.email, user.created_at as staff_created_at
                            FROM database_officer, user
                            WHERE user.id = database_officer.user_id
                            AND database_officer.hospital_id = ?");
    } else if (isset($_POST['delivery_task'])) {
        $stmt = $conn->prepare("SELECT user.id, user.name, user.phone, user.email, user.created_at
                    FROM delivery_officer, user
                    WHERE user.id = delivery_officer.user_id
                    AND delivery_officer.hospital_id = ?");
    }

    $stmt->bind_param("s", $hospital_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($staff_id, $staff_name, $staff_phone, $staff_email, $staff_created_at);
    if ($stmt->num_rows() > 0) {
        $count = 1;
        while ($stmt->fetch()) {
            $staff_name = $staff_name ? $staff_name : "Unset";
            $staff_phone = $staff_phone ? $staff_phone : "Unset";
            $staff_email = $staff_email ? $staff_email : "Unset";

            echo '<tr class="data_rows phone-hide">
                    <td class="mobile_hide">' . $count ++ . '</td>
                    <td>' . $staff_name . '</td>
                    <td>' . $staff_phone . '</td>
                    <td>' . $staff_email . '</td>
                    <td>20.000</td>
                    <td>' . date_format(date_create($staff_created_at), "d.m.20y") . '</td>
                </tr>';
        }
    } else {
        echo '<tr> 
                <td> No staff information found</td>
            </td>';
    }
}