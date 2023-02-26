<?php
    include("./db/connect.php");
    if (isset($_POST["donor_id"])) {
        $donor_id = $_POST["donor_id"];
        $weight = $_POST["edit_weight"];
        $height = $_POST["edit_height"];
        $is_addicted_alcohol = $_POST["edit_is_addicted_alcohol"];
        $is_positive_drug = $_POST["edit_is_positive_drug"];

        $stmt = $conn->prepare("UPDATE user
                            SET weight = ?,
                            height = ?,
                            is_addicted_alcohol = ?,
                            is_positive_drug = ?
                            WHERE id = ? ");
        $stmt->bind_param("sssss", $weight, $height, $is_addicted_alcohol, $is_positive_drug, $donor_id);
        $stmt->execute();
        echo "1";

    }
?>