<?php

session_start();

require '../lib/config.php';
require '../lib/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['type'])) {
        switch ($_POST['type']) {
            case 1:
                //item
                //name item_type stat price upgrade lvl
                if (isset($_POST['name']) && isset($_POST['stat']) && isset($_POST['item_type']) && isset($_POST['price']) && isset($_POST['upgrade']) && isset($_POST['lvl']) && !empty(trim($_POST['name']))) {

                    $name = trim($_POST['name']);
                    $item_type = $_POST['item_type'];
                    $stat = $_POST['stat'];
                    $price = $_POST['price'];
                    $upgrade = $_POST['upgrade'];
                    $lvl = $_POST['lvl'];

                    if ($item_type == -1) {
                        echo "Something went wrong - item type";
                        exit;
                    }

                    $sql2 = "SELECT item_name FROM items WHERE item_name = ?";

                    $stmt2 = $mysqli->prepare($sql2);
                    $stmt2->bind_param('s', $name);


                    if ($stmt2->execute()) {
                        $stmt2->store_result();

                        if ($stmt2->num_rows == 0) {
                            $sql = "INSERT INTO items (item_name,type_id,stat_value,base_price,value_for_upgrade,required_lvl) VALUES (?,?,?,?,?,?)";

                            $stmt = $mysqli->prepare($sql);
                            $stmt->bind_param('siiiii', $name, $item_type, $stat, $price, $upgrade, $lvl);


                            if ($stmt->execute()) {
                                echo "Succesfully created new items";
                            } else {
                                echo "Something went wrong - exec";
                            }
                            $stmt->close();
                        } else {
                            echo "The is already class with this name";
                        }
                    } else {
                        echo "Something went wrong - exec name";
                    }
                    $stmt2->free_result();
                    $stmt2->close();
                } else {
                    echo "Something went wrong - isset";
                }
                break;
            case 2:
                //item type
                //name
                if (isset($_POST['name']) && !empty(trim($_POST['name']))) {

                    $name = trim($_POST['name']);

                    $sql2 = "SELECT type_name FROM item_types WHERE type_name = ?";

                    $stmt2 = $mysqli->prepare($sql2);
                    $stmt2->bind_param('s', $name);


                    if ($stmt2->execute()) {
                        $stmt2->store_result();

                        if ($stmt2->num_rows == 0) {

                            $sql = "INSERT INTO item_types (type_name) VALUES (?)";

                            $stmt = $mysqli->prepare($sql);
                            $stmt->bind_param('s', $name);


                            if ($stmt->execute()) {
                                echo "Succesfully created new item type";
                            } else {
                                echo "Something went wrong - exec";
                            }
                            $stmt->close();
                        } else {
                            echo "The is already item type with this name";
                        }
                    } else {
                        echo "Something went wrong - exec name";
                    }
                    $stmt2->free_result();
                    $stmt2->close();
                } else {
                    echo "Something went wrong - isset";
                }
                break;
            case 3:
                //class
                //name health inc str int dex end
                if (isset($_POST['name']) && isset($_POST['health']) && isset($_POST['inc']) && isset($_POST['str']) && isset($_POST['int']) && isset($_POST['dex']) && isset($_POST['end']) && !empty(trim($_POST['name']))) {

                    $name = trim($_POST['name']);
                    $health = $_POST['health'];
                    $inc = $_POST['inc'];
                    $str = $_POST['str'];
                    $int = $_POST['int'];
                    $dex = $_POST['dex'];
                    $end = $_POST['end'];

                    $sql2 = "SELECT class_name FROM classes WHERE class_name = ?";

                    $stmt2 = $mysqli->prepare($sql2);
                    $stmt2->bind_param('s', $name);


                    if ($stmt2->execute()) {
                        $stmt2->store_result();

                        if ($stmt2->num_rows == 0) {
                            $sql = "INSERT INTO classes (class_name,base_health,inc_health,base_strength,base_intelligence,base_dexterity,base_endurance) VALUES (?,?,?,?,?,?,?)";

                            $stmt = $mysqli->prepare($sql);
                            $stmt->bind_param('siiiiii', $name, $health, $inc, $str, $int, $dex, $end);


                            if ($stmt->execute()) {
                                echo "Succesfully created new class";
                            } else {
                                echo "Something went wrong - exec";
                            }
                            $stmt->close();
                        } else {
                            echo "The is already class with this name";
                        }
                    } else {
                        echo "Something went wrong - exec name";
                    }
                    $stmt2->free_result();
                    $stmt2->close();
                } else {
                    echo "Something went wrong - isset";
                }
                break;
        }
    } else {
        echo "Something went wrong - isset type";
    }
} else {
    echo "Something went wrong - post";
}
?>