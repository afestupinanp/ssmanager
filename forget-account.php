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
    <title>Cuenta perdida - SS Manager</title>

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
                <center><h1>Recuperación de cuenta</h1></center>
                <hr>
                <p style = "text-align: justify;">Durante el proceso de recuperación de tu cuenta, debes de escribir el nombre del dueño de la cuenta, su número de identificación y un correo de reemplazo. Por lo que allí recibirás el nombre de tu cuenta y una contraseña temporal que debes de cambiar después de iniciar sesión.</p>
                <form class = "form-group" method = "POST">
                    <div class = "col-lg-12">
                        <label for = "xD1">Nombre real:</label>
                        <input type = "text" name = "realna" placeholder = "Nombre" id = "xD1" required/>

                        <label for = "xD3">Número de identificación:</label>
                        <input type = "number" name = "identifi" placeholder = "xxxxxxx" id = "xD3" required/>
                        
                        <br><br>
                        
                        <label for = "xD2">Correo electrónico:</label>
                        <input type = "email" name = "mail" placeholder = "ejemplo@ejemplo.com" id = "xD2" required/>
                    </div>
                    <div class = "col-lg-12" style = "padding-top: 15px;">
                        <input type = "submit" id = "subm" name = "btn" value = "Recuperar cuenta"/>
                    </div>
                </form>
                <?php
                    if($_POST)
                    {
                        mysql_connect("db", "root", "") or die(mysql_error());
                        mysql_select_db("ssmanager");
                        mysql_set_charset("utf8");
                        $result = mysql_query("SELECT * FROM `accounts` WHERE `realname` = '{$_POST['realna']}';") or die(mysql_error());
                        if(mysql_num_rows($result)) 
                        {
                            $rows = mysql_fetch_array($result, MYSQL_ASSOC);
                            if($rows['recuperacion'] == $_POST['mail'] && $rows['identificacion'] == $_POST['identifi'])
                            {
                                echo "<p><span style = 'color: blue;'>(Preliminar)</span> Su cuenta es {$rows['username']} y la respectiva contraseña de la cuenta es {$rows['pswd']}. <a href = 'login.php'>Volver al inicio de sesión.</a></p>";
                            }
                            else echo "<p style = 'color: red;'>Uno o más campos no coinciden con los de la cuenta.</p>";
                        }
                        else echo "<p style = 'color: red;'>Esta cuenta no existe.</p>";
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
