<?php require_once 'fix_mysql.php'; ?>
<?php
    require_once('session_validation.php');
    if($_SESSION['permission'] == 2)
    {
        mysql_connect("db", "root", "") or die(mysql_error());
        mysql_select_db("ssmanager");
        mysql_set_charset("utf8");
        $usuario = $_SESSION['deleting'];
		$nombre = $_SESSION['deleting2'];
        $id = $_SESSION['modifying'];
        $result = mysql_query("DELETE FROM `accounts` WHERE `id` = $id;") or die(mysql_error());
        mysql_free_result($result);
        $result = mysql_query("DELETE FROM `dates` WHERE `teacher` = '$nombre';") or die(mysql_error());
        mysql_free_result($result);
        mysql_close();
        echo 
        "
            <script>

                //alert('Se ha borrado la cuenta de $nombre ($usuario) correctamente. Además, se han eliminado las citas que $nombre haya dejado pendiente. Se te redirige al inicio.');
                window.location.assign('index');
            </script>
        ";

        //Deleting session leftovers
        unset($_SESSION['modifying']);
        unset($_SESSION['deleting']);
        unset($_SESSION['deleting2']);
    }
?>