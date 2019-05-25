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

/**
 * 
 * PARTS
 * 1. FILL LISTS WITH DATA FUNCTIONS
 * 2. SESSION CHECK FUNCTIONS
 * 
 */
/**
 * =============================================================================
 * ===============FILL LISTS WITH DATA FUNCTIONS================================
 * =============================================================================
 */

/**
 * 
 * @return string
 * 
 */
function fill_characters() {
    require 'config.php';

    $output = '';

    if (isset($_SESSION['id'])) {

        $sql = "SELECT `character_id`, `name`,class_name FROM `characters` INNER JOIN classes ON characters.class_id=classes.class_id  WHERE `player_id` = ?";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $_SESSION['id']);


        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($cid, $name, $class);
                while ($stmt->fetch()) {
                    $output .= '<option value="' . $cid . '">' . $name . ' (' . $class . ')</option>';
                }
                return $output;
            } else {
                $output = "No characters";
                return $output;
            }
        } else {
            $err = "Something went wrong";
        }
        $stmt->free_result();

        $stmt->close();
    } else {
        echo "t";
//header("Location:home.php");
    }

    return $output;
}

/**
 * 
 * @return string
 * 
 */
function fill_admins($promote) {
    require 'config.php';

    $output = '';

    $sql = "SELECT `admin_id`, admins.player_id,players.login, `add_date`, `remove`, `edit`, `create`, `check`, `promote`, `isActive` FROM `admins` INNER JOIN players ON admins.player_id=players.player_id";

    $stmt = $mysqli->prepare($sql);


    if ($stmt->execute()) {
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $pid, $login, $date, $rem, $ed, $cr, $ch, $pr, $ac);
            $output .= "<table class='shop' align='center'>";
            $output .= "<tr><th>PLAYER</th><th>ADD DATE</th><th>REMOVE</th><th></th><th>EDIT</th><th></th><th>CREATE</th><th></th><th>CHECK</th><th></th><th>PROMOTE</th><th></th><th>ACTIVE</th><th></th></tr>";
            while ($stmt->fetch()) {

                $output .= "<tr><td>" . $login . " (" . $pid . ")</td><td>$date</td><td>$rem</td><td>";
                if ($id != $_SESSION['admin'] && $promote) {
                    if ($rem == 1) {
                        $output .= "<button onclick='changeAdminPriv($id, 1)'>-</button>";
                    } else {
                        $output .= "<button onclick='changeAdminPriv($id, 1)'>+</button>";
                    }
                }
                $output .= "</td><td>$ed</td><td>";
                if ($id != $_SESSION['admin'] && $promote) {
                    if ($ed == 1) {
                        $output .= "<button onclick='changeAdminPriv($id, 2)'>-</button>";
                    } else {
                        $output .= "<button onclick='changeAdminPriv($id, 2)'>+</button>";
                    }
                }
                $output .= "</td><td>$cr</td><td>";
                if ($id != $_SESSION['admin'] && $promote) {
                    if ($cr == 1) {
                        $output .= "<button onclick='changeAdminPriv($id, 3)'>-</button>";
                    } else {
                        $output .= "<button onclick='changeAdminPriv($id, 3)'>+</button>";
                    }
                }
                $output .= "</td><td>$ch</td><td>";
                if ($id != $_SESSION['admin'] && $promote) {
                    if ($ch == 1) {
                        $output .= "<button onclick='changeAdminPriv($id, 4)'>-</button>";
                    } else {
                        $output .= "<button onclick='changeAdminPriv($id, 4)'>+</button>";
                    }
                }
                $output .= "</td><td>$pr</td><td>";
                if ($id != $_SESSION['admin'] && $promote) {
                    if ($pr == 1) {
                        $output .= "<button onclick='changeAdminPriv($id, 5)'>-</button>";
                    } else {
                        $output .= "<button onclick='changeAdminPriv($id, 5)'>+</button>";
                    }
                }
                $output .= "</td><td>$ac</td><td>";
                if ($id != $_SESSION['admin'] && $promote) {
                    if ($ac == 1) {
                        $output .= "<button onclick='changeAdminPriv($id, 6)'>-</button>";
                    } else {
                        $output .= "<button onclick='changeAdminPriv($id, 6)'>+</button>";
                    }
                }
                $output .= "</td></tr>";
            }
            $output .= "</table>";
            return $output;
        } else {
            $output = "No admins = ? how you get there?";
            return $output;
        }
    } else {
        $err = "Something went wrong";
    }
    $stmt->free_result();

    $stmt->close();

    return $output;
}

/**
 * 
 * @return string
 * 
 */
function fill_shop() {
    require 'config.php';

    $output = '';

    if (isset($_SESSION['id'])) {

        $sql = "select type_id, type_name FROM item_types";

        $stmt = $mysqli->prepare($sql);

        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $name);
                while ($stmt->fetch()) {
                    $output .= '<li><a href="#" onclick="showShop(' . $id . ');">' . $name . '</a></li>';
                }
                return $output;
            } else {
                $output = "Shop is empty";
                return $output;
            }
        } else {
            $err = "Something went wrong";
        }
        $stmt->free_result();

        $stmt->close();
    } else {
        echo "t";
//header("Location:home.php");
    }

    return $output;
}

