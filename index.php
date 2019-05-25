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
?>
<html>

    <head>
        <title>MMORPG account managment system</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="lib/styles.css">
    </head>
    <body>
        <div class="content">
            <h2>Enter Username and Password</h2> 
            <div class = "container form-signin">


                <?php
                if (isset($_GET['message'])) {
                    echo "<script>alert('" . $_GET["message"] . "!');</script>";
                }

                $err = "";

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST['email']) && !empty(trim($_POST['email'])) && !empty(trim($_POST['password']))) {

                        $email = trim($_POST['email']);
                        $password = md5(trim($_POST['password']));

                        $sql = "SELECT p.player_id, p.login, a.admin_id FROM players as p LEFT JOIN admins AS a ON p.player_id = a.player_id WHERE p.email = ? and p.password = ?";

                        $stmt = $mysqli->prepare($sql);
                        $stmt->bind_param('ss', $email, $password);


                        if ($stmt->execute()) {
                            $stmt->store_result();

                            if ($stmt->num_rows == 1) {
                                $stmt->bind_result($id, $login, $admin);
                                $stmt->fetch();
                                $_SESSION['id'] = $id;
                                if (checkBan()) {
                                    $_SESSION['loggedAt'] = time();
                                    $_SESSION['login'] = $login;
                                    checkAdmin();
                                    lastSeen();
                                    header("Location:home.php");
                                } else {
                                    header("Location:core/banned.php");
                                }
                            } else {
                                $err = "Bad email or password";
                            }
                        } else {
                            $err = "Something went wrong";
                        }
                        $stmt->free_result();
                        $stmt->close();
                    }
                }
                ?>
            </div> <!-- /container -->



            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h4><?php echo $err; ?></h4>
                <input type = "text" name = "email" placeholder = "email = test@test.test" required autofocus></br>
                <input type = "password" name = "password" placeholder = "password = 1234" required><br>
                <button type = "submit" name = "login">Login</button>
            </form>
            <a href='register.php'><button>Register</button></a>
        </div> 
    </div>
    <div class="footer">Made by Piotr "Barry" Jadczuk</div>
</body>
</html>