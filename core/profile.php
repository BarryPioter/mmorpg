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
// TODO: better profile preview
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
    </head>
    <body>
    <div class="menu">
        <ul>
                <li><b><a href="../home.php">Home</a></b></li>
                <li><a href="../game/characters.php">Characters</a></li>
                <li><a href="../game/shop.php">Shop</a></li>
                <li><a href="../game/enchant.php">Enchant</a></li>
                <li><a href="../game/pvp.php">PVP</a></li>
                <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) { ?><li><a href="../core/admin.php">Admin panel</a></li><?php } ?>
                <li><a href="../core/account.php">My account</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
    </div>
       <?php checkTimeout("../index.php"); ?>

        <div class="content">
            <?php
            if (isset($_GET['id'])) {

                $sql = "SELECT player_id, login, email, creation_date, last_seen FROM players WHERE player_id =  ?;";

                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param('i', $_GET['id']);


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
                $sql = "SELECT `character_id`, `name`,class_name, `health`, `lvl`, `exp`, `stat_points`, `money`, `strength`, `intelligence`, `dexterity`, `endurance` FROM `characters` INNER JOIN classes ON characters.class_id=classes.class_id  WHERE `player_id` = ?";

                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param('i', $_GET['id']);


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
                header("Location:home.php");
            }
            ?>
        </div>
        <div class="footer">Made by Piotr "Barry" Jadczuk</div>
    </body>
</html>