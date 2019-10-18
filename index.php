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
    <title>Inicio - SS Manager</title>

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
    <!--div id="content">Scroll &darr;</div-->
    <a href="#" id="back-to-top" title="Volver arriba">&uarr;</a>
    <?php
        require('css/design/nav.php');
    ?>
    <!-- Page Content -->
    <div class="container main">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>Student School Manager</h1>
                <hr>
                <?php
                    mysql_connect("db", "root", "") or die(mysql_error());
                    mysql_set_charset("utf8");
                    mysql_select_db("ssmanager");
                    $result = mysql_query("SELECT * FROM `daymess` WHERE `id` = 1") or die(mysql_error());
                    $rows1 = mysql_fetch_array($result, MYSQL_ASSOC);
                    mysql_free_result($result);
                    $result = mysql_query("SELECT * FROM `daymess` WHERE `id` = 2") or die(mysql_error());
                    $rows2 = mysql_fetch_array($result, MYSQL_ASSOC);
                    mysql_free_result($result);
                    if(!empty($rows1['txt']) or !empty($rows2['txt'])) {
                        echo "<div class = 'col-lg-12' style = 'margin-bottom: 25px;'>";
                        if(!empty($rows1['txt'])) {
                            switch($rows1['type']) {
                                case 1: {
                                    echo 
                                    "
                                        <div class = 'cosfa-message alert'><span class = 'fa fa-exclamation-triangle' aria-hidden = 'true'></span><br>Mensaje para todos: <br>{$rows1['txt']}<br><br><b style = 'text-align: right;'>- {$rows1['teacher']}</b></div>
                                    ";
                                    break;
                                }
                                case 2: {
                                    echo 
                                    "
                                        <div class = 'cosfa-message message'><span class = 'fa fa-info' aria-hidden = 'true'></span><br>Mensaje para todos: <br>{$rows1['txt']}<br><br><b style = 'text-align: right;'>- {$rows1['teacher']}</b></div>
                                    ";
                                    break;
                                }
                            }
                            
                        }
                        if(!empty($rows2['txt']) && isset($_SESSION['permission'])) {
                            switch($rows2['type']) {
                                case 1: {
                                    echo 
                                    "
                                        <div class = 'cosfa-message adminmsg'><span class = 'fa fa-exclamation-triangle' aria-hidden = 'true'></span><br>Mensaje para miembros del plantel: <br>{$rows2['txt']}<br><br><b style = 'text-align: right;'>- {$rows2['teacher']}</b></div>
                                    ";
                                    break;
                                }
                                case 2: {
                                    echo 
                                    "
                                        <div class = 'cosfa-message adminmsg'><span class = 'fa fa-info' aria-hidden = 'true'></span><br>Mensaje para miembros del plantel: <br>{$rows2['txt']}<br><br><b style = 'text-align: right;'>- {$rows2['teacher']}</b></div>
                                    ";
                                    break;
                                }
                            }
                            
                        }
                        echo "</div>";
                    }   
                ?>
                <!--Carousel img sizes: 1024x600 px-->
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                  </ol>

                  <!-- Wrapper for slides -->
                  <div class="carousel-inner" role="listbox" style = "width: 100%; height: 100%;">
                    <div class="item active">
                      <img src="img/cosfaedificio.jpg" alt="Parte de entrada - COSFA" style = "width: 100%; height: 100%;">
                      <div class="carousel-caption">
                        <h3>Colegio San Francisco de Asís</h3>
                        <p>Evangelización que educa.</p>
                      </div>
                    </div>

                    <div class="item">
                      <img src="img/cosfaedicio-atras.jpg" alt="Parte trasera - COSFA" style = "width: 100%; height: 100%;">
                      <div class="carousel-caption">
                        <h3>Colegio San Francisco de Asís</h3>
                        <p>Paz y bien.</p>
                      </div>
                    </div>

                    <div class="item">
                      <img src="img/11.jpg" alt="Grado 11 - COSFA" style = "width: 100%; height: 100%;">
                      <div class="carousel-caption">
                        <h3>Colegio San Francisco de Asís</h3>
                        <p>Comprometidos con una educación de calidad.<br>Promoción 48 del 2017</p>
                      </div>
                    </div>

                  <!-- Left and right controls -->
                  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
                <!--img src = "img/cosfaedificio.jpg" width = "1100px" height = "480px" class = "img-rounded img-responsive"/-->
                <br>
                <br>
                <br>
                <br>
                <div class = "col-lg-6 text-center">
                    <h4>¿Por qué fue escogido Student School Manager?</h4>
                    <hr>
                    <br>
                    <img src = "img/logo.png" height = "350px"/>
                    <br><br>
                    <p style = "text-align:justify;">Student School Manager es un proyecto iniciado por los estudiantes Andrés Felipe Estupiñán Peláez y Carlos Morales Ramírez para una forma de contribución al Colegio San Francisco de Asís. Contiene una serie de tecnologías que permitirán un mejor rendimiento en el desarrollo del observador de esta institución educativa. Para más información, visite el siguiente 
                    <a href="about">enlace.</a></p>
                </div>
                <div class = "col-lg-6 text-center">
                    <img src = "img/cosfa.png" width = "210px" height = "210px"/>
                    <h4  style = "font-style: italic;">Misión del Colegio San Francisco de Asís</h4>
                    <hr>
                    <br>
                    <p style = "text-align: justify; padding-left: 60px; padding-right: 60px;">Educamos con estilo Francisco a estudiantes comprometidos con el desarrollo sostenible y la ciudadania global.</p>
                    <br>
                    <h4 style = "font-style: italic;">Visión del Colegio San Francisco de Asís</h4>
                    <hr>
                    <br>
                    <p style = "text-align: justify; padding-left: 60px; padding-right: 60px;">Al año 2018, seremos reconocidos por la proyección de estudiantes transformadores de la realidad económica, social y ambiental.</p>
                </div>
            </div>
            <!--div class = "col-lg-12 text-center">
                <h1>¿Qué contiene nuestro programa?</h1>
                <hr>
                <ul style = "margin: 0px; padding: 0px; text-align: justify;">
                    <li>Sistema de registro e inicio de sesión para los miembros de la institución.</li>
                    <li>Sistematización del observador dentro de la institución educativa.</li>
                    <li>Sistematización de las observaciones realizadas.</li>
                    <li>Identificación de los grados de cada uno de los estudiantes para llevar un control.</li>
                    <li>Permitir una impresión de los informes para también llevar un control físico para los padres de familia.</li>
                </ul>
            </div-->
            <div class = "col-lg-12 text-center">
                <h1>¿Qué contiene SS Manager?</h1>
                <hr>
                <div class = "col-lg-6 zoom-inxd" style = "background-color: #fb758c; color: #FFFFFF; padding: 35px; font-weight: light;">
                    <span class = "fa fa-user-o" aria-hidden = "true" style = "font-size: 72pt;"></span><br><br>
                    <h4>Sistema de registro e inicio de sesión para miembros de la administación de la institución educativa.</h4>
                </div>
                <div class = "col-lg-6 zoom-inxd" style = "background-color: #29a329; color: #FFFFFF; padding: 35px; font-weight: light;">
                    <span class = "fa fa-address-book" aria-hidden = "true" style = "font-size: 72pt;"></span><br><br>
                    <h4>Control de observaciones de los estudiantes de cada grado de la institución.</h4>
                </div>
                <div class = "col-lg-6 zoom-inxd" style = "background-color: #80aaff; color: #FFFFFF; padding: 35px; font-weight: light;">
                    <span class = "fa fa-print" aria-hidden = "true" style = "font-size: 72pt;"></span><br><br>
                    <h4>Impresión de informes de observador para también un control de físico usado para los padres de familia.</h4>
                </div>
                <div class = "col-lg-6 zoom-inxd" style = "background-color: #ff884d; color: #FFFFFF; padding: 35px; font-weight: light;">
                    <span class = "fa fa-users" aria-hidden = "true" style = "font-size: 72pt;"></span><br><br>
                    <h4>Llevar un control de los grados de la institución educativa, para asegurar una buena educación.</h4>
                </div>
            </div>
            <div class = "col-lg-12 text-center">
                <h2>Himno del Colegio San Francisco de Asís</h2>
                <br>
                <p>[Coro]<br>
                Entonemos un canto a la ciencia<br>
                en las aulas del pobre de Asís.<br>
                Conquistemos virtud y deporte<br>
                coronados con flores de lis.<br><br><br>I<br>
                <br>
                Extraer de la ciencia el tesoro<br>
                de estudiantes es noble deber<br>
                de Francisco a la sombra paterna<br>
                que nos brinda triunfar en laurel<br><br><br>II<br>
                <br>
                Cuando el sol las montañas corona<br>
                de radiente hermosura y de luz,<br>
                nos invita al estudio constante<br>
                de los libros al pie de la cruz (bis)
                </p>
                <p>Letra por: Fr. Tarsicio de Sapuyes, O.F.M Cap</p>
                <p>Música por: Fr. Francisco Luis Garcia S., O.F.M Cap</p>
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
            /*-webkit-filter: blur(2px);*/
        }

        .carousel {
            min-width: 100%;
            min-height: 100%;
        }

        .zoom-inxd {
            border: transparent 2px solid;
            transition: all 0.3s;
        }
         .zoom-inxd:hover {
            transform: scale(1.05, 1.05);
            z-index: 5;
            box-shadow: 0px 0px 120px #000;
            background-color: #FFF !important;
            color: #126a19 !important;
            border-color: #126a19;
         }

         .zoom-inxd:hover {
            color: black;
            font-weight: bold;

         }
    </style>
</body>

</html>
