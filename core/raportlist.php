<?php

require_once '../lib/config.php';
require_once '../lib/functions.php';
//get the q parameter from URL
if (isset($_GET['t']) && isset($_GET['m']) && isset($_GET['d'])) {
    $t = $_GET["t"]; //1 - reports, 2 - bans, 3 - players, 4 - classes, 5 - items
    $m = $_GET["m"]; //depend on $t
    $d = $_GET["d"]; //1 - day, 2 - month, 3 - year, 4 - all
    switch ($t) {
        case 1:
            $sql = "";
            //1 - day, 2 - reporter, 3 - reported, 4 - admin

            switch ($m) {
                case 1:
                    $sql = "SELECT count(`report_id`),date(report_date),ROUND((Count(report_id)* 100 / (Select Count(*) From reports)),2) FROM `reports` ";
                    $sql .= setDuration($d);

                    $sql .= "group by date(report_date)";
                    break;
                case 2:
                    $sql = "SELECT count(`report_id`),reporter_id,ROUND((Count(report_id)* 100 / (Select Count(*) From reports)),2) FROM `reports` ";
                    $sql .= setDuration($d);
                    $sql .= "group by reporter_id";
                    break;
                case 3:
                    $sql = "SELECT count(`report_id`),player_id,ROUND((Count(report_id)* 100 / (Select Count(*) From reports)),2) FROM `reports` ";
                    $sql .= setDuration($d);
                    $sql .= "group by player_id";
                    break;
                case 4:
                    $sql = "SELECT count(`report_id`),admin_id,ROUND((Count(report_id)* 100 / (Select Count(*) From reports)),2) FROM `reports` ";
                    $sql .= setDuration($d);
                    $sql .= "group by admin_id";
                    break;
            }

            //<a href='profile.php?id=" . $id . "'>" . $login . "</a>

            $sql .= "order by 3 desc;";

            $sql2 = "SELECT count(`report_id`) FROM `reports` ";
            $sql2 .= setDuration($d);
            $sql2 .= ";";

            $stmt2 = $mysqli->prepare($sql2);

            if ($stmt2->execute()) {
                $stmt2->store_result();
                if ($stmt2->num_rows > 0) {
                    $stmt2->bind_result($amm);
                    $stmt2->fetch();
                    echo "<h3>Data in scope: " . $amm . "</h3>";
                } else {
                    echo "No data in scope";
                }
            } else {
                echo "Something went wrong";
            }
            $stmt2->free_result();

            $stmt2->close();

            $stmt = $mysqli->prepare($sql);

            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($id, $value, $percent);
                    echo "<table class='raport' align='center'>";
                    echo '<tr><th>COUNT</th><th>VALUE</th><th>PERCENTAGE</th></tr>';
                    while ($stmt->fetch()) {
                        echo '<tr><td>' . $id . '</td><td>' . $value . '</td><td>' . $percent . '%</td></tr>';
                    }
                    echo "</table>";
                } else {
                    echo "No data in scope";
                }
            } else {
                echo "Something went wrong";
            }
            $stmt->free_result();

            $stmt->close();

            break;
        case 2:
            $sql = "";
            //1 - day, 2 - reporter, 3 - reported, 4 - admin

            switch ($m) {
                case 1:
                    $sql = "SELECT count(`ban_id`),date(start_date),ROUND((Count(ban_id)* 100 / (Select Count(*) From bans)),2) FROM `bans` ";
                    $sql .= setDuration2($d);

                    $sql .= "group by date(start_date) ";
                    break;
                case 2:
                    $sql = "SELECT count(`ban_id`),date(end_date),ROUND((Count(ban_id)* 100 / (Select Count(*) From bans)),2) FROM `bans` ";
                    $sql .= setDuration2($d);
                    $sql .= "group by date(end_date) ";
                    break;
                case 3:
                    $sql = "SELECT count(`ban_id`),ban_reason,ROUND((Count(ban_id)* 100 / (Select Count(*) From bans)),2) FROM `bans` ";
                    $sql .= setDuration2($d);
                    $sql .= "group by ban_reason ";
                    break;
                case 4:
                    $sql = "SELECT count(`ban_id`),player_id,ROUND((Count(ban_id)* 100 / (Select Count(*) From bans)),2) FROM `bans` ";
                    $sql .= setDuration2($d);
                    $sql .= "group by player_id ";
                    break;
                case 5:
                    $sql = "SELECT count(`ban_id`),admin_id,ROUND((Count(ban_id)* 100 / (Select Count(*) From bans)),2) FROM `bans` ";
                    $sql .= setDuration2($d);
                    $sql .= "group by admin_id ";
                    break;
            }

            //<a href='profile.php?id=" . $id . "'>" . $login . "</a>

            $sql .= "order by 3 desc;";

            $sql2 = "SELECT count(`ban_id`) FROM `bans` ";
            $sql2 .= setDuration2($d);
            $sql2 .= ";";

            $stmt2 = $mysqli->prepare($sql2);

            if ($stmt2->execute()) {
                $stmt2->store_result();
                if ($stmt2->num_rows > 0) {
                    $stmt2->bind_result($amm);
                    $stmt2->fetch();
                    echo "<h3>Data in scope: " . $amm . "</h3>";
                } else {
                    echo "No data in scope";
                }
            } else {
                echo "Something went wrong";
            }
            $stmt2->free_result();

            $stmt2->close();

            $stmt = $mysqli->prepare($sql);

            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($id, $value, $percent);
                    echo "<table class='raport' align='center'>";
                    echo '<tr><th>COUNT</th><th>VALUE</th><th>PERCENTAGE</th></tr>';
                    while ($stmt->fetch()) {
                        echo '<tr><td>' . $id . '</td><td>' . $value . '</td><td>' . $percent . '%</td></tr>';
                    }
                    echo "</table>";
                } else {
                    echo "No data in scope";
                }
            } else {
                echo "Something went wrong";
            }
            $stmt->free_result();

            $stmt->close();

            break;
        case 3:
            $sql = "";
            //1 - day, 2 - reporter, 3 - reported, 4 - admin

            switch ($m) {
                case 1:
                    $sql = "SELECT count(`player_id`),date(creation_date),ROUND((Count(player_id)* 100 / (Select Count(*) From players)),2) FROM `players` ";
                    $sql .= setDuration3($d);

                    $sql .= "group by date(creation_date) ";
                    break;
                case 2:
                    $sql = "SELECT count(`player_id`),date(last_seen),ROUND((Count(player_id)* 100 / (Select Count(*) From players)),2) FROM `players` ";
                    $sql .= setDuration3($d);
                    $sql .= "group by date(last_seen) ";
                    break;
                case 3:
                    $sql = "SELECT count(`character_id`),player_id,ROUND((Count(player_id)* 100 / (Select Count(*) From characters)),2) FROM `characters` ";
                    //$sql .= setDuration3($d);
                    $sql .= "group by player_id ";
                    break;
                case 4:
                    $sql = "SELECT ROUND(avg(`lvl`),2),player_id,ROUND((avg(`lvl`)* 100 / (Select avg(`lvl`) From characters)),2) FROM `characters` ";
                    //$sql .= setDuration3($d);
                    $sql .= "group by player_id ";
                    break;
                case 5:
                    $sql = "SELECT ROUND(avg(`money`),2),player_id,ROUND((avg(`money`)* 100 / (Select avg(`money`) From characters)),2) FROM `characters` ";
                    //$sql .= setDuration3($d);
                    $sql .= "group by player_id ";
                    break;
            }

            //<a href='profile.php?id=" . $id . "'>" . $login . "</a>

            $sql .= "order by 3 desc;";

            $sql2 = "SELECT count(`player_id`) FROM `players` ";
            $sql2 .= setDuration3($d);
            $sql2 .= ";";

            $stmt2 = $mysqli->prepare($sql2);

            if ($stmt2->execute()) {
                $stmt2->store_result();
                if ($stmt2->num_rows > 0) {
                    $stmt2->bind_result($amm);
                    $stmt2->fetch();
                    echo "<h3>Data in scope: " . $amm . "</h3>";
                } else {
                    echo "No data in scope";
                }
            } else {
                echo "Something went wrong";
            }
            $stmt2->free_result();

            $stmt2->close();

            $stmt = $mysqli->prepare($sql);

            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($id, $value, $percent);
                    echo "<table class='raport' align='center'>";
                    echo '<tr><th>COUNT</th><th>VALUE</th><th>PERCENTAGE</th></tr>';
                    while ($stmt->fetch()) {
                        echo '<tr><td>' . $id . '</td><td>' . $value . '</td><td>' . $percent . '%</td></tr>';
                    }
                    echo "</table>";
                } else {
                    echo "No data in scope";
                }
            } else {
                echo "Something went wrong";
            }
            $stmt->free_result();

            $stmt->close();

            break;
        case 4:
            $sql = "";
            //1 - day, 2 - reporter, 3 - reported, 4 - admin

            switch ($m) {
                case 1:
                    $sql = "SELECT count(`character_id`),class_id,ROUND((Count(character_id)* 100 / (Select Count(*) From characters)),2) FROM `characters` ";
                    //$sql .= setDuration2($d);

                    $sql .= "group by class_id ";
                    break;
                case 2:
                    $sql = "SELECT ROUND(avg(`lvl`),2),class_id,ROUND((avg(`lvl`)* 100 / (Select avg(`lvl`) From characters)),2) FROM `characters` ";
                    //$sql .= setDuration2($d);

                    $sql .= "group by class_id ";
                    break;
                case 3:
                    $sql = "SELECT ROUND(avg(`money`),2),class_id,ROUND((avg(`money`)* 100 / (Select avg(`money`) From characters)),2) FROM `characters` ";
                    //$sql .= setDuration2($d);

                    $sql .= "group by class_id ";
                    break;
                case 4:
                    $sql = "SELECT ROUND(avg(equipments.quantity),2),characters.class_id,ROUND((Count(equipments.quantity)* 100 / (Select Count(*) From equipments)),2) FROM characters INNER JOIN equipments ON characters.character_id=equipments.character_id ";
                    //$sql .= setDuration2($d);

                    $sql .= "group by class_id ";
                    break;
                case 5:
                    $sql = "SELECT max(equipments.lvl),characters.class_id,ROUND((Count(equipments.lvl)* 100 / (Select Count(*) From equipments)),2) FROM characters INNER JOIN equipments ON characters.character_id=equipments.character_id ";
                    //$sql .= setDuration2($d);

                    $sql .= "group by class_id ";
                    break;
            }

            //<a href='profile.php?id=" . $id . "'>" . $login . "</a>

            $sql .= "order by 3 desc;
                        ";

            $sql2 = "SELECT count(`class_id`) FROM `characters` ";
            $sql2 .= ";
                        ";

            $stmt2 = $mysqli->prepare($sql2);

            if ($stmt2->execute()) {
                $stmt2->store_result();
                if ($stmt2->num_rows > 0) {
                    $stmt2->bind_result($amm);
                    $stmt2->fetch();
                    echo "<h3>Data in scope: " . $amm . "</h3>";
                } else {
                    echo "No data in scope";
                }
            } else {
                echo "Something went wrong";
            }
            $stmt2->free_result();

            $stmt2->close();

            $stmt = $mysqli->prepare($sql);

            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($id, $value, $percent);
                    echo "<table class = 'raport' align = 'center'>";
                    echo '<tr><th>DATA 1</th><th>DATA 2</th><th>PERCENTAGE</th></tr>';
                    while ($stmt->fetch()) {
                        echo '<tr><td>' . $id . '</td><td>' . $value . '</td><td>' . $percent . '%</td></tr>';
                    }
                    echo "</table>";
                } else {
                    echo "No data in scope";
                }
            } else {
                echo "Something went wrong";
            }
            $stmt->free_result();

            $stmt->close();

            break;
    }
} else {
    echo "Something went wrong";
}
?> 