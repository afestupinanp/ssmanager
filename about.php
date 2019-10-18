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
    <title>Sobre el proyecto - SS Manager</title>

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
                <h1>Sobre Student School Manager</h1>
                <div class = "col-lg-7">
                    <p style = "text-align: justify; align-content: justify;">
                    <span style = "font-weight: bold;">¿Qué es Student School Manager?</span><br><br>
                    Student School Manager es un proyecto iniciado por Andrés Felipe Estupiñán Peláez y Carlos Morales Ramírez en noviembre de 2016, junto con la asesoría del profesor Juan Carlos Jaramillo de la institución educativa del Colegio San Francisco de Asís, logramos contactarnos con el coordinador José Heraldo Criollo para saber cuales son las deficiencias en este departamento del colegio. Nos informó sobre que el observador era realizado de manera manual, sin usar ningún tipo de sistema, por lo que se le facilitaría las cosas para los coordinadores y profesores poder manejar del observador de manera digital. Por lo que decidimos contribuir en este departamento del colegio.<br><br>
                    </p>
                </div>
                <div class = "col-lg-5">
                    <img src = "img/logo.png" height = "320px"/>
                </div>
                <br><br>
                <ul style = "text-align: justify; align-content: justify; padding-left: 0px;">
                    <span style = "font-weight: bold;">¿Qué contiene Student School Manager?</span><br><br>
                    <li>Sistema de registro e inicio de sesión de los miembros de la institución del Colegio San Francisco de Asís</li>
                    <li>Sistema de registro y visibilidad de las observaciones de los estudiantes del colegio solo para los miembros de la institución y para los padres de familia que se les sea permitido</li>
                </ul>
            </div>
            <div class = "col-lg-12 text-center">
                <div class = "col-lg-6">
                    <center><h3>Créditos de desarrolladores</h3></center>
                    <hr>
                    <p style = 'text-align: justify;'>Creado por Andrés Felipe Estupiñán Peláez y Carlos Morales Ramírez del grado 11-A del Colegio San Francisco de Asís con asesoría del profesor Juan Carlos Jaramillo, docente de Desarrollo de Software y Diseño Gráfico. En colaboración con el coordinador José Heraldo Criollo López, coordinador disciplinario.
                    <br><b>Librerías usadas:</b> jQuery (jQuery Foundation), Bootstrap (Twitter Inc.), jsPDF (Parallax) y reCaptcha (Google).</p>
                </div>
                <div class = "col-lg-6" id = "contain">
                    <img src = "img/jquery.png">
                    <img src = "img/Bootstrap.png">
                    <img src = "img/logocaptcha.png" width = "100" height = "100" style = 'margin-right: 55px;'>
                    <img src = "img/fpdf.png">
                </div>
            </div>
            <div class = "col-lg-12 text-center">
                <h2>Vídeo introductorio de SSManager</h2>
                <video style = "width: 100%; height: 100%;" controls>
                    <source src = "Introduction.mp4" type = "video/mp4">
                </video>
            </div>
        </div>
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
        #contain img {
            max-width: 45%;
            max-height: 45%;
        }
    </style>
</body>

</html>
