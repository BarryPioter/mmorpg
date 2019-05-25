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

require_once 'lib/config.php';
require_once 'lib/functions.php';
print_r($_SESSION);
?>
<html>

    <head>
        <title>MMORPG account managment system</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="lib/styles.css">
        <script src="lib/scripts.js"></script>   

    </head>
    <body>
        <div class="menu">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="game/characters.php">Characters</a></li>
                <li><a href="game/shop.php">Shop</a></li>
                <li><a href="game/enchant.php">Enchant</a></li>
                <li><a href="core/players.php">Players</a></li>
                <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] != 0) { ?><li><a href="core/admin.php">Admin panel</a></li><?php } ?>
                <li><a href="core/account.php">My account</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
        <?php
        if (checkTimeout()) {
            logout("index.php", 1);
        }
        ?>

        <div class="vertical-menu">
            <ul><li>

                    <form id='char' onsubmit="return false">
                        <br><select id ='charid' name='charid' onchange="showchar(0, '')">
                            <option value=''>Select character</option>
                            <?php echo fill_characters(); ?>
                        </select>
                        <br><br>

                        <input type="number" name="id" value="<?php echo $_SESSION['id'] ?>" hidden>

                        <input id='play' type='submit' name = 'mode'    value = 'PLAY' onclick="submitGame('PLAY')"><br><br>
                        <input id='earn' type='submit' name = 'mode'    value = 'EARN' onclick="submitGame('EARN')"></form></li><br></ul></div>
        <div class="content" style="margin-left: 200px;">
            <div id='help'></div>
            <br><br>
            <div id="charinfo"></div>
            <p id="gameOut"></p>

        </div>
        <div class="footer">Made by Piotr "Barry" Jadczuk</div>
    </body>
</html>