/**
 * 
 * @return string
 * 
 */
function fill_players($x) {
    require 'config.php';

    $output = '';

    if (isset($_SESSION['id'])) {

        $sql = "select player_id, login FROM players where player_id != ?";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $_SESSION['id']);
        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $name);
                while ($stmt->fetch()) {
                    $output .= '<option value="' . $id . '"';
                    if ($x == $id) {
                        $output .= 'selected';
                    }
                    $output .= '>' . $name . ' (' . $id . ')</option>';
                }
                return $output;
            } else {
                $output = "Player list is empty";
                return $output;
            }
        } else {
            $output = "Something went wrong - execute";
        }
        $stmt->free_result();

        $stmt->close();
    } else {
        $output = "Something went wrong - id";
    }

    return $output;
}

/**
 * 
 * @return string
 * 
 */
function fill_types() {
    require 'config.php';

    $output = '';

    $sql = "select type_id, type_name FROM item_types";

    $stmt = $mysqli->prepare($sql);
    if ($stmt->execute()) {
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $name);
            while ($stmt->fetch()) {
                $output .= '<option value="' . $id . '">' . $name . '</option>';
            }
            return $output;
        } else {
            $output = "Player list is empty";
            return $output;
        }
    } else {
        $output = "Something went wrong - execute";
    }
    $stmt->free_result();

    $stmt->close();

    return $output;
}

/**
 * 
 * @return string
 * 
 */
function showclass() {
    require 'config.php';

    $output = '';

    if (isset($_SESSION['id'])) {

        $sql = "SELECT class_id,class_name from classes where active=1";

        $stmt = $mysqli->prepare($sql);


        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($cid, $name);
                while ($stmt->fetch()) {
                    $output .= '<option value="' . $cid . '">' . $name . '</option>';
                }
                return $output;
            } else {
                $output = "No classes";
                return $output;
            }
        } else {
            $err = "Something went wrong";
        }
        $stmt->free_result();

        $stmt->close();
    } else {
        echo "t";
//header("Location:home.php");
    }

    return $output;
}

/**
 * 
 * @return string
 * 
 */
function fill_players_table($type) {
    require 'config.php';

    $output = '';

    $sql = "SELECT players.player_id, players.login, format(avg(characters.lvl),0),players.email, players.creation_date, players.last_seen,admins.admin_id FROM players LEFT JOIN characters on players.player_id=characters.player_id left join admins on players.player_id=admins.player_id GROUP BY players.player_id";

    $stmt = $mysqli->prepare($sql);
    if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $output .= "<table class='players' align='center'>";
            if ($type == 1) {
                $output .= "<tr><th>ID</th><th>LOGIN</th><th>AVG CHARACTER LVL</th><th>EMAIL</th><th>CREATION_DATE</th><th>LAST_SEEN</th><th></th><th></th><th></th></tr>";
                $stmt->bind_result($id, $login, $lvl, $email, $creation, $last, $admin);
                while ($stmt->fetch()) {
                    $output .= "<tr><td>" . $id . "</td><td><a href='profile.php?id=" . $id . "'>" . $login . "</a></td><td>$lvl</td><td>" . $email . "</td><td>" . $creation . "</td><td>" . $last . "</td><td><button>Edit</button></td><td><a href='bans.php?id=" . $id . "'><button>Ban</button></a></td><td><button onclick='promote(" . $id . ")'";
                    if ($admin != NULL)
                        $output .= "disabled";
                    $output .= ">Promote</button></td></tr>";
                }
            } else if ($type == 2) {

                $output .= "<tr><th>LOGIN</th><th>AVG CHARACTER LVL</th><th>LAST_SEEN</th><th></th></tr>";
                $stmt->bind_result($id, $login, $lvl, $email, $creation, $last, $admin);
                while ($stmt->fetch()) {
                    $output .= "<tr><td><a href='profile.php?id=" . $id . "'>" . $login . "</a></td><td>$lvl</td><td>" . $last . "</td><td><a href='report.php?id=$id'><button>Report</button></a></td><td><button disabled>PVP</button></td></tr>";
                }
            }
            $output .= "</table";
            return $output;
        } else {
            $output = "Something went wrong";
            return $output;
        }
    } else {
        $output = "Something went wrong";
        return $output;
    }
    $stmt->free_result();
    $stmt->close();
    return $output;
}

function get_login($id) {
    require 'config.php';

    $output = '';

    $sql = "SELECT login from players WHERE `player_id` = ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $id);


    if ($stmt->execute()) {
        $stmt->store_result();
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($login);
            $stmt->fetch();
            return $login;
        } else {
            return false;
        }
    } else {
        $output = "Something went wrong";
    }
    $stmt->free_result();

    $stmt->close();

    return $output;
}

