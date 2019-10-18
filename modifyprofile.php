<?php require_once 'fix_mysql.php'; ?>
<?php
	require_once('session_validation.php');
	if($_POST)
	{
		mysql_connect("db", "root", "") or die(mysql_error());
		mysql_select_db("ssmanager");
		mysql_set_charset("utf8");
		$nombre = $_POST['realname'];
        $usuario = $_POST['username'];
        $contra = $_POST['pass'];
        $description = $_POST['description'];
        $color = $_POST['color'];
		$rol = $_POST['rol'];

		$result = mysql_query("UPDATE `accounts` SET `realname` = '$nombre', `username` = '$usuario', `description` = '$description', `pswd` = '$contra', `color` = '$color', `role` = '$rol' WHERE `realname` = '$nombre';") or die(mysql_error());
        mysql_free_result($result);
        mysql_close();
		echo "
		<script>
			alert('El usuario $nombre ($usuario) ha sido modificado correctamente. Redirigiendo a inicio');
			window.location.assign('index.php');
			</script>
		";
		/*if(isset($_POST['modify']))
		{
            
		}
		else
		if(isset($_POST['delete']))
		{
			$_SESSION['deleting'] = $usuario;
			$_SESSION['deleting2'] = $nombre;
			echo "
			<script>
				var booleano = confirm('¿Estás seguro de eliminar la cuenta de $nombre ($usuario)? Esta acción es irreversible y no podrá ser recuperado después. Pero si podrás crear una cuenta con este nombre y los mismos datos después. ¿Estás seguro de esto?');
				if(booleano == true)
				{
					window.location.assign('deleteprofile.php');
				}
				else
				{
					alert('Ha decidido cancelar la eliminación de la cuenta de $nombre ($usuario). Redirigiendo a la sección de miembros.');
					window.location.assign('members.php');
				}
			</script>
			";
		}*/
	}
?>