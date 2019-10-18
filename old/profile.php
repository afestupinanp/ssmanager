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
    <script src="js/jquery.js"></script>
    <!-- Custom CSS -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <?php
        require('css/design/nav.php');
        if(!isset($_SESSION['username']))
        {
            header("Location: login.php");
        }
        $username = $_SESSION['username'];
        $_SESSION['errores'] = 0;
        mysql_connect('db', 'root', '');
        if(mysql_errno() != 0)
        {
            die(mysql_error());
        }
        mysql_select_db('ssmanager');
        $result = mysql_query("SELECT * FROM `accounts` WHERE `username` = '$username';") or die(mysql_error());
        if(mysql_num_rows($result) >= 1)
        {
            $rows = mysql_fetch_array($result, MYSQL_ASSOC);
            $description = $rows['description'];
            $role = $rows['role'];

            mysql_free_result($result);
        }
    ?>
    <!-- Page Content -->
    <div class="container">
        <a href="#" id="back-to-top" title="Back to top">&uarr;</a>
        <div class="row">
            <form method = "GET" id = "desc" class = "form-group">
            <div class="col-lg-12">
                <?php
                    $user = $_SESSION['username'];
                    $name = $_SESSION['realname'];
                    echo "<h1>$name ($user)</h1>";
                ?>
                <br>
                <div class = "col-lg-3">
                    <img src = "img/usertemp.png" style = "outline-color: #000; outline: 1px solid;" width = "150px" height = "150px"/><br><br>
                    <div class = "dropdown">
                        <?php
                            echo "<p>Rol en la institución: <i>$role</i></p>";
                        ?>
                        <a href = "javascript:void(0);" class = "dropdown-toggle" data-toggle = "dropdown"><i class="fa fa-cog" aria-hidden="true" style = "font-size: 14pt;"></i></a>&nbsp;&nbsp;Haz click en el engranaje para ver opciones de perfil.
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0);" onclick = "displayDiv(0);">Cambiar descripción</a></li>
                            <li><a href="javascript:void(0);" onclick = "displayDiv(1);">Cambiar imagen de perfil</a></li>
                            <li><a href="javascript:void(0);" onclick = "displayDiv(2);">Cambiar color de barra de navegación</a></li>
                      </ul>
                      <br>
                        <input id = "subm" type = "submit" name = "btn" value = "Guardar cambios"/>
                        <?php
                        if($_GET)
                        {
                            if($_GET['btn'] == "Guardar cambios")
                            {
                                $_SESSION['color'] = $_GET['colors'];
                                $description = $_GET['descript'];
                                $fadecolor = $_SESSION['color'];
                                echo '
                                    <script>
                                        alert("Los cambios se han guardado.");
                                        $(document).ready (function() {
                                            $(".navbar.navbar-inverse.navbar-fixed-top").css("background-color", "'.$fadecolor.'");
                                            $("ul.nav.navbar-nav li a").css("border-bottom-color", "'.$fadecolor.'");
                                        });
                                        
                                    </script>
                                ';
                                $result = mysql_query("UPDATE `accounts` SET `color`= '$fadecolor', `description` = '$description' WHERE `username` = '$username'") or die(mysql_error());
                            }
                        }
                    ?>
                    </div>
                </div>
                <div class = "col-lg-9" style = "float: right;">
                    <div class = "col-lg-9 text-center" style = "display: block;" id = "description">
                        <label for = "descript"><h4 style = "text-align: right;">Cambiar descripción: </h4></label>
                        <hr>
                            <?php
                                echo "
                                    <textarea maxlength = '1500' name = 'descript' id = 'descript' form = 'desc' class = 'txtarea'>$description</textarea>
                                ";
                            ?>
                    </div>
                    <div class = "col-lg-9 text-center" style = "display: none;" id = "image-profile">
                        <label for = "desc"><h4 style = "text-align: right;">Cambiar Imagen de perfil: </h4></label>
                        <hr>
                            <p>Próximamente</p>
                    </div>
                    <div class = "col-lg-9 text-center" style = "display: none;" id = "color-palette">
                        <label for = "color"><h4 style = "text-align: right;">Cambiar color de la barra navegación: </h4></label>
                        <hr>
                            <?php
                                $color = $_SESSION['color'];
                                echo "<input type='color' id = 'color' name = 'colors' value = '$color'/><br><br><br>";
                            ?>
                            <p style = "text-align: justify;">Para cambiar el color de la barra de navegación, toca o haz click sobre el recuadro de color. Ten en cuenta que este color solo lo verás tu y solo tiene un aporte meramente estético. Se recomiendan colores opacos/claros oscuros para una mejor experiencia del usuario.</p>
                    </div>
                </div>
                </form>
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

</style>
<script>
    function displayDiv(div)
    {
        switch(div)
        {
            case 0:
            {
                document.getElementById("description").style = "display: block;";
                document.getElementById("image-profile").style = "display: none;";
                document.getElementById("color-palette").style = "display: none;";
                break;
            }
            case 1:
            {
                document.getElementById("description").style = "display: none;";
                document.getElementById("image-profile").style = "display: block;";
                document.getElementById("color-palette").style = "display: none;";
                break;
            }
            case 2:
            {
                document.getElementById("description").style = "display: none;";
                document.getElementById("image-profile").style = "display: none;";
                document.getElementById("color-palette").style = "display: block;";
                break;
            }
        }
    }
</script>
</html>
</html>