/**
 * =============================================================================
 * ===============SESSION CHECK FUNCTIONS=======================================
 * =============================================================================
 */

/**
 * 
 * @return boolean
 * 
 */
function checkTimeout() {

    if (isset($_SESSION['id']) && isset($_SESSION['login']) && isset($_SESSION['loggedAt'])) {
        if (time() - $_SESSION['loggedAt'] > 600) {
            return true;
        } else {
            $_SESSION['loggedAt'] = time();
            return false;
        }
    } else {
        return true;
    }
}

/**
 * 
 * @return boolean
 * 
 */
function checkBan() {
    require 'config.php';

    $sql = "SELECT ban_id FROM bans WHERE player_id = ? and timestampdiff(second,current_timestamp,end_date) > 0 and active=1";


    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param('i', $_SESSION['id']);


        if ($stmt->execute()) {
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                return false;
            } else {
                return true;
            }
        } else {
            $err = "Something went wrong";
            return false;
        }
        $stmt->free_result();
        $stmt->close();
    } else {
        return false;
    }
}

/**
 * 
 * 
 * 
 */
function lastSeen() {
    require 'config.php';

    $sql = "update players set last_seen = CURRENT_TIMESTAMP where player_id = ?";


    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param('i', $_SESSION['id']);


        if ($stmt->execute()) {
            
        } else {
            $err = "Something went wrong";
        }
        $stmt->free_result();
        $stmt->close();
    } else {
        
    }
}

/**
 * 
 * 
 * 
 */
function checkAdmin() {
    require 'config.php';

    $sql = "SELECT `remove`,`edit`,`create`,`check`,`promote`,admin_id FROM admins WHERE player_id = ? and isActive = 1";


    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param('i', $_SESSION['id']);


        if ($stmt->execute()) {
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                $stmt->bind_result($rem, $ed, $cr, $ch, $pr, $id);
                $stmt->fetch();
                $_SESSION['admin'] = $id;
                $_SESSION['remove'] = $rem;
                $_SESSION['edit'] = $ed;
                $_SESSION['create'] = $cr;
                $_SESSION['check'] = $ch;
                $_SESSION['promote'] = $pr;
            } else {
                $err = "No admin";
                $_SESSION['admin'] = 0;
            }
        } else {
            $err = "Something went wrong";
        }
        $stmt->free_result();
        $stmt->close();
    } else {
        
    }
}

/**
 * 
 * @param type $index
 * 
 */
function logout($index) {
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
    header("Location:" . $index . "?message=Timeout");
}

/**
 * 
 * @param type $perm
 * @return boolean
 * 
 */
function checkPermision($perm) {
    if (isset($_SESSION['admin'])) {
        switch ($perm) {
            case 1:
                return $_SESSION['remove'];
                break;
            case 2:
                return $_SESSION['edit'];
                break;
            case 3:
                return $_SESSION['create'];
                break;
            case 4:
                return $_SESSION['check'];
                break;
            case 5:
                return $_SESSION['promote'];
                break;
        }
    } else {
        return false;
    }
}

/**
 * 
 * @return type
 * 
 */
function checkSession() {
    return (isset($_SESSION['id']) && isset($_SESSION['login']) && isset($_SESSION['loggedAt']));
}

function setDuration($d) {
    $sql = "";
    switch ($d) {
        case 1:
            $sql .= "where day(`report_date`)=day(current_timestamp) and month(`report_date`)=month(current_timestamp) and year(`report_date`)=year(current_timestamp) ";
            break;
        case 2:
            $sql .= "where month(`report_date`)=month(current_timestamp) and year(`report_date`)=year(current_timestamp) ";
            break;
        case 3:
            $sql .= "where year(`report_date`)=year(current_timestamp) ";
            break;
    }
    return $sql;
}

function setDuration2($d) {
    $sql = "";
    switch ($d) {
        case 1:
            $sql .= "where day(`start_date`)=day(current_timestamp) and month(`start_date`)=month(current_timestamp) and year(`start_date`)=year(current_timestamp) ";
            break;
        case 2:
            $sql .= "where month(`start_date`)=month(current_timestamp) and year(`start_date`)=year(current_timestamp) ";
            break;
        case 3:
            $sql .= "where year(`start_date`)=year(current_timestamp) ";
            break;
    }
    return $sql;
}

function setDuration3($d) {
    $sql = "";
    switch ($d) {
        case 1:
            $sql .= "where day(`creation_date`)=day(current_timestamp) and month(`creation_date`)=month(current_timestamp) and year(`creation_date`)=year(current_timestamp) ";
            break;
        case 2:
            $sql .= "where month(`creation_date`)=month(current_timestamp) and year(`creation_date`)=year(current_timestamp) ";
            break;
        case 3:
            $sql .= "where year(`creation_date`)=year(current_timestamp) ";
            break;
    }
    return $sql;
}