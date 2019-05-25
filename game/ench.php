<?php

session_start();

require_once '../lib/config.php';
//get the q parameter from URL
if (isset($_GET['eq']) && isset($_GET['c']) && isset($_GET['i'])) {
    $eq = $_GET["eq"];
    $i = $_GET["i"];
    $c = $_GET["c"];

    $sql = "select value_for_upgrade from items where item_id = ? and ((select money from characters where character_id = ?)>=base_price*((select lvl from equipments where equipment_id=?)))";


    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('iii', $i, $c, $eq);

    if ($stmt->execute()) {
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $sql = "UPDATE equipments as e SET e.lvl = e.lvl + 1 , e.value = e.value + (select base_price from items where item_id=e.item_id) WHERE e.equipment_id = ?";


            $stmt2 = $mysqli->prepare($sql);
            $stmt2->bind_param('i', $eq);

            if ($stmt2->execute()) {
                $sql = "UPDATE characters SET money = money - ((select base_price from items where item_id = ?)*(select lvl from equipments where equipment_id=?)) WHERE character_id = ?";


                $stmt3 = $mysqli->prepare($sql);
                $stmt3->bind_param('iii', $i, $eq, $c);

                if ($stmt3->execute()) {
                    echo "Item succesfully enchanted";
                } else {
                    echo "Something went wrong";
                }
                $stmt3->free_result();

                $stmt3->close();
            } else {
                echo "Something went wrong";
            }
            $stmt2->free_result();

            $stmt2->close();
        } else {
            echo "Not enough money";
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