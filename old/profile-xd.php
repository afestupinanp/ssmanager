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
    <?php
        if(!isset($_SESSION['userid']))
        {
            header("Location: login.php");
        }
        else
        {
            mysql_connect("db", "root", "") or die(mysql_error());
            mysql_select_db("ssmanager");
            mysql_set_charset("utf8");
            $result = mysql_query("SELECT * FROM `accounts` WHERE `id` = '{$_GET['userid']}'") or die(mysql_error());
            if(mysql_num_rows($result) >= 1) {
                $rows = mysql_fetch_array($result, MYSQL_ASSOC);
                mysql_free_result($result);
                $result = mysql_query("SELECT * FROM `dates` WHERE `teacher` = '{$rows['realname']}'") or die(mysql_error());
                $numrows = mysql_num_rows($result);
                mysql_free_result($result);
            }
            else { mysql_free_result($result); header("Location: 404"); }  
        }
    ?>
    <title>Perfil de <?php echo "{$rows['realname']}"; ?> - COSFA</title>

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
    <?php
            require("css/design/nav.php");
    ?>
    <div class = "container main">
        <a href="#" id="back-to-top" title="Back to top">&uarr;</a>
        <div class = "row">
            <div class = "col-lg-12 text-center">
                <h1>Perfil de <?php echo "{$rows['realname']}"; ?></h1>
                <hr>
                <div class = "col-lg-3">
                    <img src = 'img/usertemp.png' width = "150px" height = "150px" style = "outline: solid 1px #000;">
                    <br>
                    <p>Rol en la institución: <?php echo "{$rows['role']}"; ?></p>
                    <?php
                        if($_GET['userid'] == $rows['id']) {
                            echo 
                            "
                                <p>Citas pendientes: $numrows.</p>
                            ";
                            if($numrows >= 1) {
                                echo "Tienes más de una cita pendiente, puedes ver las citas que tienes pendientes haciendo <a href = 'dates'>click aquí.</a>";
                            }
                        }
                    ?>
                </div>
                <div class = "col-lg-9">
                    <?php
                        if($_GET['userid'] == $_SESSION['userid']) {
                    ?>
                    <form class = "form-group" method = "POST" id = 'modifypro'>
                        <label for = "descript">Descripción del perfil:</label><br>
                        <textarea form = 'modifypro' maxlength = "1500" class = "txtarea" id = "descript"><?php echo "{$rows['description']}";; ?></textarea>
                        <div class = 'Normal-Left'>
                            <label for = 'colorcito'>Color de énfasis: </label><?php echo "<input id = 'colorcito' type = 'color' value = '{$rows['color']}' style = 'margin-right: 425px;'>"; ?>
                            <input type = "submit" value = "Modificar perfil" id = "subm" style = "text-align: right;">
                        </div> 
                    </form>
                    <?php
                        }
                        else {
                    ?>
                    <script>
                        
                    </script>
                    <p>Descripción del perfil:</p><br>
                    <p><?php echo "{$rows['description']}"; ?></p>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php
            require("css/design/foot.php");
        ?>
</body>
<style>
    .txtarea {
        resize: none;
        width: 100%;
        height: 270px;
    }
    .Normal-Left {
        text-align: left;
        margin-top: 30px;
    }
</style>
</html>
