<?php

require_once '../lib/config.php';
//get the q parameter from URL
if (isset($_GET['t'])) {
    $t = $_GET["t"];

    switch ($t) {
        case 1://reports
            echo '<br>';
            echo '<p>Raports from reports ordered: </p>';
            echo '<label><input type="radio" name="mode" value="1" onchange="raportsshow(1)" checked> By date </label>';
            echo '<label><input type="radio" name="mode" value="2" onchange="raportsshow(1)"> By reporter </label>';
            echo '<label><input type="radio" name="mode" value="3" onchange="raportsshow(1)"> By reported </label>';
            echo '<label><input type="radio" name="mode" value="4" onchange="raportsshow(1)"> By admin </label>';
            echo '<select id = "duration" name = "duration" onchange="raportsshow(1)">';
            echo '<option value = "1">Day</option>';
            echo '<option value = "2">Month</option>';
            echo '<option value = "3">Year</option>';
            echo '<option value = "4">All</option>';
            echo '</select>';
            echo '<br>';
            echo '<br>';

            break;
        case 2://bans
            echo '<br>';
            echo '<p>Raports from bans ordered: </p>';
            echo '<label><input type="radio" name="mode" value="1" onchange="raportsshow(1)" checked> By start date </label>';
            echo '<label><input type="radio" name="mode" value="2" onchange="raportsshow(2)"> By end date </label>';
            echo '<label><input type="radio" name="mode" value="3" onchange="raportsshow(2)"> By reason </label>';
            echo '<label><input type="radio" name="mode" value="4" onchange="raportsshow(2)"> By player </label>';
            echo '<label><input type="radio" name="mode" value="5" onchange="raportsshow(2)"> By admin </label>';
            echo '<select id = "duration" name = "duration" onchange="raportsshow(2)">';
            echo '<option value = "1">Day</option>';
            echo '<option value = "2">Month</option>';
            echo '<option value = "3">Year</option>';
            echo '<option value = "4">All</option>';
            echo '</select>';
            echo '<br>';
            echo '<br>';

            break;
        case 3://players
            echo '<br>';
            echo '<p>Raports from players ordered: </p>';
            echo '<label><input type="radio" name="mode" value="1" onchange="raportsshow(3)" checked> By creation date </label>';
            echo '<label><input type="radio" name="mode" value="2" onchange="raportsshow(3)"> By last seen </label>';
            echo '<label><input type="radio" name="mode" value="3" onchange="raportsshow(3)"> By character count </label>';
            echo '<label><input type="radio" name="mode" value="4" onchange="raportsshow(3)"> By avg character lvl </label>';
            echo '<label><input type="radio" name="mode" value="5" onchange="raportsshow(3)"> By avg character money </label>';
            echo '<select id = "duration" name = "duration" onchange="raportsshow(3)">';
            echo '<option value = "1">Day</option>';
            echo '<option value = "2">Month</option>';
            echo '<option value = "3">Year</option>';
            echo '<option value = "4">All</option>';
            echo '</select>';
            echo '<br>';
            echo '<br>';

            break;
        case 4://classes
            echo '<br>';
            echo '<p>Raports from classes ordered: </p>';
            echo '<label><input type="radio" name="mode" value="1" onchange="raportsshow(4)" checked> By character count </label>';
            echo '<label><input type="radio" name="mode" value="2" onchange="raportsshow(4)"> By avg character lvl </label>';
            echo '<label><input type="radio" name="mode" value="3" onchange="raportsshow(4)"> By avg character money </label>';
            echo '<label><input type="radio" name="mode" value="4" onchange="raportsshow(4)"> By avg character item count </label>';
            echo '<label><input type="radio" name="mode" value="5" onchange="raportsshow(4)"> By highest character enchant lvl </label>';
            echo '<select id = "duration" name = "duration" onchange="raportsshow(4)">';
            echo '<option value = "1">Day</option>';
            echo '<option value = "2">Month</option>';
            echo '<option value = "3">Year</option>';
            echo '<option value = "4">All</option>';
            echo '</select>';
            echo '<br>';
            echo '<br>';

            break;

    }
} else {
    echo "Something went wrong";
}
?> 