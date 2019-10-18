<?php require_once 'fix_mysql.php'; ?>
<?php require_once('session_validation.php'); ?>
<?php
    if($_GET) {
        if($_SESSION['permission'] == 2) {
            mysql_connect("db", "root", "") or die(mysql_error());
            mysql_select_db("ssmanager");
            $result = mysql_query("DELETE FROM `accounts` WHERE `id` = '{$_GET['userid']}';") or die(mysql_error());
            if(file_exists("img/profiles/{$_GET['userid']}.jpg")) {
                unlink("img/profiles/{$_GET['userid']}.jpg");
            }
            header("Location: index");
            mysql_free_result($result);
            mysql_close();
        }
    }
    else header("Location: 404");
?>