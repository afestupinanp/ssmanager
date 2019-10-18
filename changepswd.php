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
    <title>Recuperación de contraseña - SS Manager</title>

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
        if(!isset($_SESSION['changepswd']) || $_SESSION['changepswd'] != 1) {
            echo "<script>window.location.replace('index');</script>";
        }
    ?>
    <!-- Page Content -->
    <div class="container main">
        <div class="row">
            <div class = "col-lg-12 text-center">
                <center><h1>Recuperación de contraseña</h1></center>
                <hr>
                <p style = "text-align: justify;">En estos momentos, debes de cambiar la contraseña de tu cuenta para poder continuar. No podrás acceder a otras páginas de SS Manager mientras tengas activo el cambio de contraseña.</p>
                <p style = "font-weight: bold; text-align: justify;">IMPORTANTE: Después de restablecer tu contraseña deberás de iniciar sesión de nuevo con la nueva contraseña.</p>
                <form method = "POST" id = "formulario">
                    <label for = "paswd">Nueva contraseña:</label>
                    <input type = "text" maxlength = "24" id = "paswd" name = "paswd" required>
                    <input type = "submit" value = "Cambiar contraseña" id = "subm">
                </form>
                <?php
                    if($_POST) {
                        mysql_connect("db", "root", "") or die(mysql_error());
                        mysql_set_charset("UTF8");
                        mysql_select_db("ssmanager");
                        mysql_query("UPDATE `accounts` SET `pswd` = '{$_POST['paswd']}', `changepswd` = 0 WHERE `username` = '{$_SESSION['username']}'") or die(mysql_error());
                        
                        mysql_close();

                        session_unset();
                        session_destroy();
                        echo 
                        "
                            <script>window.location.replace('login');</script>
                        ";
                    }
                ?>
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
</html>
