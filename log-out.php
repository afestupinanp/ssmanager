<?php require_once 'fix_mysql.php'; ?>
<?php
	require_once('session_validation.php');
	session_unset();
	session_destroy();
	header("Location: index");
?>