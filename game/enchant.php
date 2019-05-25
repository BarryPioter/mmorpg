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
        <div class="vertical-menu">
            <ul><br><br><li><select id ='charid' name='charid' style="float:left;margin-left: 50px;" onchange="showchar();showEq(1)">
                        <option value=''>Select character</option>
                        <?php echo fill_characters(); ?>
                    </select></li><br><br><br></ul></div>
        <div class="content" style="margin-left: 200px;">
            <BR><BR>
            <div id="charinfo"></div>

            <div id="shop"></div>
            <div id="info"></div>
        </div>
        <div class="footer">Made by Piotr "Barry" Jadczuk</div>
    </body>
</html>