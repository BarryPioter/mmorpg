<?php

session_start();

require '../lib/config.php';
require '../lib/functions.php';

if (isset($_GET['t'])) {
    $x = $_GET["t"];

$sql = '';
switch ($x) {
    case 1:
        $sql = "SELECT r.report_id,p.player_id,p.login,pp.player_id,pp.login,r.content,r.report_date,r.status_id,s.status_name FROM reports as r "
                . "LEFT JOIN players AS p ON r.player_id = p.player_id "
                . "INNER JOIN players AS pp ON r.reporter_id = pp.player_id "
                . "INNER JOIN statuses AS s ON r.status_id = s.status_id "
                . "WHERE r.status_id = 4";
        break;
    case 2:
        $sql = "SELECT r.report_id,p.player_id,p.login,pp.player_id,pp.login,r.content,r.report_date,r.status_id,s.status_name FROM reports as r "
                . "LEFT JOIN players AS p ON r.player_id = p.player_id "
                . "INNER JOIN players AS pp ON r.reporter_id = pp.player_id "
                . "INNER JOIN statuses AS s ON r.status_id = s.status_id "
                . "WHERE r.status_id = 3 AND r.admin_id = ? ";
        break;
    case 3:
        $sql = "SELECT r.report_id,p.player_id,p.login,pp.player_id,pp.login,r.content,r.report_date,r.status_id,s.status_name FROM reports as r "
                . "LEFT JOIN players AS p ON r.player_id = p.player_id "
                . "INNER JOIN players AS pp ON r.reporter_id = pp.player_id "
                . "INNER JOIN statuses AS s ON r.status_id = s.status_id "
                . "WHERE (r.status_id = 1 OR r.status_id = 2) AND r.admin_id = ? ";
        break;
    case 4:
        $sql = "SELECT r.report_id,p.player_id,p.login,pp.player_id,pp.login,r.content,r.report_date,r.status_id,s.status_name FROM reports as r "
                . "LEFT JOIN players AS p ON r.player_id = p.player_id "
                . "INNER JOIN players AS pp ON r.reporter_id = pp.player_id "
                . "INNER JOIN statuses AS s ON r.status_id = s.status_id "
                . "ORDER BY s.status_name DESC";
        break;
}

if ($stmt = $mysqli->prepare($sql)) {
    if ($x == 2 or $x == 3) {
        $stmt->bind_param('i', $_SESSION['admin']);
    }
    if ($stmt->execute()) {
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $pid1, $login, $pid2, $login2, $content, $date, $statusid, $status);
            echo "<table class='players' align='center'>";
            echo "<tr><th>ID</th><th>REPORTED</th><th>REPORTER</th><th>CREATION_DATE</th><th>CONTENT</th><th>STATUS</th><th></th></tr>";
            while ($stmt->fetch()) {
                echo "<tr><td>$id</td><td><a href='profile.php?id=$pid1'>$login</a></td><td><a href='profile.php?id=$pid2'>$login2</a></td><td>$date</td><td style='max-width:700px'>$content</td><td>$status</td><td>";
                if ($x == 1 or $x == 4) {
                    if ($statusid == 4 && checkPermision(4)) {
                        echo "<button onclick='checkReport(3,$id)'>CHECK</button>";
                    }
                } else if ($x == 2) {
                    echo"<button onclick='checkReport(2,$id)'>ACCEPT</button><button onclick='checkReport(1,$id)'>REJECT</button>";
                }
                echo "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No reports - go to work";
        }
    } else {
        echo "Something went wrong";
    }
    $stmt->free_result();

    $stmt->close();
} else {
    echo "Something went wrong";
}
}
else {
  echo "Something went wrong - get";  
}
