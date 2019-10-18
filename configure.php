<?php require_once 'fix_mysql.php'; ?>
<?php require_once('session_validation.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="No.">
    <meta name="author" content="COSFA, Carlos Morales, Andrés Estupiñán">
    <link rel="icon" type="image/png" href="img/cosfa.png">
    <title>Configuración de SS Manager - COSFA</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CSS -->
    <link href = "css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href = "css/cosfa.css" rel = "stylesheet" type = "text/css">
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <!-- Custom CSS -->

    <!-- HTML5 Shim and Respond.js IE8 main support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php
        if($_SESSION['permission'] <= 1) {
            header("Location: index");
        }
    ?>

</head>

<body>
    <!--div id="content">Scroll &darr;</div-->
    <a href="#" id="back-to-top" title="Volver arriba">&uarr;</a>
    <?php
        require('css/design/nav.php');
        mysql_connect("db", "root", "") or die(mysql_error());
		mysql_set_charset("utf8");
		mysql_select_db("ssmanager");
		$result = mysql_query("SELECT * FROM `daymess` WHERE `id` = 1") or die(mysql_error());
		$rows1 = mysql_fetch_array($result, MYSQL_ASSOC);
		mysql_free_result($result);
		$result = mysql_query("SELECT * FROM `daymess` WHERE `id` = 2") or die(mysql_error());
		$rows2 = mysql_fetch_array($result, MYSQL_ASSOC);
		mysql_free_result($result);
    ?>
    <!-- Page Content -->
    <div class="container main">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>Configuración de SS Manager</h1>
                <hr>
                <p style = "text-align: justify;">En esta zona, como administrador, podrás modificar el contenido que veran las personas que hayan iniciado sesión en <a href = "index">la siguiente página.</a> Este mensaje es para que ellos tengan en cuenta alguna información importante, reunión, etc.</p>
                <form class = "form-group" method = "POST" id = "welcomer">
                    <input type = "submit" id = "subm" value = "Guardar mensajes de configuración"><br><br>
                    <label for = "bienvenida">Mensaje de bienvenida (para todos):</label>
                    <select form = "welcomer" name = "welcomeroption1" id = "kk1">
                        <option value = "null">Selecciona el tipo de mensaje</option>
                        <option value = "alert">Alerta</option>
                        <option value = "info">Información</option>
                    </select>
                    <br>
                    <textarea form = "welcomer" placeholder = "Mensaje de bienvenida para todos los usuarios. Puedes dejarlo vacío si no quieres tener ningún mensaje para todos los usuarios." id = 'bienvenida' style = "resize: none; width: 780px; height: 300px;" name = "welcome1"><?php echo $rows1['txt']; ?></textarea>
                    <br>
                    <label for = "bienvenida">Mensaje de bienvenida (para miembros de la institución):</label>
                    <select form = "welcomer" name = "welcomeroption2" id = "kk2">
                        <option value = "null">Selecciona el tipo de mensaje</option>
                        <option value = "alert">Alerta</option>
                        <option value = "info">Información</option>
                    </select>
                    <br>
                    <textarea placeholder = "Mensaje de bienvenida para todos los miembros registrados. Puedes dejarlo vacío si no quieres tener ningún mensaje." id = 'bienvenida2' style = "resize: none; width: 780px; height: 300px;" name = "welcome2"><?php echo $rows2['txt']; ?></textarea>
                </form>
                <?php
                    if($_POST) {
                        $finalresult = false;
                        if($_POST['welcomeroption1'] != null) {
                        	$typer = 0;
                        	if($_POST['welcomeroption1'] == "alert") {
                        		$type = 1;
                        	}
                        	else
                        	if($_POST['welcomeroption1'] == "info") {
                        		$type = 2;
                        	}
                        	$result = mysql_query("UPDATE `daymess` SET `type` = $type, `txt` = '{$_POST['welcome1']}', `teacher` = '{$_SESSION['realname']}' WHERE `id` = 1") or die(mysql_error());
                            $finalresult = true;
                        }
                        if($_POST['welcomeroption2'] != null) {
                        	$typer = 0;
                        	if($_POST['welcomeroption2'] == "alert") {
                        		$type = 1;
                        	}
                        	else
                        	if($_POST['welcomeroption2'] == "info") {
                        		$type = 2;
                        	}
                        	$result = mysql_query("UPDATE `daymess` SET `type` = $type, `txt` = '{$_POST['welcome2']}', `teacher` = '{$_SESSION['realname']}' WHERE `id` = 2") or die(mysql_error());
                            $finalresult = true;
                        }
                        if($finalresult == true) {
                            echo 
                            "
                                <div class = 'dialog' title = 'Cambios realizados correctamente'>
                                    <p>Los cambios realizados se han hecho con éxito. Los mensajes fueron establecidos.</p>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('#bienvenida1').val('{$_POST['welcome1']}');
                                        $('#bienvenida2').val('{$_POST['welcome2']}');
                                        $('#dialog').dialog();
                                    });
                                </script>
                            ";
                        }

                    } 
                ?>
            </div>
        </div>
        <!-- /.row -->
        
    </div>
    <div class = "container">
        <?php
            require('css/design/foot.php');
        ?>
    </div>
    <!-- /.container -->

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <?php 
    	switch($rows1['type']) {
    		case 1: {
    			echo 
    			"
    				<script>
				    	$(document).ready(function() {
				    		$('#kk1').val('alert');
				    	});
				    </script>
    			";
    			break;
    		}
    		case 2: {
    			echo 
    			"
    				<script>
				    	$(document).ready(function() {
				    		$('#kk1').val('info');
				    	});
				    </script>
    			";
    			break;
    		}
    	}
    	switch($rows2['type']) {
    		case 1: {
    			echo 
    			"
    				<script>
				    	$(document).ready(function() {
				    		$('#kk2').val('alert');
				    	});
				    </script>
    			";
    			break;
    		}
    		case 2: {
    			echo 
    			"
    				<script>
				    	$(document).ready(function() {
				    		$('#kk2').val('info');
				    	});
				    </script>
    			";
    			break;
    		}
    	}
    ?>
    
</body>
<style>
    textarea {
        width: 100% !important;
    }
</style>
</html>
