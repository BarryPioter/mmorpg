<?php
session_start();

require '../lib/config.php';
require '../lib/functions.php';

if (isset($_GET['t'])) {
    $x = $_GET["t"];
    $sql = '';
    switch ($x) {
        case 1:
            ?><br><br>
            <form id="newitem" onsubmit="return false">
                item_type
                <select name='item_type'>
                    <option value='-1'>Select item type</option>
                    <?php echo fill_types(); ?>
                </select><br><br>
                name
                <input type = "text" name = "name" placeholder = "Adept's warbow" required autofocus></br><br>
                stat
                <input type = "number" name = "stat" value = "5" required autofocus></br><br>
                price
                <input type = "number" name = "price" value = "100" required autofocus></br><br>
                upgrade
                <input type = "number" name = "upgrade" value = "5" required autofocus></br><br>
                lvl
                <input type = "number" name = "lvl" value = "1" required autofocus></br><br>
                <button type = "submit" name = "ADD" onclick="additem(1)">ADD</button>
            </form>

            <?php
            break;
        case 2:
            $sql = "SELECT `item_id`, `item_name`, items.type_id,item_types.type_name, `stat_value`, `base_price`, `value_for_upgrade`, `required_lvl`, `active` FROM `items` INNER JOIN item_types on items.type_id=item_types.type_id order by item_id";
            break;
        case 3:
            ?><br><br>
            <form id="newitem" onsubmit="return false">
                <br><br>
                <input type = "text" name = "name" placeholder = "name = bow" required autofocus></br><br>
                <button type = "submit" name = "ADD" onclick="additem(2)">ADD</button>
            </form>

            <?php
            break;
        case 4:
            $sql = "SELECT `type_id`, `type_name` FROM `item_types` order by type_id";
            break;
        case 5:
            ?><br><br>
            <form id="newitem" onsubmit="return false">
                <br><br>
                CLASS NAME
                <input type = "text" name = "name" placeholder = "archer" required autofocus></br><br>
                base health
                <input type = "number" name = "health" value = "100" required autofocus></br><br>
                inc health
                <input type = "number" name = "inc" value = "10" required autofocus></br><br>
                base strength
                <input type = "number" name = "str" value = "1" required autofocus></br><br>
                base intelligence
                <input type = "number" name = "int" value = "1" required autofocus></br><br>
                base dexterity
                <input type = "number" name = "dex" value = "1" required autofocus></br><br>
                base endurance
                <input type = "number" name = "end" value = "1" required autofocus></br><br>
                <button type = "submit" name = "ADD" onclick="additem(3)">ADD</button>
            </form>

            <?php
            break;
        case 6:
            $sql = "SELECT `class_id`, `class_name`, `base_health`, `inc_health`, `base_strength`, `base_intelligence`, `base_dexterity`, `base_endurance`, `active` FROM `classes` order by class_id";
            break;
    }

    if ($x == 2 || $x == 4 || $x == 6) {
        if ($stmt = $mysqli->prepare($sql)) {
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    switch ($x) {
                        case 2:
                            $stmt->bind_result($id, $name, $tid, $tname, $stat, $price, $upgrade, $lvl, $active);
                            echo "<table class='classes' align='center'>";
                            echo "<tr><th>ID</th><th>NAME</th><th>TYPE ID</th><th>TYPE NAME</th><th>STAT VALUE</th><th>PRICE</th><th>UPGRADE VALUE</th><th>REQUIRED LVL</th><th>ACTIVE</th><th></th></tr>";
                            while ($stmt->fetch()) {
                                echo "<tr><td>$id</td><td>$name</td><td>$tid</td><td>$tname</td><td>$stat</td><td>$price</td><td>$upgrade</td><td>$lvl</td><td>$active</td><td><button onclick='activateItem($id,2)'>activate</button></td><td>";
                                echo "</td></tr>";
                            }
                            echo "</table>";
                            break;
                        case 4:
                            $stmt->bind_result($id, $name);
                            echo "<table class='classes' align='center'>";
                            echo "<tr><th>ID</th><th>NAME</th><th></th></tr>";
                            while ($stmt->fetch()) {
                                echo "<tr><td>$id</td><td>$name</td><td><button onclick='activateItem($id,4)'>remove</button></td><td>";
                                echo "</td></tr>";
                            }
                            echo "</table>";
                            break;
                        case 6:
                            $stmt->bind_result($id, $name, $health, $inchealt, $str, $int, $dex, $end, $active);
                            echo "<table class='classes' align='center'>";
                            echo "<tr><th>ID</th><th>NAME</th><th>BASE HEALTH</th><th>INC HEALTH</th><th>base_strength</th><th>base_intelligence</th><th>base_dexterity</th><th>base_endurance</th><th>ACTIVE</th><th></th></tr>";
                            while ($stmt->fetch()) {
                                echo "<tr><td>$id</td><td>$name</td><td>$health</td><td>$inchealt</td><td>$str</td><td>$int</td><td>$dex</td><td>$end</td><td>$active</td><td><button onclick='activateItem($id,6)'>active</button></td><td>";
                                echo "</td></tr>";
                            }
                            echo "</table>";
                            break;
                    }
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
    }
} else {
    echo "Something went wrong - get";
}