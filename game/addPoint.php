<?php

require '../lib/config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['charid']) && isset($_GET['stat']) && $_GET['charid'] != '') {

        $charid = $_GET['charid'];
        $stat = $_GET['stat'];
        switch ($stat) {
            case 1:
                /*`stat_points`, `money`, `strength`, `intelligence`, `dexterity`, `endurance`*/
                $sql = "UPDATE characters SET strength = strength + 1, stat_points = stat_points - 1 WHERE character_id = ?";
                break;
            case 2:
                $sql = "UPDATE characters SET intelligence = intelligence + 1, stat_points = stat_points - 1 WHERE character_id = ?";
                break;
            case 3:
                $sql = "UPDATE characters SET dexterity = dexterity + 1, stat_points = stat_points - 1 WHERE character_id = ?";
                break;
            case 4:
                $sql = "UPDATE characters SET endurance = endurance + 1, stat_points = stat_points - 1 WHERE character_id = ?";
                break;
        }

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $charid);


        if ($stmt->execute()) {
            return "Added 1 point to stats";
        } else {
            return "Something went wrong";
        }
        $stmt->close();
    } else
        echo "Something went wrong isset";
} else
    echo "Something went wrong post";
?>