<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="No.">
    <meta name="author" content="COSFA, Carlos Morales, Andrés Estupiñán">
    <link rel="icon" type="image/png" href="img/cosfa.png">
    <title>Modificar miembros - SS Manager</title>

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
        
        if(!isset($_SESSION) || $_SESSION['permission'] != 2)
        {
            header("Location: login");
        }
    ?>
    <!-- Page Content -->
    <div class="container main">
        <div class="row">
            <center><form class = "cosfa-register" method = "POST">
                <h1>Buscar y modificar un miembro en el sistema</h1>
                <hr>
                <br>
                <div class = "form-group">
                    <div class = "col-lg-12 text-center">
                        <label for = "user">Nombre de usuario o nombre real:</label><br>
                        <input type = "text" placeholder = "Nombre de usuario o nombre real" id = "user" name = "user" required/><br><br>
                        <input type = "submit" id = "subm" name = "btn" value = "Buscar el perfil de usuario">
                    </div>
                    <br>
                    <br>
                </form></center>
                    <?php
                        if(isset($_POST['btn']))  
                        {
                            mysql_connect("db", "root", "") or die(mysql_error());
                            mysql_select_db("ssmanager");
                            mysql_set_charset("utf8");
                            $nombre = $_POST['user'];
                            $resultado = mysql_query("SELECT * FROM `accounts` WHERE `username` = '$nombre'") or die(mysql_error());
                            if(mysql_num_rows($resultado) >= 1)
                            {
                                $rows = mysql_fetch_array($resultado);
                                $id = $rows['id'];
                                $_SESSION['modifying'] = $id;

                                $usuario = $rows['username'];
                                $nombre = $rows['realname'];
                                $description = $rows['description'];
                                $contra = $rows['pswd'];
                                $color = $rows['color'];
                                $rol = $rows['role'];
                                    echo 
                                        "
                                            <center><h2>$nombre ($usuario)</h2>
                                            <br>
                                            <hr>
                                            <div class = 'col-lg-12'>
                                                <form class = 'form-group' id = 'modificarxd' method = 'POST' action = 'modifyprofile.php'>
                                                    <div class = 'col-lg-12'>
                                                        <label for = 'mister'>Nombre real:</label>
                                                        <input type = 'text' value = '$nombre' id = 'mister' name = 'realname'/>

                                                        <label for = 'usern'>Nombre de usuario:</label>
                                                        <input type = 'text' value = '$usuario' id = 'usern' name = 'username'/>

                                                        <label for = 'contra'>Contraseña:</label>
                                                        <input type = 'text' value = '$contra' id = 'contra' name = 'pass'/>
                                                    </div>
                                                    <br>
                                                    <div class = 'col-lg-12'>
                                                        <label for = 'role'>Rol en la institución:</label>
                                                        <input type = 'text' value = '$rol' id = 'role' name = 'rol'/>

                                                        <label for = 'bcolor'>Color de barra de navegación:</label>
                                                        <input type = 'color' id = 'bcolor' name = 'bcolor' value = '$color'/>

                                                    </div>
                                                    <br>
                                                    <div class = 'col-lg-12' style = 'padding-top: 25px;'>
                                                        <label for = 'descript'>Descripción (máximo 1500 carácteres):</label>
                                                        <br>
                                                        <textarea id = 'descript' form = 'modificarxd' maxlength = '1500' name = 'description'>$description</textarea>
                                                    </div>
                                                    <br>
                                                    <div class = 'col-lg-12' style = 'padding-top: 25px;'>
                                                        <input type = 'submit' id = 'subm' name = 'modify' value = 'Modificar'/>
                                                        <input type = 'submit' id = 'subm' name = 'delete' value = 'Eliminar'/>
                                                    </div>
                                                </form>
                                            </div></center>
                                        ";
                                    mysql_free_result($resultado);
                                    unset($rows);
                            }
                            else 
                            {
                                mysql_free_result($resultado);
                                $resultado = mysql_query("SELECT * FROM `accounts` WHERE `realname` = '$nombre'");
                                if(mysql_num_rows($resultado) >= 1)
                                {
                                    $rows = mysql_fetch_array($resultado);
                                    $id = $rows['id'];
                                    $_SESSION['modifying'] = $id;

                                    $usuario = $rows['username'];
                                    $nombre = $rows['realname'];
                                    $description = $rows['description'];
                                    $contra = $rows['pswd'];
                                    $color = $rows['color'];
                                    $rol = $rows['role'];
                                    echo 
                                        "
                                            <center><h2>$nombre ($usuario)</h2>
                                            <br>
                                            <hr>
                                            <div class = 'col-lg-12'>
                                                <form class = 'form-group' id = 'modificarxd' method = 'POST' action = 'modifyprofile.php'>
                                                    <div class = 'col-lg-12'>
                                                        <label for = 'mister'>Nombre real:</label>
                                                        <input type = 'text' value = '$nombre' id = 'mister' name = 'realname'/>

                                                        <label for = 'usern'>Nombre de usuario:</label>
                                                        <input type = 'text' value = '$usuario' id = 'usern' name = 'username'/>

                                                        <label for = 'contra'>Contraseña:</label>
                                                        <input type = 'text' value = '$contra' id = 'contra' name = 'pass'/>
                                                    </div>
                                                    <br>
                                                    <div class = 'col-lg-12'>
                                                        <label for = 'role'>Rol en la institución:</label>
                                                        <input type = 'text' value = '$rol' id = 'role' name = 'rol'/>

                                                        <label for = 'bcolor'>Color de barra de navegación:</label>
                                                        <input type = 'color' id = 'bcolor' name = 'bcolor' value = '$color'/>

                                                    </div>
                                                    <br>
                                                    <div class = 'col-lg-12' style = 'padding-top: 25px;'>
                                                        <label for = 'descript'>Descripción (máximo 1500 carácteres):</label>
                                                        <br>
                                                        <textarea id = 'descript' form = 'modificarxd' maxlength = '1500' name = 'description'>$description</textarea>
                                                    </div>
                                                    <br>
                                                    <div class = 'col-lg-12' style = 'padding-top: 25px;'>
                                                        <input type = 'submit' id = 'subm' name = 'modify' value = 'Modificar'/>
                                                        <input type = 'submit' id = 'subm' name = 'delete' value = 'Eliminar'/>
                                                    </div>
                                                </form>
                                            </div></center>
                                        ";
                                        mysql_free_result($resultado);
                                        unset($rows);
                                }
                                else 
                                {
                                    mysql_free_result($resultado);
                                    echo "
                                        <div class = 'col-lg-12' style = 'padding-top: 15px;'>
                                            <p style = 'color: red; text-align: center;'>La cuenta que se está buscando no existe, se buscó por nombre de usuario y por nombre real de la cuenta.</p>
                                        </div>
                                    ";
                                }
                            }
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
<style>
    .col-lg-4 {
        padding-top: 25px;
        padding-bottom: 25px;
    }
    textarea {
        width: 100%;
        height: 200px;
        resize: none;
    }

    .cosfa-register::before, .cosfa-register::after {
        padding-top: 10px;
        padding-bottom: 10px;
        content: " ";
        height: 0;
        clear: both;
    }
</style>
</html>
