<?php

require_once '../lib/config.php';
//get the q parameter from URL
if (isset($_GET['id']) && isset($_GET['t'])) {
    $id = $_GET["id"];

    $sql = "SELECT cs.name,c.class_name,cs.health,cs.lvl,cs.exp,cs.money,cs.strength,cs.intelligence,cs.dexterity,cs.endurance,cs.stat_points FROM characters cs INNER JOIN classes c on cs.class_id=c.class_id WHERE cs.character_id = ?";


    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param('i', $id);

    $output = "";
    if ($stmt->execute()) {
        $stmt->store_result();
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($name, $class, $health, $lvl, $exp, $money, $str, $int, $dex, $end, $stat);

            $output .= "<table class='shop' align='center'>";
            if ($_GET['t'] == 2) {
                $output .= '<tr><th>NAME</th><th>CLASS</th><th>HEALTH</th><th>LVL</th><th>EXP</th><th>MONEY</th><th>STRENGTH</th><th>INTELLIGENCE</th><th>DEXTERITY</th><th>ENDURANCE</th><th>STAT POINTS</th></tr>';
                while ($stmt->fetch()) {
                    $tmpx = 0;
                    if ($lvl == 1) {
                        $tmpx = 50;
                    } else {
                        $tmpx = (50 * ($lvl - 1) * 2);
                    }
                    $output .= '<tr><td>' . $name . '</td><td>' . $class . '</td><td>' . $health . '</td><td>' . $lvl . '</td><td>' . $exp . '/' . $tmpx . '</td><td>' . $money . '</td><td>' . $str . '</td><td>' . $int . '</td><td>' . $dex . '</td><td>' . $end . '</td><td>' . $stat . '</td></tr>';
                    if ($stat > 0) {
                        $output .= '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td><button onclick="addStat(1)">+</button></td><td><button onclick="addStat(2)">+</button></td><td><button onclick="addStat(3)">+</button></td><td><button onclick="addStat(4)">+</button></td><td></td></tr>';
                    } else {
                        $output .= '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td><button onclick="addStat(1)" disabled>+</button></td><td><button onclick="addStat(2)" disabled>+</button></td><td><button onclick="addStat(3)" disabled>+</button></td><td><button onclick="addStat(4)" disabled>+</button></td><td></td></tr>';
                    }
                }
            } else {
                $output .= '<tr><th>NAME</th><th>CLASS</th><th>HEALTH</th><th>LVL</th><th>EXP</th><th>MONEY</th></tr>';
                while ($stmt->fetch()) {
                    $tmpx = 0;
                    if ($lvl == 1) {
                        $tmpx = 50;
                    } else {
                        $tmpx = (50 * ($lvl - 1) * 2);
                    }
                    $output .= '<tr><td>' . $name . '</td><td>' . $class . '</td><td>' . $health . '</td><td>' . $lvl . '</td><td>' . $exp . '/' . $tmpx . '</td><td>' . $money . '</td></tr>';
                }
            }

            $output .= "</table>";
            echo $output;
        } else {
            $output = "No character selected";
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