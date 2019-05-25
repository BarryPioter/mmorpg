<?php

require_once '../lib/config.php';
//get the q parameter from URL
if (isset($_GET['c']) && isset($_GET['t'])) {
    $c = $_GET["c"];
    $type = $_GET["t"];
    $sql = "SELECT e.equipment_id,e.item_id,i.item_name,e.quantity,e.lvl,(e.value + (select base_price from items where item_id=e.item_id)) as enchant FROM equipments as e INNER JOIN items as i on e.item_id=i.item_id WHERE e.character_id = ?";


    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $c);
    $output = "";

    if ($stmt->execute()) {
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($eq, $id, $name, $quantity, $lvl, $upgrade);
            $output .= "<table class='shop' align='center'>";
            $output .= '<tr><th>NAME</th><th>QUANTITY</th><th>ITEM LVL</th><th>ENCHANT COST</th><th></th></tr>';
            while ($stmt->fetch()) {
                $output .= '<tr><td>' . $name . '</td><td>' . $quantity . '</td><td>' . $lvl . '</td><td>' . $upgrade . '</td><td>';
                if ($type == 1) {
                    $output .= '<button onclick="enchant(' . $eq . ',' . $id . ');">ENCHANT</button>';
                }
                $output .= '</td></tr>';
            }
            $output .= "</table>";
            echo $output;
        } else {
            $output = "Equipment is empty";
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