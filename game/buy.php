<?php

session_start();
// TODO: tax money, require lvl
require_once '../lib/config.php';
//get the q parameter from URL
if (isset($_GET['i']) && isset($_GET['c'])) {
    $i = $_GET["i"];
    $c = $_GET["c"];

    $output = "";

    $sql4 = "select player_id from characters where ((select required_lvl from items where item_id = ?) <= lvl) and character_id = ?";


    $stmt4 = $mysqli->prepare($sql4);
    $stmt4->bind_param('ii', $i, $c);

    if ($stmt4->execute()) {
        $stmt4->store_result();
        if ($stmt4->num_rows > 0) {

            $sql = "select player_id from characters where ((select base_price from items where item_id = ?) <= money) and character_id = ?";


            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param('ii', $i, $c);

            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $sql2 = "UPDATE characters SET money = money - (select base_price from items where item_id = ?) WHERE character_id = ?";


                    $stmt2 = $mysqli->prepare($sql2);
                    $stmt2->bind_param('ii', $i, $c);

                    if ($stmt2->execute()) {
                        $sql3 = "INSERT INTO `equipments`(`character_id`, `item_id`, `quantity`, `lvl`, `value`) VALUES (?,?,1,1,(select base_price from items WHERE item_id = ?))";


                        $stmt3 = $mysqli->prepare($sql3);
                        $stmt3->bind_param('iii', $c, $i, $i);

                        if ($stmt3->execute()) {
                            echo "Succesfully bought item.";
                        } else {
                            echo "Something went wrong - insert";
                        }

                        $stmt3->close();
                    } else {
                        echo "Something went wrong - update money";
                    }

                    $stmt2->close();
                } else {
                    echo "Something went wrong - no money";
                }
            } else {
                echo "Something went wrong - select money";
            }
            $stmt->free_result();

            $stmt->close();
        } else {
            echo "Something went wrong - no lvl";
        }
    } else {
        echo "Something went wrong - select lvl";
    }

    $stmt4->free_result();

    $stmt4->close();
} else {
    echo "Something went wrong - isset";
}
?>
