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
    <title>Citas pendientes - SS Manager</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CSS -->
    <link href = "css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="css/cosfa.css">

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
        if(isset($_SESSION['username']))
        {
            if($_SESSION['permission'] < 1)
            {
                header("Location: index.php");
            }
            mysql_connect("db", "root", "") or die(mysql_error());
            mysql_select_db("ssmanager");
            mysql_set_charset("utf8");
        }
        else header("Location: login.php");
    ?>
    <!-- Page Content -->
    <div class="container main">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>Citas pendientes</h1>
                <hr>
                <p style = "text-align: justify;">En está página podrás consultar las citas pendientes que tengas con los padres de familia. Se mostrará la fecha en la cual se pidió la cita y se estará filtrando por más recientes.</p>
                <p><?php $username = $_SESSION['realname']; $result = mysql_query("SELECT * FROM `dates` WHERE `teacher` = '$username'") or die(mysql_error()); $citas = mysql_num_rows($result); echo "En este momento, tienes $citas pendientes."; mysql_free_result($result);?></p>
                </center>
            </div>
            <div class="col-lg-12 text-center">
                <?php
                    $result = mysql_query("SELECT * FROM `dates` WHERE `teacher` = '$username' ORDER BY `date`;") or die(mysql_error());
                    echo "<br>";
                    if(mysql_num_rows($result) >= 1)
                    {
                        echo "
                            <center><div class = 'table-responsive'><table class = 'table'>
                            <tr>
                                <th>Fecha de petición de cita<br>(DD-MM-AA)</th>
                                <th>Correo electrónico</th>
                                <th>Teléfono fijo</th>
                                <th>Mensaje de contacto</th>
                                <th>Opciones de cita</th>
                            </tr>
                        ";
                        while($rows = mysql_fetch_array($result, MYSQL_ASSOC))
                        {
                            $date = $rows['date'];
                            $correo = $rows['email'];
                            $numero = $rows['number'];
                            $message = $rows['message'];
                            echo "
                                <tr>
                                    <td>$date</td>
                                    <td>$correo</td>
                                    <td>$numero</td>
                                    <td>$message</td>
                                    <td><button class = 'chido' onclick = 'window.location.assign(\"mailto:{$rows['email']}\");'>Responder cita</button> | <button class = 'chido' onclick = 'deleteCita({$rows['cita']})'>Eliminar cita</button></td>
                                </tr>
                            ";
                        }
                        echo "</table></div></center>";
                    }
                    else echo "<p>En este momento, no hay citas disponibles para ti. Intentalo más tarde.</p>";
                ?>
            </div>
        </div>
        <!-- /.row -->
        <?php
            require('css/design/foot.php');
            echo 
            "
                <script>
                    function deleteCita(citaid) {
                        var ch = confirm('¿Estás seguro de eliminar la cita? La persona no recibirá confirmación de esto.');
                        if(ch == true) {
                            window.location.assign('deletedate.php?dateid=' + citaid);
                        }
                    }
                </script>
            ";
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
        width: 400px;
        height: 220px;
    }

    .col-lg-6.text-center {
        height: 380px;
    }
    
    table {
        width: 100%;
    }
    
    td, th, tr { 
        border: 0.01mm black;
        text-align: center;
        padding-left: 5px;
        padding-right: 5px;
    }

    td {
        vertical-align: middle;
    }

    tr:nth-child(odd) {
        background-color: #CCC;
    }

</style>
<script>
    function show(showlol)
    {
        if(showlol == 1)
        {
            document.getElementById('tabla').style = "display: block;";
            document.getElementById('error').style = "display: block;";
        }
    }
</script>
</html>

