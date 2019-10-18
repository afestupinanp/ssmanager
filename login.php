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
    <title>Iniciar Sesión - SS Manager</title>

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
    ?>
    <!-- Page Content -->
    <div class="container main">
        <div class="row">
            <div class = "col-lg-6 text-center">
                <center><form class = "cosfa-register" method = "POST" action = "log-on">
                    <h1>Iniciar sesión en el sistema</h1>
                    <div class = "form-group">
                        <label for = "user">Nombre de usuario:</label><br>
                        <input type = "text" placeholder = "Nombre de usuario" id = "user" name = "user" required/>
                    </div>
                    <div class = "form-group">
                        <label for = "pwd">Contraseña:</label><br>
                        <input type = "password" placeholder = "Contraseña" id = "pwd" name = "pwd" length = "24" required/>
                    </div>
                    <div class = "form-group">
                        <input type = "submit" value = "Iniciar sesión" id = "subm"/>
                    </div>
                    <p><a href = 'forget'>¿Ha olvidado su contraseña?</a></p>
                    <p><a href = 'forget-account'>¿Ha olvidado su cuenta?</a></p>
                    <?php
                        if(isset($_SESSION['error']))
                        {
                            switch($_SESSION['error'])
                            {
                                case 1:
                                {
                                    echo '<p style = "color: red;">Contraseña equivocada.</p>';
                                    $_SESSION['error'] = 0;
                                    break;
                                }
                                case 2:
                                {
                                    echo '<p style = "color: red;">Cuenta inexistente.</p>';
                                    $_SESSION['error'] = 0;
                                    break;
                                }
                            }
                        }
                    ?>
                </form></center>
            </div>
            <div class = "col-lg-6 text-center">
                <img src = "img/pendon.jpg" width = "340px" height = "480px" style = "border-radius: 15px 15px 15px 15px;">
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
