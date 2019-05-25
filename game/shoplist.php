<?php

require_once '../lib/config.php';
//get the q parameter from URL
if (isset($_GET['t'])) {
    $t = $_GET["t"];
    if ($t != -1) {
        $sql = "select item_id ,item_name,stat_value,base_price,required_lvl FROM items where active = 1 && type_id = ?";
    } else {
        $sql = "select item_id ,item_name,stat_value,base_price,required_lvl FROM items where active = 1";
    }

    $stmt = $mysqli->prepare($sql);
    if ($t != -1) {
        $stmt->bind_param('i', $t);
    }
    $output = "";

    if ($stmt->execute()) {
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $name, $stat, $price, $lvl);
            $output .= "<table class='shop' align='center'>";
            $output .= '<tr><th>NAME</th><th>STATS</th><th>REQUIRED LVL</th><th>PRICE</th><th></th></tr>';
            while ($stmt->fetch()) {
                $output .= '<tr><td>' . $name . '</td><td>' . $stat . '</td><td>' . $lvl . '</td><td>' . $price . '</td><td><button onclick="buy(' . $id . ');">BUY</button></td></tr>';
            }
            $output .= "</table>";
            echo $output;
        } else {
            $output = "Shop is empty";
            echo $output;
        }
    } else {
        echo "Something went wrong";
    }
    $stmt->free_result();

    $stmt->close();
} else {
    echo "Something went wrong";
}
?> 