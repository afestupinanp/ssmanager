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
            <div class = "col-lg-12 text-center">
                <form id = "wow" method = "GET">
                    <h1>Buscar y modificar un miembro del sistema</h1>
                    <hr>
                    <p style = "text-align: justify;">Al modificar o eliminar un miembro del sistema, la persona que este usando esa cuenta al momento de la eliminación deberá de salir de la página o refrescar la página para ver los cambios.</p>
                    <label for = "user1">Nombre de usuario:</label><br>
                    <input type = "text" id = "user1" name = "user1" placeholder = "Nombre de usuario del miembro" required><br><br>
                    <input type = "submit" id = "subm" value = "Buscar miembro">
                </form>
            </div>
            <?php
                if($_GET) {
                    mysql_connect("db", "root", "") or die(mysql_error());
                    mysql_set_charset("utf8");
                    mysql_select_db("ssmanager");
                    $result = mysql_query("SELECT * FROM `accounts` WHERE `realname` = '{$_GET['user1']}'") or die(mysql_error());
                    if(mysql_num_rows($result) >= 1) {
                        $rows = mysql_fetch_array($result, MYSQL_ASSOC);
                        $imagen = null;
                        if(file_exists("img/profiles/{$rows['id']}.jpg")) {
                            $imagen = "<img src = 'img/profiles/{$rows['id']}.jpg' width = '150px' height = '150px' style = 'border-radius: 360px;'><br>";
                        }
                        else $imagen = "<img src = 'img/usertemp.png' width = '150px' height = '150px' style = 'border-radius: 360px;'><br>";
                        echo 
                        "
                            <form method = 'POST' id = 'wow2' action = 'modifyprofile.php'>
                            <div class = 'col-lg-12 text-center' style = 'margin-top: 25px; height: 500px;'>
                                <h1>{$rows['realname']} ({$rows['username']})</h1><br><br><br>
                                    <div class = 'col-lg-4' style = 'height: 350px;'>
                                        $imagen
                                        <label for = 'a1'>Nombre de usuario:</label><br>
                                        <input id = 'a1' type = 'text' name = 'username' value = '{$rows['username']}' required><br><br>
                                        <label for = 'a2'>Nombre:</label><br>
                                        <input id = 'a2' type = 'text' name = 'realname' value = '{$rows['realname']}' required><br><br>
                                        Color de énfasis: <input type = 'color' name = 'color' value = '{$rows['color']}'><br><br>
                                    </div>
                                    <div class = 'col-lg-8' style = 'height: 350px;'>
                                        <label for = 'descripcion'>Descripción del perfil:</label><br>
                                        <textarea maxlength = '1500' id = 'descripcion' name = 'description' form = 'wow2' placeholder = 'Descripción del perfil' required>{$rows['description']}</textarea>
                                        <label for = 'whatispasword'>Contraseña:</label><br>
                                        <input type = 'text' id = 'whatispasword' name = 'pass' maxlength = '24' value = '{$rows['pswd']}'><br>
                                        <label for = 'lookinggrass'>Rol en la institución:</label><br>
                                        <select for = 'wow2' name = 'rol'>
                                            <option value = 'Docente'>Docente (Miembro)</option>
                                            <option value = 'Administrador'>Coordinador (Administrador)</option>
                                        </select>
                                    </div>
                                
                            </div>
                            <div class = 'col-lg-12 text-center' style = 'margin-top: 75px;'>
                                <input type = 'submit' value = 'Modificar perfil' id = 'subm'>
                                </form>
                                <a href = 'javascript:void(0);' class = 'boton' onclick = 'aaaa({$rows['id']});'>Eliminar perfil</a>
                            </div>
                            
                        ";
                    }
                    else {
                        echo "<p style = 'color: red; text-align: center;'>La cuenta que estás buscando no existe. Asegurate de haber escrito correctamente su nombre de usuario o nombre.</p>";
                    }
                }
            ?>
        </div>
        <!-- /.row -->
        <?php
            require('css/design/foot.php');
        ?>
    <style>
        textarea {
            width: 100%;
            resize: none;
            height: 210px;
        }


    </style>
    <script>
        function aaaa(usuario) {
            var confirmame = confirm("Al eliminar perfil, las acciones que haya realizado el dueño del perfil quedarán guardadas todavía, pero no se podrá volver a acceder a su cuenta. Ésta acción es irreversible. ¿Estás seguro de hacer esto?");
            if(confirmame == true) {
                window.location.assign("deleteprofile.php?userid=" + usuario);
                console.log("FUNCIONO");
            }
            else console.log("NO FUNCIONO");
        }
    </script>
    </div>
    <!-- /.container -->
    <!-- jQuery Version 1.11.1 -->

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>
</html>
