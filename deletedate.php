<?php require_once 'fix_mysql.php'; ?>
<?php require_once 'session_validation.php'; ?>
<?php
	if($_GET) {
		mysql_connect("db", "root", "") or die(mysql_error());
		mysql_set_charset("utf8");
		mysql_select_db("ssmanager");
		$result = mysql_query("DELETE FROM `dates` WHERE `cita` = {$_GET['dateid']}") or die(mysql_error());
		mysql_free_result($result);
		mysql_close();

		header("Location: dates");
	}
?>