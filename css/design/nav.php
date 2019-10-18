.<!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" id = "navg">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class = "banner" href="index"><img src = "img/cosfa-slimmed.png" width = "65px" height = "50px" style = "vertical-align: middle;"/></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="about">Acerca de SS Manager</a></li>
                    <?php
                        if(isset($_SESSION['changepswd']) && $_SESSION['changepswd'] == 1)
                        {
                            if($_SERVER['REQUEST_URI'] != "/ssmanager/changepswd") {
                                header("Location: changepswd");
                            }
                        }
                        if(isset($_SESSION['username']))
                        {
                            $fadecolor = $_SESSION['color'];
                            echo '
                            <script>
                            $(document).ready (function() {
                                $(".navbar.navbar-inverse.navbar-fixed-top").css("background-color", "'.$fadecolor.'");
                                $("ul.nav.navbar-nav li a").css("border-bottom-color", "'.$fadecolor.'");
                                $("ul.dropdown-menu").css("background-color", "'.$fadecolor.'");
                                $(".custom-button").css("border-bottom-color", "'.$fadecolor.'");
                                $("#nav-dropdown a").css("border-bottom-color", "'.$fadecolor.' !important;");
                            });

                            </script>
                            ';
                            $user = $_SESSION['username'];
                            echo "<li>
                                <a href='ssm'>Observador de estudiantes</a>
                            </li>
                            ";
                            if($_SESSION['permission'] == 2)
                            {
                                echo '<li>
                                    <a href="register">Registrar a un miembro</a>
                                </li>';
                                echo '<li>
                                    <a href="members">Miembros</a>
                                </li>';
                            }
                            echo 
                                "
                                    <li class = 'dull'><form method = 'GET' style = 'margin-top: 6px; width: 150px !important;'><input type = 'text' id = 'texter' placeholder = 'Buscar un usuario' name = 'searchname' style = 'width: 150px !important;' required><input type = 'submit' value = 'Buscar' style = 'display: none;'></form></li>
                                ";
                            echo "</ul>";
                            echo "<ul class = 'nav navbar-nav navbar-right'>
                                    <li class = 'dropdown' id = 'nav-dropdown'>
                                        <a class = 'dropdown-toggle' data-toggle = 'dropdown' href = '#' id = 'toggler'><span class = 'fa fa-user'>&nbsp;</span>$user<span class = 'caret'></span></a>
                                        <ul class = 'dropdown-menu'>
                                        <li><a href = 'dates'><span class = 'fa fa-address-book-o'>&nbsp;&nbsp;</span>Citas pendientes</a></li>
                                        <li><a href = 'profile?userid={$_SESSION['userid']}'><span class = 'fa fa-user-circle-o'>&nbsp;&nbsp;</span>Perfil</a></li>
                                    </li>
                                ";
                            if($_SESSION['permission'] == 2) {
                                echo "
                                    <li><a href = 'grades'><span class = 'fa fa-archive' aria-hidden = 'true'>&nbsp;&nbsp;</span>Listado de grados</a></li>
                                    <li><a href = 'configure'><span class = 'fa fa-cog' aria-hidden = 'true'>&nbsp;&nbsp;</span>Configuración de SS Manager</a></li>
                                ";
                            }
                            echo "
                                <li><a href = 'log-out'><span class = 'fa fa-power-off' aria-hidden = 'true'>&nbsp;&nbsp;</span>Cerrar sesión</a></li>
                                        </ul>
                            ";
                        }
                        else 
                        {
                            echo "<li><a href='contact'>Contactarnos / Pedir una cita</a></li>
                            <li>
                                <a href = 'login'>Iniciar sesión</a>
                            </li>";
                        }
                        echo "</ul>";
                    ?>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <script type = "text/javascript">
        if($('document').ready()) {
            if ($('#back-to-top').length) {
                var scrollTrigger = 320, // px
                    backToTop = function () {
                        var scrollTop = $(window).scrollTop();
                        if (scrollTop > scrollTrigger) {
                            $('#back-to-top').addClass('show');
                        } else {
                            $('#back-to-top').removeClass('show');
                        }
                    };
                backToTop();
                $(window).on('scroll', function () {
                    backToTop();
                });
                $('#back-to-top').on('click', function (e) {
                    e.preventDefault();
                    $('html,body').animate({
                        scrollTop: 0
                    }, 700);
                });
            }
        }
    </script>

<?php
    if($_GET) {
        if(isset($_GET['searchname'])) {
            mysql_connect("db", "root", "") or die(mysql_error());
            mysql_set_charset("utf8");
            mysql_select_db("ssmanager");
            echo "SELECT `id` FROM `accounts` WHERE `realname` = '{$_GET['searchname']}'";
            $result = mysql_query("SELECT `id` FROM `accounts` WHERE `realname` = '{$_GET['searchname']}'") or die(mysql_error());
            if(mysql_num_rows($result) == 1) {
                $r = mysql_fetch_array($result, MYSQL_ASSOC);
                echo 
                "
                    <script>
                        window.location.assign('profile?userid={$r['id']}');
                    </script>
                ";
                unset($_GET['searchname'], $_GET['userid']);
            }
        }
    }
?>
 