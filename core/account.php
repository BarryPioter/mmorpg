<?php
/*
  That was made by
  _____    _____    _____    _____    _   _
  |  _  \  /  _  \  |  _  \  |  _  \  | | | |
  | |_|  | | |_| |  | |_|  | | |_|  | \ \_/ /
  |     /  |  _  |  |  _  /  |  _  /   \   /
  |  _  \  | | | |  | | \ \  | | \ \    | |
  | |_|  | | | | |  | | | |  | | | |    | |
  |_____/  |_| |_|  |_| |_|  |_| |_|    |_|

  2019 for Databases project
 */
// TODO: menu layout
ob_start();
session_start();

require_once '../lib/config.php';
require_once '../lib/functions.php';
?>
<html>

    <head>
        <title>MMORPG account managment system</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../lib/styles.css">
        <script src="../lib/scripts.js"></script>

    </head>
    <body onload="account(1)">
        <div class="menu">
            <ul>
                <li><a href="../home.php">Home</a></li>
                <li><a href="../core/players.php">Players</a></li>
                <li><a href="../core/game.php">Game elements</a></li>
                <li><a href="../core/reports.php">Reports</a></li>
                <li><a href="../core/bans.php">Bans</a></li>
                <li><b><a href="../core/account.php">My account</a></b></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </div>
        <?php checkTimeout("../index.php"); ?>
        <div class="vertical-menu">
            <ul>
                <li onclick="account(1)"><a href="#">Account data</a></li>
                <li onclick="account(2)"><a href="#" >Characters</a></li>
                <li onclick="account(3)"><a href="#" >Reports</a></li>
                <li><a href="report.php" >Report server</a></li>
                <li onclick="account(4)"><a href="#" >Bans</a></li>
            </ul>
        </div>
    </div> 
    <div class="content" style="margin-left: 200px;">
        <div id="acc1"><?php
            if (isset($_SESSION['id'])) {

                $sql = "SELECT player_id, login, email, creation_date, last_seen FROM players WHERE player_id =  ?;";

                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param('i', $_SESSION['id']);


                if ($stmt->execute()) {
                    $stmt->store_result();

                    if ($stmt->num_rows == 1) {
                        $stmt->bind_result($id, $login, $email, $creation, $last);
                        $stmt->fetch();

                        echo "<h2>" . $id . "</h2>";
                        echo "<h2>" . $login . "</h2>";
                        echo "<h2>" . $email . "</h2>";
                        echo "<h2>" . $creation . "</h2>";
                        echo "<h2>" . $last . "</h2>";
                    } else {
                        $err = "Bad player";
                    }
                } else {
                    $err = "Something went wrong";
                }
                $stmt->free_result();
                $stmt->close();
            } else {
                header("Location:../home.php");
            }
            ?></div>
        <div id="acc2"><?php
            if (isset($_SESSION['id'])) {
                $sql = "SELECT `character_id`, `name`,class_name, `health`, `lvl`, `exp`, `stat_points`, `money`, `strength`, `intelligence`, `dexterity`, `endurance` FROM `characters` INNER JOIN classes ON characters.class_id=classes.class_id  WHERE `player_id` = ?";

                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param('i', $_SESSION['id']);


                if ($stmt->execute()) {
                    $stmt->store_result();
                    if ($stmt->num_rows >= 0) {
                        $stmt->bind_result($cid, $name, $class, $hp, $lvl, $exp, $stats, $money, $str, $int, $dex, $end);
                        while ($stmt->fetch()) {
                            echo "<h4>" . $cid . "</h4>";
                            echo "<h4>" . $name . "</h4>";
                            echo "<h4>" . $class . "</h4>";
                            echo "<h4>" . $hp . "</h4>";
                            echo "<h4>" . $lvl . "</h4>";
                            echo "<h4>" . $exp . "</h4>";
                            echo "<h4>" . $stats . "</h4>";
                            echo "<h4>" . $money . "</h4>";
                            echo "<h4>" . $str . "</h4>";
                            echo "<h4>" . $int . "</h4>";
                            echo "<h4>" . $dex . "</h4>";
                            echo "<h4>" . $end . "</h4>";
                        }
                    } else {
                        $err = "Bad player";
                    }
                } else {
                    $err = "Something went wrong";
                }
                $stmt->free_result();

                $stmt->close();
            } else {
                header("Location:../home.php");
            }
            ?></div>
        <div id="acc3"><?php
            if (isset($_SESSION['id'])) {
                $sql = "SELECT r.report_id,p.login,pp.player_id,pp.login,r.content,r.report_date,s.status_name,r.admin_id,a.login FROM reports as r "
                        . "LEFT JOIN players AS pp ON r.player_id = pp.player_id "
                        . "INNER JOIN players AS p ON r.reporter_id = p.player_id "
                        . "INNER JOIN statuses AS s ON r.status_id = s.status_id "
                        . "LEFT JOIN players AS a ON r.admin_id = a.player_id "
                        . "WHERE r.reporter_id = ? ";

                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param('i', $_SESSION['id']);
                if ($stmt->execute()) {
                    $stmt->store_result();
                    if ($stmt->num_rows > 0) {
                        echo "<table class='players' align='center'>";
                        echo "<tr><th>ID</th><th>REPORTED</th><th>REPORTER</th><th>CONTENT</th><th>CREATION_DATE</th><th>STATUS</th><th>ADMIN</th></tr>";
                        $stmt->bind_result($id, $login, $pid2, $login2, $content, $date, $status,$aid,$admin);
                        while ($stmt->fetch()) {
                            echo "<tr><td>" . $id . "</td><td>" . $login . "</td>";
                            if ($pid2 == NULL)
                                echo "<td>GAME</td>";
                            else
                                echo "<td><a href='profile.php?id=" . $pid2 . "'>" . $login2 . "</a></td>";

                            echo "<td>" . $content . "</td><td>" . $date . "</td><td>" . $status . "</td><td>" . $admin . "</td></tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<h2>You have no reports!</h2>";
                    }
                } else {
                    $err = "Something went wrong";
                }
                $stmt->free_result();
                $stmt->close();
            } else {
                echo "Something went wrong";
            }
            ?></div>
        <div id="acc4"><?php
            if (isset($_SESSION['id'])) {
                $sql = "SELECT ban_reason,start_date,end_date from bans where player_id = ? and active";

                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param('i', $_SESSION['id']);
                if ($stmt->execute()) {
                    $stmt->store_result();
                    if ($stmt->num_rows > 0) {
                        $stmt->bind_result($reason, $s_date, $e_date);
                        echo "<ul>";
                        while ($stmt->fetch()) {
                            echo "<li>" . $reason . " " . $s_date . " " . $e_date . "</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<h2>You have no bans!</h2>";
                    }
                } else {
                    $err = "Something went wrong";
                }
                $stmt->free_result();
                $stmt->close();
            } else {
                echo "Something went wrong";
            }
            ?></div>






    </div>
    <div class="footer">Made by Piotr "Barry" Jadczuk</div>
</body>
</html>