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
                $err = "";

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST['email']) && !empty(trim($_POST['email'])) && !empty(trim($_POST['password'])) && !empty(trim($_POST['login']))) {

                        $login = trim($_POST['login']);
                        $email = trim($_POST['email']);

                        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $password = md5(trim($_POST['password']));

                            $sql = "SELECT login FROM players WHERE login = ?";

                            $stmt = $mysqli->prepare($sql);
                            $stmt->bind_param('s', $login);


                            if ($stmt->execute()) {
                                $stmt->store_result();

                                if ($stmt->num_rows == 0) {

                                    $sql2 = "insert into players(login,email,password) values (?,?,?)";

                                    $stmt2 = $mysqli->prepare($sql2);
                                    $stmt2->bind_param('sss', $login, $email, $password);


                                    if ($stmt2->execute()) {
                                        echo "Succesfully created account. You'll be moved to login page.";
                                        header("refresh:3;url=index.php");
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
                            $err = "Write proper email";
                        }
                    } else {
                        $err = "Something went wrong - fields";
                    }
                } else {
                    $err = "Something went wrong - isset";
                }
                ?>
            </div> <!-- /container -->




            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h4><?php echo $err; ?></h4>
                <input type = "text" name = "login" placeholder = "login = player1234" required autofocus></br><br>
                <input type = "text" name = "email" placeholder = "email = test@test.test" required></br><br>
                <input type = "password" name = "password" placeholder = "password = 1234" required><br><br>
                <button type = "submit" name = "register">Register</button>
            </form>
            <a href='index.php'><button>Login</button></a>

        </div> 
    </div>
    <div class="footer">Made by Piotr "Barry" Jadczuk</div>
</body>
</html>