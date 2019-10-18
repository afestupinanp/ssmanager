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
    <title>Listado de grados - SS Manager</title>

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
        
        if(isset($_SESSION['username']))
        {
            if($_SESSION['permission'] < 1)
            {
                header("Location: index.php");
            }
        }
        else header("Location: login.php");
    ?>
    <!-- Page Content -->
    <div class="container main">
        <div class="row">
            <div class = "col-lg-12 text-center">
                <h1>Listado de grados</h1>
                <hr>
                <p>En esta página podrás crear un grado, asignar director del curso y añadir estudiantes a un grado.</p>
                <div class = 'col-lg-6'>
                    <h3>Crear un grado</h3>
                    <form id = 'gradelist' method = "POST">
                        <label for = 'grade'>Curso a añadir: (XX-AB)</label><br>
                        <input id = 'grade' type = "text" name = "grade" placeholder = "Grado" required><br>
                        <label>Director del curso:</label><br>
                        <?php
                                mysql_connect("db", "root", "") or die(mysql_error());
                                mysql_select_db("ssmanager");
                                mysql_set_charset("utf8");
                                $result = mysql_query("SELECT * FROM `accounts` WHERE 1") or die(mysql_error());
                                if(mysql_num_rows($result) >= 1)
                                {
                                    echo "<select name = 'director' form = 'gradelist' required>
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
                            <br><br>
                        <input type = "submit" name = 'botn' value = "Crear grado" id = "subm">
                    </form>
                    <?php
                        if($_POST) {
                            if(isset($_POST['grade']) && isset($_POST['director'])) {
                                mysql_connect("db", "root", "") or die(mysql_error());
                                mysql_select_db("ssmanager");
                                mysql_set_charset("utf8");
                                $result = mysql_query("SELECT * FROM `grades` WHERE `Grado` = '{$_POST['grade']}';");
                                if(mysql_num_rows($result) >= 1) {
                                    echo "<p style = 'color: red;'>El grado a ser agregado ya existe en nuestra base de datos.</p>";
                                    mysql_free_result($result);
                                }
                                else {
                                    mysql_query("INSERT INTO `grades` VALUES (null, '{$_POST['grade']}');") or die(mysql_error());
                                    mysql_query("UPDATE `accounts` SET `gradedirector` = '{$_POST['grade']}' WHERE `realname` = '{$_POST['director']}'") or die(mysql_error());
                                    mysql_close();
                                    echo 
                                    "
                                        <div id = 'dialog' title = 'Grado agregado'>
                                            <p>Se ha agregado el grado {$_POST['grade']}, y se ha asignado a {$_POST['director']} como director del grado creado. La página se refrescará en 3 segundos.</p>
                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                $('#dialog').dialog();
                                                window.setTimeout(confirmation, 4000);
                                            });
                                            function confirmation() {
                                                window.location.replace('grades');
                                            }
                                        </script>
                                    ";
                                }
                                
                            }
                        }
                    ?>
                </div>
                <div class = 'col-lg-6'>
                    <h3>Añadir estudiante</h3>
                    <form id = 'estudiantar' method = "POST" enctype="multipart/form-data">
                    <input type = "file" name = "foto" id = 'fotito' style = 'width: 0.1px;
                                                                                    height: 0.1px;
                                                                                    opacity: 0;
                                                                                    overflow: hidden;
                                                                                    position: absolute;
                                                                                    z-index: -1;'>
                        <label for = 'fotito'><span class = 'fa fa-upload' aria-hidden = 'true'><br>Foto del estudiante</span></label>
                        <p style = 'font-size: 8pt; padding-top: 25px; padding-left: 60px; padding-right: 60px; text-align: center;'>Solo se admiten formatos JPG de máximo 1MB de tamaño.</p>
                        <label>Grado:</label><br>
                            <?php
                                mysql_connect("db", "root", "") or die(mysql_error());
                                mysql_select_db("ssmanager");
                                mysql_set_charset("utf8");
                                $result = mysql_query("SELECT * FROM `grades` WHERE 1 ORDER BY `Grado`") or die(mysql_error());
                                if(mysql_num_rows($result) >= 1)
                                {
                                    echo "<select name = 'gradelistaxd' form = 'estudiantar' required>
                                    <option value = 'null'>Selecciona un grado</option>";
                                    while($rows = mysql_fetch_array($result, MYSQL_ASSOC))
                                    {
                                        $name = $rows['Grado'];
                                        echo "<option value = '$name'>$name</option>";
                                    }
                                    echo "</select>";
                                }
                                else echo "<p style = 'color: red; font-size: 7pt;'>La lista de grados no está disponible. Intentelo más tarde.</p>";
                                mysql_free_result($result);
                                mysql_close();
                            ?>
                        <br>                        
                        <label for = 'estu'>Nombre del estudiante:</label><br>
                        <input id = 'estu' name = "estu" type = 'text' maxlength = "50" required placeholder = "Nombre del estudiante"><br>
                        <label for = 'estu2'>Código del estudiante:</label><br>
                        <input id = 'estu2' name = "estu2" type = 'number' required placeholder = "xxxx"><br>
                        <br>
                        <input type = "submit" value = "Agregar estudiante" id = "subm">
                    </form>
                    <?php
                        if($_POST) {
                            if(isset($_POST['estu']) && isset($_POST['estu2'])) {
                                mysql_connect("db", "root", "") or die(mysql_error());
                                mysql_select_db("ssmanager");
                                mysql_set_charset("utf8");
                                $result = mysql_query("SELECT * FROM `students` WHERE `cod_student` = {$_POST['estu2']}") or die(mysql_error());
                                if(mysql_num_rows($result) <= 0) {

                                    mysql_query("INSERT INTO `students` VALUES ({$_POST['estu2']}, '{$_POST['estu']}', '{$_POST['gradelistaxd']}');") or die(mysql_error());
                                    if($_FILES["foto"]) {
                                        $target_dir = "img/students/";
                                        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
                                        $uploadOk = 1;
                                        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                                        // Check if image file is a actual image or fake image
                                        if($_FILES['foto']) {
                                            $check = getimagesize($_FILES["foto"]["tmp_name"]);
                                            if($check !== false) {
                                                echo "File is an image - " . $check["mime"] . ".";
                                                $uploadOk = 1;
                                            } else {
                                                echo "File is not an image.";
                                                $uploadOk = 0;
                                            }
                                        }
                                        // Check file size
                                        if ($_FILES["foto"]["size"] > 100000) {
                                            echo "<script>alert('Tu imagen no puede ser subida. Es demasiado grande. El límite máximo de tamaño de imagen es de 1MB.');</script>";
                                            $uploadOk = 0;
                                        }
                                        // Allow certain file formats
                                        if($imageFileType != "jpg") {
                                            echo "<script>alert('Tu imagen no puede ser subida. Solo se acepta el formato/extensión JPG.');</script>";
                                            $uploadOk = 0;
                                        }
                                        // Check if $uploadOk is set to 0 by an error
                                        if ($uploadOk == 0) {
                                            echo "<script>
                                                alert('Tu imagen no puede ser subida. Intentalo de nuevo.');
                                            </script>";
                                        // if everything is ok, try to upload file
                                        } else {
                                            //$target_filenew = $target_dir . "{$_SESSION['userid']}";
                                            $target_filenew = $target_dir . "{$_POST['estu2']}" . ".jpg";
                                            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_filenew)) {
                                                echo 
                                                "
                                                    <div id = 'dialog' title = 'Estudiante añadido'>
                                                        <p>El estudiante <b>{$_POST['estu']}</b> fue agregado al grado <b>{$_POST['gradelistaxd']}</b>.</p>
                                                    </div>
                                                    <script>
                                                        $(document).ready(function() {
                                                            $('#dialog').dialog();
                                                        });
                                                    </script>
                                                ";
                                            } else {
                                                echo "<script>alert('Lo lamentamos, tu imagen tuvo un error al ser subida.');</script>";
                                            }
                                        }
                                    }
                                    else {
                                        echo 
                                        "
                                            <div id = 'dialog' title = 'Estudiante añadido'>
                                                <p>El estudiante <b>{$_POST['estu']}</b> fue agregado al grado <b>{$_POST['gradelistaxd']}</b>.<br>Este estudiante no posee una imagen, por favor, añade una imagen en su respectiva sección del observador del estudiante.</p>
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    $('#dialog').dialog();
                                                });
                                            </script>
                                        ";
                                    }
                                    mysql_close();
                                }
                                else {
                                    echo 
                                    "
                                        <div class = 'cosfa-message alert'>
                                            <p>El código del estudiante está siendo usado en estos momentos. Pon otro código.</p>
                                        </div>
                                    ";
                                }
                                
                            }                            
                        }
                    ?>
                </div>
            </div>
            <div class = "col-lg-12">
                <div class = "col-lg-12 text-center">
                    <h3>Asignar director</h3>
                    <p>Asignando un director lo harás cargo de un grado, por lo que lo que pase con este y las necesidades que tenga este deberán ser atendidas por el o ella.</p>
                    <form method = "POST" id = "asignar">
                        <label>Grado:</label><br>
                        <?php
                            mysql_connect("db", "root", "") or die(mysql_error());
                            mysql_select_db("ssmanager");
                            mysql_set_charset("utf8");
                            $result = mysql_query("SELECT * FROM `grades` WHERE 1 ORDER BY `Grado`") or die(mysql_error());
                            if(mysql_num_rows($result) >= 1)
                            {
                                echo "<select name = 'gradelista' form = 'asignar' required>
                                <option value = 'null'>Selecciona un grado</option>";
                                while($rows = mysql_fetch_array($result, MYSQL_ASSOC))
                                {
                                    $name = $rows['Grado'];
                                    echo "<option value = '$name'>$name</option>";
                                }
                                echo "</select>";
                            }
                            else echo "<p style = 'color: red; font-size: 7pt;'>La lista de grados no está disponible. Intentelo más tarde.</p>";
                            mysql_free_result($result);
                            mysql_close();
                        ?><br>
                        <label>Director:</label><br>
                        <?php
                            mysql_connect("db", "root", "") or die(mysql_error());
                            mysql_select_db("ssmanager");
                            mysql_set_charset("utf8");
                            $result = mysql_query("SELECT * FROM `accounts` WHERE 1") or die(mysql_error());
                            if(mysql_num_rows($result) >= 1)
                            {
                                echo "<select name = 'directorlista' form = 'asignar' required>
                                <option value = 'null'>Selecciona un(a) miembro(a) de la institución</option>";
                                while($rows = mysql_fetch_array($result, MYSQL_ASSOC))
                                {
                                    $name = $rows['realname'];
                                    $role = $rows['role'];
                                    echo "<option value = '$name'>$name ($role)</option>";
                                }
                                echo "</select>";
                            }
                            else echo "<p style = 'color: red; font-size: 7pt;'>La lista de docentes no está disponible. Intentelo más tarde.</p>";
                            mysql_free_result($result);
                            mysql_close();
                        ?><br><br>
                        <input type = "submit" value = "Asignar" id = "subm">
                    </form>
                    <?php
                        if($_POST) {
                            if(isset($_POST['gradelista']) && isset($_POST['directorlista'])) {
                                mysql_connect("db", "root", "") or die(mysql_error());
                                mysql_select_db("ssmanager");
                                mysql_set_charset("utf8");
                                mysql_query("UPDATE `accounts` SET `gradedirector` = '{$_POST['gradelista']}' WHERE `realname` = '{$_POST['directorlista']}'") or die(mysql_error());
                                mysql_close();
                                echo
                                "
                                    <div id = 'dialog' title = 'Director actualizado'>
                                        <p>El/La docente <b>{$_POST['directorlista']}</b> fue asignado(a) como director(a) del grado <b>{$_POST['gradelista']}</b>.</p>
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            $('#dialog').dialog();
                                        });
                                    </script>
                                ";
                            }
                        }
                    ?>
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
    th {
        text-align: center;
    }
</style>
</html>

