<?php require_once 'fix_mysql.php'; ?>
<?php require_once 'session_validation.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="No.">
    <meta name="author" content="COSFA, Carlos Morales, Andrés Estupiñán">
    <link rel="icon" type="image/png" href="img/cosfa.png">
    <title>Observador del estudiante - SS Manager</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CSS -->
    <link href = "css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href = "css/cosfa.css" rel = "stylesheet" type = "text/css">
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Custom CSS -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <a href="#" id="back-to-top" title="Volver arriba">&uarr;</a>
    <?php
        if(isset($_SESSION['username']))
        {
            if($_SESSION['permission'] < 1)
            {
                header("Location: index.php");
            }
        }
        else header("Location: login.php");
    ?>
    <!-- Page Content -->
    <div class="container main">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>Observador - Listado de grados</h1>
                <hr>
                <div class = "col-lg-12">
                	<form id = 'observator' method = "POST">
                		<label for = 'graduacion'>Grado:</label>
                		<select name = 'grado' form = 'observator' id = 'graduacion'>
                			<option value = "null">Seleccione grado</option>
                			<?php
                				mysql_connect("db", "root", "") or die(mysql_error());
                				mysql_select_db("ssmanager");
                				mysql_set_charset("utf8");
                				$result = mysql_query("SELECT * FROM `grades` WHERE 1 ORDER BY `Grado`") or die(mysql_error());
                                if(mysql_num_rows($result) >= 1) {
                                    while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                                        $grado = $row['Grado'];
                                        echo "<option value = '$grado'>$grado</option>";
                                    }
                                }
                                else echo "<p style = 'color: red;'>Ha habido un problema al cargar el listado de grados. Intentalo más tarde.</p>";
                				mysql_free_result($result);
                				mysql_close();
                			?>
                		</select>
                        <input type = "submit" value = "Cargar grado" name = "loadGrado" id = "subm" style = "margin-left: 50px;">
                	</form>
                    <?php
                        if($_POST) {
                            mysql_connect("db", "root", "") or die(mysql_error());
                            mysql_set_charset("utf8");
                            mysql_select_db("ssmanager");
                            $result = mysql_query("SELECT * FROM `students` WHERE `grado` = '{$_POST['grado']}'") or die(mysql_error());
                            
                            $result2 = mysql_query("SELECT `realname` FROM `accounts` WHERE `gradedirector` = '{$_POST['grado']}'") or die(mysql_error());
                            $rowi = mysql_fetch_array($result2);
                            mysql_free_result($result2);
                            if(mysql_num_rows($result) >= 1) {
                                $director = null;
                                if(strlen($rowi['realname']) <= 0) {
                                    $director = "No asignado.";
                                }
                                else {
                                    $director = $rowi['realname'] . ".";
                                }
                                echo 
                                "
                                    <center>
                                    <h1>Listado del grado {$_POST['grado']}</h1>
                                    <h4>Director de grado: <i><b>$director</b></i></h4>
                                    <div class = 'table-responsive'><table class = 'table text-center' style = 'margin-top: 50px;'>
                                        <tr>
                                            <th>Código del estudiante</th>
                                            <th>Nombre de estudiante</th>
                                            <th>Opciones de observaciones</th>
                                        </tr>
                                ";
                                while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                                    $student = $row['student'];
                                    $id = $row['cod_student'];
                                    echo "
                                        <tr>
                                            <td>$id</td>
                                            <td>$student</td>
                                            <td><a href = 'observacion?userid=$id'>Lista de observaciones</a> | <a href = 'modifyobservator?userid=$id'>Modificar observación</a></td>
                                        </tr>
                                    ";
                                }
                                echo "</table></div></center>";
                            }
                            else {
                                echo 
                                "
                                    <div class = 'col-lg-12'>
                                        <div class = 'cosfa-message alert'>
                                            <span class = 'fa fa-exclamation-triangle' aria-hidden = 'true'></span>
                                            <p>Ha ocurrido un problema al cargar el listado del grado. Es posible que este no haya sido llenado correctamente o contenga un error. Contacte a un web master para informar acerca de este error.</p>
                                        </div>
                                    </div>
                                ";
                            }
                            mysql_free_result($result);
                            mysql_close();
                        }
                    ?>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <?php
            require('css/design/foot.php');
        ?>
        
    </div>
    <!-- /.container -->
    <!-- jQuery Version 1.11.1 -->

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>
<style>
    th {
        text-align: center;
    }
</style>
</html>
