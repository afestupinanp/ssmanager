<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="No.">
    <meta name="author" content="COSFA, Carlos Morales, Andrés Estupiñán">
    <link rel="icon" type="image/png" href="img/cosfa.png">
    <title>Observador - COSFA</title>

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
        if(!isset($_SESSION['username']))
        {
            header("Location: login.php");
        }
    ?>
    <!-- Page Content -->
    <div class="container main">
        <div class="row">
            <div class = "col-lg-12 text-center" style = "padding-bottom: 30px;">
                <?php
                    mysql_connect("db", "root", "") or die(mysql_error());
                    mysql_select_db("ssmanager");
                    mysql_set_charset("utf8");
                    $result = mysql_query("SELECT * FROM `accounts` WHERE `username` = '{$_SESSION['username']}';") or die(mysql_error());
                    $rows = mysql_fetch_array($result);
                    echo 
                    "
                        <center><h1>{$rows['realname']} ({$rows['username']})</h1></center>
                        <hr>
                    ";
                ?>
                <div class = "col-lg-12">
                    <div class = "col-lg-3">
                        <img class = "img-profile" src = "img/usertemp.png" width = "150px" height = "150px" />
                        <p style = "text-align: center;">Rol en la institución: <?php echo "{$rows['role']}"; ?></p>
                        <p><?php $usuarsito = $_SESSION['realname']; $result = mysql_query("SELECT * FROM `dates` WHERE `teacher` = '$usuarsito'") or die(mysql_error()); $citas = mysql_num_rows($result); echo "Número de citas pendientes: $citas.<br><br>"; if($citas >= 1) { echo "Tienes más de una cita pendiente, para verlas más detalladamente haz <a href = 'dates.php'>click aqui.</a>"; } mysql_free_result($result);?></p>
                    </div>
                    <div class = "col-lg-1">
                        <div class = "dropdown">
                            <a href = "javascript:void(0);" class = "dropdown-toggle" data-toggle = "dropdown"><span class = "fa fa-cog" style = "padding-right: 10px;"></span></a>
                                <ul class="dropdown-menu profile">
                                    <li><a href="javascript:void(0);" onclick = "displayDiv(0);">Cambiar descripción</a></li>
                                    <li><a href="javascript:void(0);" onclick = "displayDiv(1);">Cambiar imagen de perfil</a></li>
                                    <li><a href="javascript:void(0);" onclick = "displayDiv(2);">Cambiar color de énfasis</a></li>
                                </ul>
                            </div>
                        </div>
                    <div class = "col-lg-8">
                        <form class = "form-group" id = "cambiarcosas" method = "POST">
                            <div class = "col-lg-12" id = "desc">
                                <label for = "description"><h4>Descripción del perfil:</h4></label>
                                <br>
                                <textarea form = "cambiarcosas" name = "description" maxlength = "1500" class = "txtarea" id = "supercripcion"><?php echo "{$rows['description']}";?></textarea>

                            </div>
                            <div class = "col-lg-12" id = "imgr" style = "display: none;">
                                <h4>Imagen del perfil:</h4>
                                <br>
                                <p>Próximamente, esta opción estará disponible para su uso.</p>
                                
                            </div>
                            <div class = "col-lg-12" id = "colr" style = "display: none;">
                                <h4>Color de la barra de navegación:</h4>
                                <br>
                                <?php echo "<input type = 'color' name = 'colorcillo' value = '{$rows['color']}'/>" ?>
                            </div>
                            <div class = "col-lg-12" style = "padding-top: 25px;">
                                <input type = "submit" id = "subm" name = "btn" value = "Modificar perfil"/>
                            </div>
                        </form>
                        <?php 
                            if($_POST)
                            {
                                $result = mysql_query("UPDATE `accounts` SET `color`= '{$_POST['colorcillo']}', `description` = '{$_POST['description']}' WHERE `username` = '{$_SESSION['username']}';") or die(mysql_error());
                                $_SESSION['color'] = $_POST['colorcillo'];
                                $fadecolor = $_POST['colorcillo'];
                                echo 
                                "
                                    <script>
                                        $(function() {
                                            $('#confirmation').dialog();
                                        });
                                        $(document).ready (function() {
                                            $('.navbar.navbar-inverse.navbar-fixed-top').css('background-color', '$fadecolor');
                                            $('ul.nav.navbar-nav li a').css('border-bottom-color', '$fadecolor');
                                            $('ul.dropdown-menu').css('background-color', '$fadecolor');
                                            $('.custom-button').css('border-bottom-color', '$fadecolor');

                                            $('#supercripcion').val('{$_POST['description']}');
                                        });
                                    </script>
                                    <div id = 'confirmation' title = 'Modificación de perfil exitosa'>
                                        <p>Tu perfil ha sido modificado correctamente.</p>
                                    </div>
                                ";
                                unset($_POST);
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class = "col-lg-12 text-center">
            	<div class = "cosfa-message adminmsg">
            		<p><span class = "fa fa-info" aria-hidden = "true"></span>Se recomienda que uses un color que sea adecuado para leer las letras de la barra de navegación.</p>
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
    .row {
        font-size: 11pt !important;
    }
    .col-lg-3 p {
        text-align: justify;
        padding-top: 15px;
    }
    input[type = "email"], input[type = "number"], input[type = "text"] {
        width: 480px;
    }
    .txtarea {
        resize: none;
        width: 100%;
        height: 270px;
    }

    .col-lg-6.text-center {
        height: 380px;
    }

    a {
        color: #AACCFF;
        font-weight: bold;
        transition: color 0.2s;
        text-decoration: none;
    }
    a:hover {
        color: #00CCFF;
    }

    .img-profile {
        outline-color: #000;
        outline: 1px solid;
    }

    .dropdown-menu a:hover {

    }

</style>
<script>
    function displayDiv(div)
    {
        switch(div)
        {
            case 0:
            {
                document.getElementById("desc").style = "display: block;";
                document.getElementById("imgr").style = "display: none;";
                document.getElementById("colr").style = "display: none;";
                break;
            }
            case 1:
            {
                document.getElementById("desc").style = "display: none;";
                document.getElementById("imgr").style = "display: block;";
                document.getElementById("colr").style = "display: none;";
                break;
            }
            case 2:
            {
                document.getElementById("desc").style = "display: none;";
                document.getElementById("imgr").style = "display: none;";
                document.getElementById("colr").style = "display: block;";
                break;
            }
        }
    }
</script>
</html>
</html>
