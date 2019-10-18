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
    <title>Bienvenido al observador - COSFA</title>

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

</head>

<body>
    <a href="#" id="back-to-top" title="Volver arriba">&uarr;</a>
    <?php
        require('css/design/nav.php');
    ?>
    <!-- Page Content -->
    <div class="container main">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 style = "font-size: 108pt;">Error 404</h1>
                <div class = "cosfa-message alert">
                    <p><span class = "fa fa-exclamation-triangle" aria-hidden = "true"></span><br><br>La página que buscas no fue encontrada en este dominio. Puede haber sido eliminada o modificada.<br>Si estás buscando esto, y estas yendo a un enlace correcto, contacta a los administradores/web masters.<br><br><a href = 'index'>Volver al inicio</a></p>
                </div>
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
    <style>
        .item img {
            min-width: 100%;
            min-height: 100%;
        }

        .carousel {
            min-width: 100%;
            min-height: 100%;
        }
    </style>
</body>

</html>
