<?php
session_start();

require '../lib/config.php';
require '../lib/functions.php';

if (isset($_GET['t'])) {
    $x = $_GET["t"];

    $sql = '';
    if ($x != 1) {
        switch ($x) {
            case 2:
                $sql = "SELECT b.ban_id,b.player_id,p.login,b.ban_reason,b.start_date,b.end_date,b.admin_id,pp.login FROM bans as b "
                        . "inner JOIN players as p on b.player_id=p.player_id "
                        . "INNER JOIN admins as a on b.admin_id=a.admin_id "
                        . "INNER JOIN players as pp on a.player_id=pp.player_id "
                        . "WHERE b.admin_id = ? and (timestampdiff(second,current_timestamp,b.end_date) > 0 and b.active=1)";
                break;
            case 3:
                $sql = "select b.ban_id,b.player_id,p.login,b.ban_reason,b.start_date,b.end_date,b.admin_id,pp.login from bans as b "
                        . "inner JOIN players as p on b.player_id=p.player_id "
                        . "INNER JOIN admins as a on b.admin_id=a.admin_id "
                        . "INNER JOIN players as pp on a.player_id=pp.player_id "
                        . "WHERE b.admin_id = ? and (timestampdiff(second,current_timestamp,b.end_date) < 0 or b.active=0)";
                break;
            case 4:
                $sql = "select b.ban_id,b.player_id,p.login,b.ban_reason,b.start_date,b.end_date,b.admin_id,pp.login,(timestampdiff(second,current_timestamp,b.end_date) > 0 and b.active=1) as valid from bans as b "
                        . "inner JOIN players as p on b.player_id=p.player_id "
                        . "INNER JOIN admins as a on b.admin_id=a.admin_id "
                        . "INNER JOIN players as pp on a.player_id=pp.player_id";
                break;
        }

        if ($stmt = $mysqli->prepare($sql)) {
            if ($x == 2 or $x == 3) {
                $stmt->bind_param('i', $_SESSION['admin']);
            }
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    if ($x == 4) {
                        $stmt->bind_result($id, $pid, $login, $reason, $start, $end, $aid, $alog, $valid);
                    } else {
                        $stmt->bind_result($id, $pid, $login, $reason, $start, $end, $aid, $alog);
                    }
                    echo "<table class='bans' align='center'>";
                    echo "<tr><th>ID</th><th>BANNED</th><th>REASON</th><th>START DATE</th><th>END DATE</th><th>ADMIN</th><th></th></tr>";
                    while ($stmt->fetch()) {
                        echo "<tr><td>$id</td><td><a href='profile.php?id=$pid'>$login</a></td><td>$reason</td><td>$start</td><td>$end</td><td><a href='profile.php?id=$aid'>$alog</a></td><td>";
                        if ($x == 2 or ( $x == 4 && $valid == 1 )) {
                            if (checkPermision(2)) {
                                echo "<button onclick='unban($id)'>DISABLE</button>";
                            }
                        }

                        echo "</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No bans - go to work";
                }
            } else {
                echo "Something went wrong - exec";
            }
            $stmt->free_result();

            $stmt->close();
        } else {
            echo "Something went wrong - prepare";
        }
    } else {
        if (isset($_GET['id'])) {
            ?><br><br>
            <form id="newban" onsubmit="return false">
                <select name='player'>
                    <option value=''>Select player</option>
                    <?php echo fill_players($_GET['id']); ?>
                </select><br><br>
                <input type = "text" name = "reason" placeholder = "reason = cheating" required autofocus></br><br>
                <input type = "date" name = "end_date" required></br><br>
                <button type = "submit" name = "BAN" onclick="ban()">BAN</button>
            </form>

            <?php
        }
    }
} else {
    echo "Something went wrong - get";
}            