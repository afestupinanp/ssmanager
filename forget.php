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
    <title>Contraseña perdida - SS Manager</title>

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
            <div class = "col-lg-12 text-center">
                <center><h1>Recuperación de contraseña</h1></center>
                <hr>
                <p style = "text-align: justify;">Durante el proceso de recuperación de contraseña, debes de saber el nombre de la cuenta que deseas recuperar y el nombre de la persona dueña de la cuenta, junto con su número de identificación. Si no sabes estos datos, <a href = "index.php">vuelve al inicio</a> o <a href = "login.php">vuelve al inicio de sesión.</a></p>
                <p style = "font-weight: bold; text-align: justify;">IMPORTANTE: Su contraseña será restablecida en el proceso, y tendrás que cambiarla al iniciar sesión.</p>
                <form class = "form-group" method = "POST">
                    <div class = "col-lg-12">
                        <label for = "xD1">Nombre de usuario:</label>
                        <input type = "text" name = "usern" placeholder = "Nombre de usuario" id = "xD1" required/>

                        <label for = "xD2">Nombre real:</label>
                        <input type = "text" name = "realna" placeholder = "Nombre" id = "xD2" required/>
                        <br><br>
                        <label for = "xD3">Número de identificación:</label>
                        <input type = "number" name = "identifi" placeholder = "xxxxxxx" id = "xD3" required/>
                    </div>
                    <div class = "col-lg-12" style = "padding-top: 15px;">
                        <input type = "submit" id = "subm" name = "btn" value = "Recuperar contraseña"/>
                    </div>
                </form>
                <?php
                    if($_POST)
                    {
                        mysql_connect("db", "root", "") or die(mysql_error());
                        mysql_select_db("ssmanager");
                        mysql_set_charset("utf8");
                        $result = mysql_query("SELECT * FROM `accounts` WHERE `username` = '{$_POST['usern']}'") or die(mysql_error());
                        if(mysql_num_rows($result) >= 1) 
                        {
                            $rows = mysql_fetch_array($result, MYSQL_ASSOC);
                            if($rows['realname'] == $_POST['realna'] && $rows['identificacion'] == $_POST['identifi']) 
                            {
                                $letters = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
                                $pswd = $letters[rand(0, 25)] . rand(0, 9) . $letters[rand(0, 25)] . $letters[rand(0, 25)] . $letters[rand(0, 25)] . rand(0, 9) . $letters[rand(0, 25)] . $letters[rand(0, 25)] . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
                                echo "<p><span style = 'color: blue;'>(Preliminar)</span> Su nueva contraseña es <b>$pswd</b>. Recuerda que deberás de cambiarla al <a href = 'login.php'>iniciar sesión.</a></p>";
                                mysql_query("UPDATE `accounts` SET `pswd` = '$pswd', `changepswd` = 1 WHERE `username` = '{$_POST['usern']}';") or die(mysql_error());
                                unset($letters);
                                unset($pswd);
                            }
                            else echo "<p style = 'color: red;'>Uno o más campos no coinciden con los de la cuenta.</p>";
                        }
                        else
                        {
                            echo "<p style = 'color: red;'>El usuario específicado no existe.</p>";
                        }
                        mysql_free_result($result);
                        mysql_close();
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
