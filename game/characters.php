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
    <?php
    $err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['login']) && !empty(trim($_POST['login']))) {

            $login = trim($_POST['login']);
            $class = $_POST['classid'];

            $sql = "SELECT name FROM characters WHERE name = ?";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param('s', $login);


            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 0) {

                    $sql2 = "insert into characters(name,player_id,class_id,health,strength,intelligence,dexterity,endurance) values (?,?,?,(SELECT base_health FROM classes WHERE class_id = ?),(SELECT base_strength FROM classes WHERE class_id = ?),(SELECT base_intelligence FROM classes WHERE class_id = ?),(SELECT base_dexterity FROM classes WHERE class_id = ?),(SELECT base_endurance FROM classes WHERE class_id = ?))";

                    $stmt2 = $mysqli->prepare($sql2);
                    $stmt2->bind_param('siiiiiii', $login, $_SESSION['id'], $class, $class, $class, $class, $class, $class);

                    if ($stmt2->execute()) {
                        echo "Succesfully created character.";
                        header("refresh:3;url=characters.php");
                    } else {
                        $err = "Something went wrong - insert";
                    }
                    $stmt2->close();
                } else {
                    $err = "Login is taken";
                }
            } else {
                $err = "Something went wrong - select";
            }
            $stmt->free_result();
            $stmt->close();
        } else {
            $err = "Something went wrong - fields";
        }
    }
    ?>
    <head>
        <title>MMORPG account managment system</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../lib/styles.css">
        <script src="../lib/scripts.js"></script>   
    </head>
    <body onload="characters(1)">
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
            <ul>
                <li onclick="characters(1)"><a href="#">New character</a></li>
                <li onclick="characters(2)"><a href="#" >My characters</a></li>
            </ul>
        </div>
    </div> 
    <div class="content" style="margin-left: 200px;">
        <div id="chars1"><form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h4><?php echo $err; ?></h4>
                <input type = "text" name = "login" placeholder = "login = test" required autofocus><br><br>
                <select id ='classid' name='classid'>
                    <?php echo showclass(); ?>
                </select><br><br>
                <button type = "submit" name = "submit">Create character</button>
            </form></div>
        <div id="chars2"><br><select id ='charid' name='charid' onchange="showchar(2, '../');showEq(2)">
                <option value=''>Select character</option>
                <?php echo fill_characters(); ?>
            </select>
            <div id="charinfo">

            </div>
            <div id="cerr">

            </div>
            <div id="eq">

            </div>

        </div>
    </div>
    <div class="footer">Made by Piotr "Barry" Jadczuk</div>
</body>
</html>