<?php
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__FILE__) . DS);
require_once(ROOT . ".." . DS . ".." . DS . "core" . DS . "init.php");
$LocalController = new LocalController();
$usuarioController = new UsuarioController();
if(!$_SESSION['user']){
    Redirect::to('../index.php');
}
//obtener id del usuario que ha iniciado sesion para que los favoritos se asocien solo a ese usuario

?>
<!DOCTYPE html>
<html lang="es" class="js">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="../../assets/css/dashlite.css">
    <title>Perfil</title>
    <!-- StyleSheets  -->
    <script src="../../assets/js/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>   
    <script src="../../assets/js/MostrarYEliminarFav.js" ></script> 
</head>
<body>        
<?php if (isset($_SESSION['user']) && $_SESSION['user']) {
        $localesUser = $LocalController->getLocalesByUsuario_id($_SESSION['user']);
        ?>
        <div class="nk-header nk-header-fixed is-light">
            <div class="container-fluid">
                <div class="nk-header-wrap">
                    <div class="nk-header-news d-none d-xl-block">
                        <div class="nk-news-list">
                            <a href="../index.php" class="logo">
                                <img class="" src="../../assets/img/png/Logotipo/Logo-Iconos_Mesa de trabajo 1 copia 7.png" srcset="./assets/img/logo2x.png 2x" alt="logo">
                            </a>
                        </div>
                    </div><!-- .nk-header-news -->
                    <div class="nk-header-tools">                        
                        <ul class="nk-quick-nav">
                            <!-- .dropdown -->
                            <li class="dropdown user-dropdown">
                                <a href="index.php" class="dropdown-toggle" data-bs-toggle="dropdown">
                                    <div class="user-toggle">
                                        <div class="user-avatar sm">
                                            <em class="icon ni ni-user-alt"></em>
                                        </div>
                                        <div class="user-info d-none d-md-block">
                                            <div class="user-name dropdown-indicator">
                                                <span><?php echo $usuarioController->getNombreById($_SESSION['user']); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1">
                                    <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                        <div class="user-card">
                                            <div class="user-avatar">
                                                <span><?php echo strtoupper(substr($usuarioController->getNombreById($_SESSION['user']), 0, 2)); ?></span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text"><?php echo $usuarioController->getNombreById($_SESSION['user']); ?></span>
                                                <span class="sub-text"><?php echo $usuarioController->getEmailById($_SESSION['user']); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown-inner">
                                        <ul class="link-list">
                                            <li><a href="../usuario/vistaPerfil.php"><span> Perfil</span></a></li>
                                            <li><a href="../registro/AltaLocal.php"><span> Dar de alta un local</span></a></li>
                                            <?php if ($usuarioController->es_propietario($_SESSION['user'])): ?>
                                                <?php foreach ($localesUser as $local): ?>
                                                    <li>
                                                        <a href="../usuario/vistaLocal.php?local_id=<?php echo $local['local_id']; ?>">
                                                            <span><?php echo $local['nombre_local']; ?></span>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php endif; ?>                                            
                                            <li><a href="../usuario/vistaFavoritos.php"><span>Favoritos</span></a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-inner">
                                        <ul class="link-list">
                                            <li><a href="../registro/logout.php"><em class="icon ni ni-signout"></em><span>Cerrar sesión</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li><!-- .dropdown -->
                        </ul><!-- .nk-quick-nav -->
                    </div><!-- .nk-header-tools -->
                </div><!-- .nk-header-wrap -->
            </div><!-- .container-fluid -->
        </div>
    <?php } ?>
    <div class="container">
        <h1>Mis Locales Favoritos</h1>
    </div> 
        <div id="list-favoritos" class="favs-container" ></div>

        <script src="../../assets/js/bundle.js"></script>
        <script src="../../assets/js/scripts.js"></script>
        <script src="../../assets/js/form/updateProfile.js"></script> 
    

</body>
</html>
