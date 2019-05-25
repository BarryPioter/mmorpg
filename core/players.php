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
// TODO: better player managment and stats
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
            <?php if ($_SESSION['admin'] != 0)
                echo fill_players_table(1);
            else
                echo fill_players_table(2);
            ?>
        </div>
    </div>
    <div class="footer">Made by Piotr "Barry" Jadczuk</div>
</body>
</html>