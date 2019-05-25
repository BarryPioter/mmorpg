<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id']) && isset($_POST['charid']) && $_POST['charid'] != '') {

        switch ($_POST['mode']) {
            case "PLAY":
                echo addExp($_POST['id'], $_POST['charid']);
                echo checkLvl($_POST['id'], $_POST['charid']);
                break;
            case "EARN":
                echo addMoney($_POST['id'], $_POST['charid']);
                break;
        }
    } else
        echo "Something went wrong isset";
} else
    echo "Something went wrong post";

function addExp($id, $charid) {
    require '../lib/config.php';


    $sql = "UPDATE characters SET exp = exp + ? WHERE character_id = ? AND player_id = ?";

    $exp = rand(1, 500);

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('iii', $exp, $charid, $id);


    if ($stmt->execute()) {
        return "Earned $exp EXP";
    } else {
        return "Something went wrong";
    }
    $stmt->close();
}

function addMoney($id, $charid) {
    require '../lib/config.php';


    $sql = "UPDATE characters SET money = money + ? WHERE character_id = ? AND player_id = ?";

    $exp = rand(1, 1000);

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('iii', $exp, $charid, $id);


    if ($stmt->execute()) {
        return "Earned $exp money";
    } else {
        return "Something went wrong";
    }
    $stmt->close();
}

function checkLvl($id, $charid) {
    require '../lib/config.php';

    $sql = "SELECT exp,lvl FROM characters WHERE character_id = ? AND player_id = ?;";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ii', $charid, $id);


    if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($exp, $lvl);
            $stmt->fetch();
            $tmpl = $lvl;
            $tmpx = $exp;
            $tmps = 0;
            //echo $lvl;
            //echo "EXP to next ".(50 + ($tmpl - 1) * 2);
            //echo "exp ".$tmpx;
            if (($lvl == 1 && $tmpx >= 50) || $lvl > 1) {
                while ((50 * ($tmpl - 1) * 2) <= $tmpx) {

                    if ($tmpl == 1) {
                        //echo $tmpx." = !".$tmpl."|";
                        $tmpx = $tmpx - 50;
                        $tmps++;
                    } else {
                        //echo $tmpx." = ?".$tmpl."|";
                        $tmpx = $tmpx - (50 * ($tmpl - 1) * 2);
                        $tmps++;
                    }
                    //echo $tmpx." <<< ";
                    $tmpl++;
                }
            }
            if ($tmpl != $lvl) {
                $sql2 = "UPDATE characters SET exp = ?, lvl = ?,stat_points = stat_points + ? WHERE character_id = ? AND player_id = ?";

                $stmt2 = $mysqli->prepare($sql2);
                $stmt2->bind_param('iiiii', $tmpx, $tmpl, $tmps, $charid, $id);


                if ($stmt2->execute()) {
                    return " Lvl up to " . $tmpl . ". Earned $tmps stat points.";
                } else {
                    return "Something went wrong";
                }
                $stmt2->close();
            }
            
        } else {
            return "Something went wrong";
        }
    } else {
        return "Something went wrong";
    }
    $stmt->free_result();
    $stmt->close();
}
