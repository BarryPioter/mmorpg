<?php

session_start();

require '../lib/config.php';
require '../lib/functions.php';
$err = "";

if (isset($_GET['id'])) {


    $id = $_GET['id'];

    $sql = "INSERT INTO admins (player_id) VALUES (?)";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $id);


    if ($stmt->execute()) {
        echo "Succesfully created new admin";
    } else {
        echo "Something went wrong - exec";
    }
    $stmt->close();
} else {
    $err = "Something went wrong - get";
}
?>