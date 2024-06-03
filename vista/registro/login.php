<?php 
   define("DS", DIRECTORY_SEPARATOR);
   define("ROOT", dirname(__FILE__) . DS);
   require_once (ROOT . ".." . DS . ".." . DS . "core" . DS . "init.php");
    new RegistroController();
?>
<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <!-- Page Title  -->
    <title>Inicio Sesión</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="../assets/css/dashlite.css">
    <link id="skin-default" rel="stylesheet" href="../assets/css/theme.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>    
</head>

<body class="nk-body bg-white npc-general pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                        <div class="brand-logo pb-4 text-center">
                            <!-- <a href="html/index.html" class="logo-link"> -->
                            <a href="./index.php"  class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="../assets/img/png/Logotipo/Logo-Iconos_Mesa de trabajo 1 copia 7.png" srcset="../assets/img/png/Logotipo/Logo-Iconos_Mesa de trabajo 1.png" alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="../assets/img/png/Logotipo/Logo-Iconos_Mesa de trabajo 1 copia 7.png" srcset="../assets/img/png/Logotipo/Logo-Iconos_Mesa de trabajo 1.png" alt="logo-dark">
                            </a>
                        </div>
                        <div class="card card-bordered">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Iniciar Sesión</h4>
                                        <div class="nk-block-des">
                                            <p>Acesso a Cheersy con email/nombre de usuario y contraseña.</p>
                                        </div>
                                    </div>
                                </div>
                                <form id="loginForm" action="#" method="post">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="nombre_usuario">Email o Usuario</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" id="nombre_usuario" name="nombre_usuario" placeholder="Escribe tu email o usuario">
                                        </div>
                                        <div class="error-msg text-danger" id="error-username"></div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">Contraseña</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Escribe tu contraseña">
                                            <div class="error-msg text-danger" id="error-password"></div>
                                        </div>                                        
                                    </div>
                                    <div class="error-msg text-danger" id="error-msg"></div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block " id="botonLog">Login</button>
                                    </div>
                                </form>
                                <div class="form-note-s2 text-center pt-4"> ¿Todavía no tienes cuenta? <a href="./registro/registro.php">Registrarse</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="../assets/js/login.js"></script>    
    <script src="../assets/js/bundle.js"></script>
    <script src="../assets/js/scripts.js"></script>
</body>
</html>