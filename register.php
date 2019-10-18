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
    <title>Registro de miembros - SS Manager</title>

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
        require('css/design/nav.php');
        if(!isset($_SESSION) || $_SESSION['permission'] != 2)
        {
            header("Location: login.php");
        }
    ?>
    <!-- Page Content -->
    <div class="container main">
        <div class="row">
            <center><form class = "cosfa-register" method = "POST">
                <h1>Registrar a un miembro en el sistema</h1>
                <hr>
                <br>
                <div class = "form-group">
                    <div class = "col-lg-4">
                        <label for = "user">Nombre de usuario:</label><br>
                        <input type = "text" placeholder = "xxxxxxxxxx" id = "user" name = "user" required/>
                    </div>
                    <div class = "col-lg-4">
                        <label for = "cedul">Número de cédula (sin puntos):</label><br>
                        <input type = "number" placeholder = "123456789" id = "cedul" name = "cedul" required/>
                    </div>
                    <div class = "col-lg-4">
                        <label for = "name">Nombre real:</label><br>
                        <input type = "text" placeholder = "xxxxxxxxxxx" id = "name" name = "name" required/>
                    </div>
                    <br>
                    <div class = "col-lg-4">
                        <label for = "role">Rol en la institución:</label><br>
                        <input value = "Miembro" type = "text" placeholder = "Profesor" id = "role" name = "role" required/>
                    </div>
                    <div class = "col-lg-4">
                        <label for = "pwd">Contraseña:</label><br>
                        <input type = "password" placeholder = "Contraseña" id = "pwd" name = "pwd" required/>
                    </div>
                    <div class = "col-lg-4">
                        <label for = "mail">Correo de recuperación:</label><br>
                        <input type = "email" placeholder = "ejemplo@ejemplo.com" id = "mail" name = "email" required/>
                    </div>
                    <br>
                    <div class = "col-lg-12">
                        <input type = "submit" value = "Registrar" id = "subm"/>
                    </div>
                </div>
            </form></center>
            <?php
                if($_POST)
                {
                    mysql_connect('db', 'root', '') or die(mysql_error());
                    mysql_select_db('ssmanager');
                    mysql_set_charset("utf8");
                    $user = $_POST['user'];
                    $realna = $_POST['name'];
                    $cedula = $_POST['cedul'];
                    $rol = $_POST['role'];
                    $contra = $_POST['pwd'];
                    $correo = $_POST['email'];
                    if(strpos($rol, "Administrador") !== FALSE) 
                    {
                        mysql_query("INSERT INTO `accounts`(`username`, `realname`, `pswd`, `role`, `identificacion`, `recuperacion`, `permission`) VALUES ('$user', '$realna', '$contra', '$rol', $cedula, '$correo', 2);") or die(mysql_error());
                    }
                    else 
                    {
                        mysql_query("INSERT INTO `accounts`(`username`, `realname`, `pswd`, `role`, `identificacion`, `recuperacion`) VALUES ('$user', '$realna', '$contra', '$rol', $cedula, '$correo');") or die(mysql_error());
                    }
                    mysql_close();
                    echo 
                    "
                        <script>
                            //alert('El usuario $realna ($user) ha sido registrado de forma satisfactoria.');
                            $(function () {
                                $('#confirmation').dialog();
                            });
                        </script>
                        <div id = 'confirmation' title = 'Registrado satisfactoriamente'>
                            <p>
                            El usuario(a) <b><i>$realna ($user)</i></b> ha sido registrado(a) de forma satisfactoria.
                            </p>
                        </div>
                    ";
                }
            ?>
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
    .col-lg-4 {
        padding-top: 25px;
        padding-bottom: 25px;
    }  
</style>
</html>
