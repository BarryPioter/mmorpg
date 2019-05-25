<?php

session_start();

require '../lib/config.php';
require '../lib/functions.php';
$err = "";

if (isset($_GET['id']) && isset($_GET['type'])) {

    $id = $_GET['id'];
    $priv = $_GET['type'];
    $sql = '';
    switch ($priv) {
        case 2:
            $sql = "update items set items.active = !items.active where item_id = ?";
            break;
        case 4:
            $sql = "DELETE FROM `item_types` WHERE `item_types`.`type_id` = ?";
            break;
        case 6:
            $sql = "update classes set classes.active = !classes.active where class_id = ?";
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