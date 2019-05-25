<?php

session_start();

require '../lib/config.php';
require '../lib/functions.php';
$err = "";

if (isset($_GET['id']) && isset($_GET['priv'])) {

    $id = $_GET['id'];
    $priv = $_GET['priv'];
    $sql = '';
    switch ($priv) {
        case 1:
            $sql = "update admins set admins.remove = !admins.remove where admin_id = ?";
            break;
        case 2:
            $sql = "update admins set admins.edit = !admins.edit where admin_id = ?";
            break;
        case 3:
            $sql = "update admins set admins.create = !admins.create where admin_id = ?";
            break;
        case 4:
            $sql = "update admins set admins.check = !admins.check where admin_id = ?";
            break;
        case 5:
            $sql = "update admins set admins.promote = !admins.promote where admin_id = ?";
            break;
        case 6:
            $sql = "update admins set admins.active = !admins.active where admin_id = ?";
            break;
    }


    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        
    } else {
        return "Something went wrong - exec";
    }
    $stmt->close();
} else {
    return "Something went wrong - get";
}
?>