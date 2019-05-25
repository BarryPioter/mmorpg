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

session_start();
unset($_SESSION["id"]);
unset($_SESSION["login"]);
unset($_SESSION["loggedAt"]);
unset($_SESSION['admin']);
unset($_SESSION['remove']);
unset($_SESSION['edit']);
unset($_SESSION['create']);
unset($_SESSION['check']);
unset($_SESSION['promote']);
session_destroy();
header("Location:index.php");
?>