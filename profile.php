<?php require_once 'fix_mysql.php'; ?>
<?php require_once('session_validation.php'); ?>
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
    
    <?php
        mysql_connect("db", "root", "") or die(mysql_error());
        mysql_set_charset("utf8");
        mysql_select_db("ssmanager");
        $result = mysql_query("SELECT * FROM `accounts` WHERE `id` = {$_GET['userid']};") or die(mysql_error());
        if(mysql_num_rows($result) >= 1) {
            $rows = mysql_fetch_array($result, MYSQL_ASSOC);
            mysql_free_result($result);
            $result = mysql_query("SELECT * FROM `dates` WHERE `teacher` = '{$rows['realname']}';");
            $dates = mysql_num_rows($result);
            mysql_free_result($result);
            $description = nl2br($rows['description']);
        }
        else {
            header("Location: 404");
        }  
    ?>
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
        if($_SESSION['userid'] <= 0) {
            header("Location: login");
        }
    ?>
    <!-- Page Content -->
    <div class="container main">
        <a href="#" id="back-to-top" title="Back to top">&uarr;</a>
        <div class="row">
            <?php
                if($_GET['userid'] == $_SESSION['userid']) {
            ?>
            <div class = "col-lg-12 text-center">
                <h1><?php echo $rows['realname'] ?></h1>
                <div class = "col-lg-3 text-center" style = "margin-top: 25px;">
                    <form class = 'form-group' method = "POST" action = "uploadphoto.php" enctype="multipart/form-data">
                        <?php if(!file_exists("img/profiles/{$_GET['userid']}.jpg")): ?>
                        <img src = 'img/usertemp.png' width = "150px" height = "150px" style = "outline: solid 1px #000;">
                        <?php else: ?>
                        <?php echo "<img src = 'img/profiles/{$_GET['userid']}.jpg' width = '150px' height = '150px' style = 'outline: solid 1px #000;'>"; ?>
                        <?php endif;?>
                        <input type = "file" name = "foto" id = 'fotito' style = '  width: 0.1px;
                                                                                    height: 0.1px;
                                                                                    opacity: 0;
                                                                                    overflow: hidden;
                                                                                    position: absolute;
                                                                                    z-index: -1;'>
                        <br><br>
                        <label for = 'fotito'><span class = 'fa fa-upload' aria-hidden = 'true'></span></label><br>
                        <input type = "submit" name = "fotecha" value = 'Subir foto' id = 'subm'>
                        <p style = 'font-size: 8pt; padding-top: 25px; padding-left: 60px; padding-right: 60px; text-align: justify;'>Solo se admiten formatos JPG de máximo 1MB de tamaño.</p>
                    </form>
                    <form class = "form-group" id = "editarperfil" method = "POST">
                    <?php
                        echo 
                        "
                            <br><br><p style = 'text-align: center;'>Rol en la institución: <br><b>{$rows['role']}</b> <br>Citas pendientes de revisión: $dates</p>
                        ";
                        if($dates >= 1) {
                            echo "<p style = 'text-align: justify;'>Tienes citas pendientes para revisar, para leerlas, haz <a href = 'dates'>click aquí.</a></p>";
                        }
                        echo
                        "
                            <label for = 'colorcito'>Color de énfasis:</label> <input type = 'color' value = '{$rows['color']}' id = 'colorcito' name = 'colorrito'>
                        ";
                    ?>
                </div>
                <div class = "col-lg-9 text-center" style = "margin-top: 25px;">
                        <label for = "descript">Descripción del perfil</label>
                        <textarea class = "txtarea" form = "editarperfil" id = "descript" name = "descript"><?php echo $description; ?></textarea>
                        <input type = "submit" id = "subm" value = "Modificar perfil" style = "margin-top: 35px;">
                    </form>
                    <?php 
                        if($_POST) {
                            $result = mysql_query("UPDATE `accounts` SET `color` = '{$_POST['colorrito']}', `description` = '{$_POST['descript']}' WHERE `realname` = '{$rows['realname']}';") or die(mysql_error());
                            if(mysql_errno() == 0) {
                                $_SESSION['color'] = $_POST['colorrito'];
                                echo 
                                "
                                     <div id = 'dialog' title = 'Cambios guardados'>
                                        <p>Los cambios realizados en tu perfil han sido guardados correctamente.</p>
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            $('#descript').val('{$_POST['descript']}');
                                            $('#dialog').dialog();
                                            $('.navbar.navbar-inverse.navbar-fixed-top').css('background-color', '{$_SESSION['color']}');
                                            $('ul.nav.navbar-nav li a').css('border-bottom-color', '{$_SESSION['color']}');
                                        });
                                    </script>
                                ";
                            }
                            mysql_close();
                        }
                    ?>
                </div>
            </div>
            <?php
                }
                else {
            ?>
            <div class = "col-lg-12 text-center">
                <h1><?php echo $rows['realname']; ?></h1>
                <hr>
                <div class = "col-lg-3">
                    <?php if(!file_exists("img/profiles/{$_GET['userid']}.jpg")): ?>
                        <img src = 'img/usertemp.png' width = "150px" height = "150px" style = "outline: solid 1px #000;">
                        <?php else: ?>
                        <?php echo "<img src = 'img/profiles/{$_GET['userid']}.jpg' width = '150px' height = '150px' style = 'outline: solid 1px #000;'>"; 
                        	endif;?>
                    <?php
                        echo 
                        "
                            <script>
                                $(document).ready(function() {
                                    $('.navbar.navbar-inverse.navbar-fixed-top').css('background-color', '{$rows['color']}');
                                    $('ul.nav.navbar-nav li a').css('border-bottom-color', '{$rows['color']}');
                                    $('.dull').css('display', 'none !important');
                                });
                            </script>
                            <br><br>
                            <p style = 'text-align: center;'>Rol en la institución: <br><b>{$rows['role']}</b><br><br>Cantidad de citas pendientes que tiene {$rows['realname']}: $dates</p>
                        ";
                    ?>
                </div>
                <div class = "col-lg-9">
                    <center><h2>Descripción del perfil:</h2></center>
                    <hr>
                    <p><?php echo $description; ?></p>
                </div>
            </div>
            <?php
                }
            ?>
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

    .dull {
        display: none !important;
    }

</style>
<!--script>
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
</script-->
</html>
