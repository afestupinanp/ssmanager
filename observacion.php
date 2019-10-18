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

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CSS -->
    <link href = "css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href = "css/cosfa.css" rel = "stylesheet" type = "text/css">
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
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
            <div class="col-lg-12 text-center">
                <?php unset($_GET['searchname']); if($_GET && isset($_GET['userid']) && !isset($_GET['searchname'])): ?>
                <div class = "col-lg-12">
                	<?php
                        mysql_connect("db", "root", "") or die(mysql_error());
                        mysql_select_db("ssmanager");
                        mysql_set_charset("utf8");
                        $result = mysql_query("SELECT * FROM `observator` WHERE `cod_student` = {$_GET['userid']};") or die(mysql_error());
                        $result2 = mysql_query("SELECT * FROM `students` WHERE `cod_student` = {$_GET['userid']}") or die(mysql_error());
                        $rows2 = mysql_fetch_array($result2, MYSQL_ASSOC);
                        $realname = $rows2['student'];
                        $numrows2 = mysql_num_rows($result2);
                        if(mysql_num_rows($result2) >= 1) {
                            $numrows = mysql_num_rows($result);
                            $chulo = null;
                            if(file_exists("img/students/{$_GET['userid']}.jpg")) {
                                $chulo = "<img id = 'chulo' src = 'img/students/{$_GET['userid']}.jpg' width = '210px' height = '210px'><br>";
                            }
                            else {
                                $chulo = "<img id = 'chulo' src = 'img/students/default.png' width = '210px' height = '210px'><br>";
                            }
                            echo 
                            "
                                <title>Observador de $realname - SS Manager</title>
                                <h1>Lista de observaciones de<br>$realname</h1>
                                <hr>
                                $chulo                                
                                <br><br>
                                <form action = 'uploadphoto2.php?userid={$_GET['userid']}' id = 'fata' name = 'fata' method = 'POST' enctype='multipart/form-data'>
                                    <input type = 'file' name = 'foto' id = 'fotito' style = '  width: 0.1px;
                                                                                        height: 0.1px;
                                                                                        opacity: 0;
                                                                                        overflow: hidden;
                                                                                        position: absolute;
                                                                                        z-index: -1;'>
                                    <br><br>
                                    <label for = 'fotito'><span class = 'fa fa-upload' aria-hidden = 'true'></span></label>
                                    <input type = 'submit' name = 'fotecha' value = 'Subir foto' id = 'subm' style = 'margin-left: 10px;'><br><br>
                                </form>
                                <p>Nombre del estudiante: $realname | Código del estudiante: {$_GET['userid']} | Número de observaciones: $numrows</p>
                            ";
                            if($numrows >= 1) {
                                echo 
                                "
                                    <button class = 'chido' id = 'printame' onclick = 'Baybay({$_GET['userid']});'>Imprimir listado de observación</button>
                                    <br><br>
                                    <div class = 'table-responsive' id = 'observator-on'>
                                        <table class = 'table' style = 'table-layout: fixed; width: 1100px; overflow: hidden; word-break: break-all;'>
                                            <tr>
                                                <th>Número de observación</th>
                                                <th>Fecha de observación</th>
                                                <th>Observación realizada por</th>
                                                <th>Observación</th>
                                                <th>Firma</th>
                                            </tr>
                                ";
                                while($rows1 = mysql_fetch_array($result, MYSQL_ASSOC)) {
                                    $date = $rows1['observationdate'];
                                    $teacher = $rows1['observationteacher'];
                                    $observations = $rows1['observations'];
                                    $observationid = $rows1['observationid'];
                                    echo 
                                    "
                                            <tr>
                                                <td>$observationid</td>
                                                <td>$date</td>
                                                <td>$teacher</td>
                                                <td>$observations</td>
                                    ";
                                    if(file_exists("img/students/signs/$observationid.jpg")) {
                                        echo 
                                        "
                                            <td><img src = 'img/students/signs/$observationid.jpg' width = '64px' height = '32px'></td>
                                        ";
                                    }
                                    else {
                                        echo "<td><i>No firmado</i></td>";
                                    }
                                    echo "</tr>";
                                }
                                echo 
                                "
                                        </table>
                                    </div>
                                ";
                            }
                            else {
                                echo "
                                <div class = 'col-lg-12'>
                                    <div class = 'cosfa-message message'>
                                        <p>El estudiante no posee ninguna observación.</p>
                                    </div>
                                </div>
                                ";
                            }
                        }
                        else {
                            echo "
                            <div class = 'col-lg-12'>
                                <div class = 'cosfa-message alert'>
                                    <title>Error</title>
                                    <span class = 'fa fa-exclamation-triangle'></span><br><p>El estudiante no existe.</p>
                                    <a href = 'ssm'>Volver a la lista de observadores y grados.</a>
                                </div>
                            </div>
                            ";
                        }
                    ?>
                </div>
                <?php if($numrows2 >= 1):
                ?>
                <div class = "col-lg-12">
                    <form class = "form-group" id = "Observate" method = "POST" enctype='multipart/form-data'>
                        <h2>Crear observación para <?php echo $realname; ?></h2>
                        <hr>
                        <label for = "dateobservacion">Fecha de observación</label>
                        <input type = "date" id = "dateobservacion" name = "date1" required>
                        <input type = 'file' name = 'foto2' id = 'fotito2' required style = '  width: 0.1px;
                                                                                        height: 0.1px;
                                                                                        opacity: 0;
                                                                                        overflow: hidden;
                                                                                        position: absolute;
                                                                                        z-index: -1;'>
                        <p>Subir firma: </p><label for = 'fotito2'><span class = 'fa fa-upload' aria-hidden = 'true'></span></label>
                        <br>
                        <label for = "observated">Cuerpo de la observación</label>
                        <textarea name = "date2" class = "txtarea" form = "Observate" maxlength = "1500" placeholder = "Área de observación" id = "observated" required></textarea>
                        <br><br>
                        <input type = "submit" id = "subm" value = "Realizar observación">
                    </form>
                    <?php
                        if($_POST) {
                            $result = mysql_query("
                                INSERT INTO `observator`
                                (
                                    `cod_student`,
                                    `observationteacher`,
                                    `observationdate`,
                                    `observations`
                                )
                                VALUES
                                (
                                    {$_GET['userid']},
                                    '{$_SESSION['realname']}',
                                    '{$_POST['date1']}',
                                    '{$_POST['date2']}'
                                );
                                ") or die(mysql_error());
                            if($_FILES && $_POST['foto2'] || $_FILES['foto2']) {
                                $target_dir = "img/students/signs/";
                                //var_dump($_FILES['foto2']);
                                $target_file = $target_dir . basename($_FILES["foto2"]["name"]);
                                $uploadOk = 1;
                                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                                // Check if image file is a actual image or fake image
                                if($_FILES['foto2']) {
                                    $check = getimagesize($_FILES["foto2"]["tmp_name"]);
                                    if($check !== false) {
                                        echo "File is an image - " . $check["mime"] . ".";
                                        $uploadOk = 1;
                                    } else {
                                        echo "File is not an image.";
                                        $uploadOk = 0;
                                    }
                                }
                                // Check file size
                                if ($_FILES["foto2"]["size"] > 100000) {
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
                                    $result = mysql_query("SELECT * FROM `observator` WHERE `cod_student` = {$_GET['userid']} ORDER BY `when` DESC") or die(mysql_error());
                                    $rowx = mysql_fetch_array($result, MYSQL_ASSOC);

                                    $target_filenew = $target_dir . "{$rowx['observationid']}" . ".jpg";
                                    echo $target_filenew;
                                    if (move_uploaded_file($_FILES["foto2"]["tmp_name"], $target_filenew)) {
                                        echo 
                                        "
                                            <script>
                                                $(document).ready(function(){
                                                    $('#dialog').dialog();
                                                });
                                                function ReLoad() {
                                                    window.location.replace('observacion?userid={$_GET['userid']}');
                                                }
                                                window.setTimeout(ReLoad, 4000);
                                            </script>
                                            <div id = 'dialog' title = 'Observación realizada'>
                                                <p>Se ha realizado la observación en el observador de $realname y se ha incluido su firma. La página se refrescará automáticamente en 4 segundos.</p>
                                            </div>
                                        ";
                                    } else {
                                        echo "<script>alert('Lo lamentamos, tu imagen tuvo un error al ser subida.');</script>";
                                    }
                                }
                            }
                            else {
                                echo 
                                "
                                    <script>
                                        $(document).ready(function(){
                                            $('#dialog').dialog();
                                        });
                                        function ReLoad() {
                                            window.location.replace('observacion?userid={$_GET['userid']}');
                                        }
                                        window.setTimeout(ReLoad, 4000);
                                    </script>
                                    <div id = 'dialog' title = 'Observación realizada'>
                                        <p>Se ha realizado la observación en el observador de $realname. No ha se ha subido ninguna firma del estudiante. La página se refrescará automáticamente en 4 segundos.</p>
                                    </div>
                                ";
                            }
                            
                            
                        }
                    ?>
                </div>
                <?php endif; endif; ?>
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
    <script>
        function Baybay(userid) {
            window.location.assign("generate?userid=" + userid);
        }
    </script>
    <?php
        echo "<script>var name = '$realname';</script>";
    ?>
    <style>
        #chulo {
            outline-color: black;
            outline-width: 5px;
            outline-offset: 5px;
            border-radius: 360px;
            transition: all 0.1s ease-in;
        }

        #chulo:hover {
            transform:scale(1.25);
            cursor: zoom-in;
        }

        .txtarea {
            resize: none;
            width: 100%;
            height: 270px;
        }
        input[type="date"] {
            width: 25%;
            resize: none;

        }

        table, tr, td, th {
            text-align: center;
        }

        @media print {
            html {
                visibility: hidden;
                overflow: hidden;
            }
            table, tr, td, th {
                visibility: visible;
            }
            table {
                position: fixed !important;
                top: 0;
                left: 0;
            }
        }

    </style>
</body>

</html>
