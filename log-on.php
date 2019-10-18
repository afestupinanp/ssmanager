<?php require_once 'fix_mysql.php'; ?>
<?php require_once('session_validation.php'); ?>
<?php
    $usern = $_POST['user'];
    $pwd = $_POST['pwd'];
    mysql_connect('db', 'root', '');
    if(mysql_errno() != 0)
    {
        die(mysql_error());
    }
    else
    {
        mysql_select_db('ssmanager');
        mysql_set_charset("utf8");
        $result = mysql_query("SELECT * FROM `accounts` WHERE `username` = '$usern';");
        if(mysql_num_rows($result) >= 1)
        {
            $rows = mysql_fetch_array($result, MYSQL_ASSOC);
            if($rows['pswd'] == $pwd)
            {
                $_SESSION['username'] = $usern;
                $_SESSION['realname'] = $rows['realname'];
                $_SESSION['permission'] = $rows['permission'];
                $_SESSION['color'] = $rows['color'];
                $_SESSION['userid'] = $rows['id'];
                $_SESSION['changepswd'] = $rows['changepswd'];
                mysql_free_result($result);
                mysql_close();
                if($_SESSION['changepswd'] == 1) {
                    header("Location: changepswd");
                }
                else header('Location: index');
            }
            else
            {
                $_SESSION['error'] = 1;
                header('Location: login');
            }
        }
        else
        {
            $_SESSION['error'] = 2;
            header('Location: login.php');
        }
    }
?>