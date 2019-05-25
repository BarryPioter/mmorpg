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
// TODO: admin panel things
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
                <li><a href="../home.php">Home</a></li>
                <li><a href="../game/characters.php">Characters</a></li>
                <li><a href="../game/shop.php">Shop</a></li>
                <li><a href="../game/enchant.php">Enchant</a></li>
                <li><a href="../core/players.php">Players</a></li>
                <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) { ?><li><a href="../core/admin.php">Admin panel</a></li><?php } ?>
                <li style="float: right;"><a href="../logout.php">Logout</a></li>
                <li style="float: right;"><a href="../core/account.php">My account</a></li>

            </ul>
        </div>
        <?php
        $err = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['id']) && !empty(trim($_POST['id'])) && !empty(trim($_POST['reason']))) {

                $id = trim($_POST['id']);
                $reason = trim($_POST['reason']);
                $pid = $_SESSION['id'];
                $sql = '';
                if ($id == -1) {
                    $sql = "INSERT INTO `reports` (`reporter_id`, `content`, `report_date`, `status_id`) VALUES (?, ?, CURRENT_TIMESTAMP, '4')";
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param('is', $pid, $reason);
                } else {
                    $sql = "INSERT INTO `reports` (`player_id`, `reporter_id`, `content`, `report_date`, `status_id`) VALUES (?, ?, ?, CURRENT_TIMESTAMP, '4')";
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param('iis', $id, $pid, $reason);
                }
                if ($stmt->execute()) {
                    $err = "Succesfully created report. You can see your report in My Account tab.";
                } else {
                    $err = "Something went wrong - insert";
                }
                $stmt->free_result();
                $stmt->close();
            } else {
                $err = "Something went wrong - fields";
            }
        }
        ?>
        <?php checkTimeout("../index.php"); ?>
        <div class="content">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h4><?php echo $err; ?></h4><br>
                <?php if (isset($_GET['id'])) { ?>
                    <input type = "text" name = "login" value="<?php echo get_login($_GET['id']); ?>" required readonly></br><br>
                    <input type = "text" name = "id" value="<?php echo $_GET['id'] ?>" required hidden>
                <?php } else {
                    ?>
                    <input type = "text" name = "login" value="SERVER" required readonly></br><br>
                    <input type = "text" name = "id" value="-1" required hidden></br><br>
                <?php }
                ?>
                <textarea name="reason" rows="10" cols="30" placeholder = "reason = cheating" required></textarea></br><br>
                <button type = "submit" name = "report">REPORT</button>
            </form>
        </div>
        <div class="footer">Made by Piotr "Barry" Jadczuk</div>
    </body>
</html>