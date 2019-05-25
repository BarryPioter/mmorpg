<?php

session_start();

require '../lib/config.php';
require '../lib/functions.php';
$err = "";

if (isset($_GET['t'])) {

    $x = $_GET['t'];

    $sql = "update bans set active = 0 where ban_id = ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $x);

    if ($stmt->execute()) {
        
    } else {
        echo "Something went wrong - exec";
    }
    $stmt->close();
} else {
    $err = "Something went wrong - get";
}
?>