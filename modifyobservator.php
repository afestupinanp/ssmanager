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
        require("css/design/nav.php");
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
                <?php 
                    if($_GET['userid'] != 0) {
                        mysql_connect("db", "root", "") or die(mysql_error());
                        mysql_select_db("ssmanager");
                        mysql_set_charset("utf8");
                        $result = mysql_query("SELECT * FROM `students` WHERE `cod_student` = {$_GET['userid']}") or die(mysql_error());
                        if(mysql_num_rows($result) >= 1) {
                            $rows = mysql_fetch_array($result, MYSQL_ASSOC);
                            echo 
                            "
                                <h1>{$rows['student']}</h1>
                                <hr>
                                <div class = 'col-lg-12'>
                                    <div class = 'table-responsive'>
                                        <table class = 'table'>
                                            <tr>
                                                <th>Número de observación</th>
                                                <th>Fecha de observación</th>
                                                <th>Observación realizada por</th>
                                                <th>Observación</th>
                                            </tr>
                            ";
                            while($r = mysql_fetch_array($result, MYSQL_ASSOC)) {
                                echo 
                                "
                                    <form method = 'POST'>
                                        <tr>{$r['observationid']}</tr>
                                        <tr></tr>
                                    </form>
                                ";
                            }
                            echo 
                            "
                                        </table>
                                    </div>
                                </div>
                            ";
                        }
                    }
                ?>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
    <!-- jQuery Version 1.11.1 -->

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script>
        function setPrinting() {
            var toprint = document.getElementById('observator-on');
            var printWindow = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
            printWindow.document.write(toprint.innerHTML);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWndow.close();
            window.focus();
        }
    </script>
    <style>
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

    </style>
</body>

</html>
