<?php

session_start();

require '../lib/config.php';
require '../lib/functions.php';

if (isset($_GET['t']) && isset($_GET['id'])) {
    $x = $_GET["t"];
    $id = $_GET["id"];

    $sql = "UPDATE `reports` SET `status_id` = ?, `admin_id` = ? WHERE `reports`.`report_id` = ? ";

    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param('iii', $x, $_SESSION['admin'], $id);
        if ($stmt->execute()) {
            echo "Successfully changed report status";
        } else {
            echo "Something went wrong - update";
        }
        $stmt->free_result();

        $stmt->close();
    } else {
        echo "Something went wrong";
    }
} else {
    echo "Something went wrong - get";
}
