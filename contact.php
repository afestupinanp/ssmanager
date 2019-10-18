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
    <title>Pedir una cita - SS Manager</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CSS -->
    <link href = "css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href = "css/cosfa.css" rel = "stylesheet" type = "text/css">
    <script src='https://www.google.com/recaptcha/api.js'></script><!--Google's reCAPTCHA' -->
    
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
            <div class="col-lg-12 text-center">
                <h1>Contactar a un miembro de la institución</h1>
                <center><form id = "cosfa-contact" class = "cosfa-register" method = "POST">
                    <div class="col-lg-6 text-center">
                        <div class = "form-group">
                            <label for = "mail">Correo electrónico:</label><br>
                            <input type = "email" placeholder = "Correo electrónico" id = "mail" name = "mail" required/>
                        </div>
                        <div class = "form-group">
                            <label for = "nmbrid">Teléfono fijo:</label><br>
                            <input type = "number" placeholder = "1234567" id = "nmbrid" name = "nmbr" required/>
                        </div>
                        <div class = "form-group">
                            <label for = "teacher">Profesor(a) a contactar:</label>
                            <!--input type = "text" placeholder = "Nombre de profesor(a)" id = "teacher" name = "teacher" required/-->
                            <?php
                                mysql_connect("db", "root", "") or die(mysql_error());
                                mysql_select_db("ssmanager");
                                mysql_set_charset("utf8");
                                $result = mysql_query("SELECT * FROM `accounts` WHERE 1") or die(mysql_error());
                                if(mysql_num_rows($result) >= 1)
                                {
                                    echo "<select name = 'teacher' form = 'cosfa-contact' required>
                                          <option value = 'null'>Selecciona un(a) miembro(a) de la institución</option>";
                                    while($rows = mysql_fetch_array($result, MYSQL_ASSOC))
                                    {
                                        $name = $rows['realname'];
                                        $role = $rows['role'];
                                        echo "<option value = '$name'>$name ($role)</option>";
                                    }
                                    echo "</select>";
                                }
                                else echo "<p style = 'color: red; font-size: 7pt;'>La lista de profesores no está disponible. Intentelo más tarde.</p>";
                                mysql_free_result($result);
                                mysql_close();
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center">
                        <div class = "form-group">
                            <label for = "area">Mensaje para la persona a contactar (opcional):</label><br>
                            <textarea id = "area" form = "cosfa-contact" class = "txtarea" name = "msg"></textarea>
                        </div>
                    </div>
                    <div class = "col-lg-12 text-center">
                        <div class = "form-group">
                            <input type = "submit" value = "Contactar" id = "subm"/>
                        </div>
                        <div class = "form-group">
                            <center><div class="g-recaptcha" data-sitekey="6Ldu-hkUAAAAAI3NwWit5bjNCrqvwLA0Tqlk7MFE"></div></center>
                        </div>
                    </div>
                    <?php
                        if($_POST)
                        {
                            $key = "6Ldu-hkUAAAAAPNYlvh5h3w4lTRchQDqupZvm3Jw";
                            $ip = $_SERVER['REMOTE_ADDR'];
                            $captcha = $_POST['g-recaptcha-response'];
                            $response =  file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$key&response=$captcha&remoteip=$ip");
                            $arr = json_decode($response, true);
    
                            if($arr["success"])
                            {
                                $correo = $_POST['mail'];
                                $number = $_POST['nmbr'];
                                $teacher = $_POST['teacher'];
                                if($teacher == 'null')
                                {
                                    echo "<p style = 'color: red;'>Selecciona una opción de lista.</p>";
                                }
                                else
                                {
                                    if(empty($_POST['msg']))
                                    {
                                        $message = "No se especificó ningún mensaje.";
                                    }
                                    else
                                    {
                                        $message = $_POST['msg'];
                                    }
                                    mysql_connect('db', 'root', '') or die(mysql_error());
                                    mysql_select_db('ssmanager');
                                    mysql_set_charset("utf8");
                                    $query = "INSERT INTO `dates` (`date`, `email`, `number`, `teacher`, `message`) VALUES (DATE_FORMAT(NOW(), '%d/%c/%Y | %h:%i:%s %p'), '$correo', '$number', '$teacher', '$message');";
                                    mysql_query($query) or die(mysql_error());
                                    mysql_close();
                                    echo 
                                    "
                                        <script>
                                            //alert('Su petición de cita ha sido enviada al profesor $teacher para que sea revisado. Este pendiente a su bandeja de correo electrónico para el aviso de la confirmación de su cita por el miembro de la institución. Gracias.');
                                            $( function() {
                                                $('#dialog').dialog();
                                            } );
                                        </script>
                                        <div id = 'dialog' title = 'Cita enviada'>
                                            <p>
                                            Su petición de cita ha sido enviada al profesor <b><i>$teacher</i></b> para que sea revisado. Este pendiente a su bandeja de correo electrónico para el aviso de la confirmación de su cita por el miembro de la institución.<br><br>Gracias.
                                            </p>
                                        </div>
                                    ";
                                }
                            }
                            else echo "<p style = 'color: red;'>Debes de haber aceptado el CAPTCHA para poder realizar la petición de cita.</p>";
                        }
                    ?>
                </form></center>
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
        width: 100%;
    }
    .txtarea {
        resize: none;
        width: 100%;
        height: 220px;
    }

    .col-lg-6.text-center {
        height: 320px;
    }

</style>
</html>
