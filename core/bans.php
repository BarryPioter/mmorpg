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
// TODO: report managment, report stats
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
    <body onload="showBans(1<?php
    if (isset($_GET['id'])) {
        echo "," . $_GET['id'];
    } else {
        echo ",0";
    }
    ?>)">
        <div class="menu">
            <ul>
                <li><a href="../home.php">Home</a></li>
                <li><a href="../game/characters.php">Characters</a></li>
                <li><a href="../game/shop.php">Shop</a></li>
                <li><a href="../game/enchant.php">Enchant</a></li>
                <li><a href="../game/pvp.php">PVP</a></li>
                <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) { ?><li><a href="../core/admin.php">Admin panel</a></li><?php } ?>
                <li style="float: right;"><a href="../logout.php">Logout</a></li>
                <li style="float: right;"><a href="../core/account.php">My account</a></li>
            </ul>
        </div>
        <?php checkTimeout("../index.php"); ?>
        <div class="vertical-menu" style="margin-top: 0;">
            <ul>
                <li><a href="#" onclick="showBans(1,0)">NEW BAN</a></li>
                <li><a href="#" onclick="showBans(2,0)">ACTIVE</a></li>
                <li><a href="#" onclick="showBans(3,0)">ENDED</a></li>
                <?php if (checkPermision(5)) { ?>
                    <li onclick="showBans(4,0)"><a href="#" onclick="">ALL BANS</a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="content" style="margin-left: 200px;">
            <div id="bans"></div>
            <div id="baninfo"></div>
        </div>
        <div class="footer">Made by Piotr "Barry" Jadczuk</div>
    </body>
</html>