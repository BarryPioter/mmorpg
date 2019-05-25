<?php

session_start();

require '../lib/config.php';
require '../lib/functions.php';
$err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['player']) && isset($_POST['reason']) && isset($_POST['end_date']) && !empty(trim($_POST['reason']))) {


        $player = $_POST['player'];
        $reason = trim($_POST['reason']);
        $date = $_POST['end_date'];

        $sql = "INSERT INTO bans (player_id,ban_reason,end_date,admin_id) VALUES (?,?,?,?)";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('issi', $player, $reason, $date, $_SESSION['admin']);


        if ($stmt->execute()) {
            echo "Succesfully created new ban";
        } else {
            echo "Something went wrong - exec";
        }
        $stmt->close();
    } else {
        $err = "Something went wrong - isset";
    }
} else {
    $err = "Something went wrong - post";
}
?>