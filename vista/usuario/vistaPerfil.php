<?php 
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__FILE__) . DS);
require_once(ROOT . ".." . DS . ".." . DS . "core" . DS . "init.php");
if(!$_SESSION['user']){
    Redirect::to('../index.php');
}
$usuarioController = new UsuarioController();
$localController = new LocalController();
$localesUser = $localController->getLocalesByUsuario_id($_SESSION['user']);

$datos = $usuarioController->getDatosUsuario($_SESSION['user']);

if (!empty($datos)) {
    foreach ($datos as $dato) {
?>
<!DOCTYPE html>
<html lang="es" class="js">
<head>
    <base href="../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    
    <title>Perfil</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.css">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>    
</head>
<body>               
<?php if (isset($_SESSION['user']) && $_SESSION['user']) {
        $localesUser = $localController->getLocalesByUsuario_id($_SESSION['user']);
        ?>
        <div class="nk-header nk-header-fixed is-light">
            <div class="container-fluid">
                <div class="nk-header-wrap">
                    <div class="nk-header-news d-none d-xl-block">
                        <div class="nk-news-list">
                            <a href="index.php" class="logo">
                                <img class="" src="./assets/img/png/Logotipo/Logo-Iconos_Mesa de trabajo 1 copia 7.png" srcset="./assets/img/logo2x.png 2x" alt="logo">
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
                                            <li><a href="./vista/usuario/vistaPerfil.php"><span> Perfil</span></a></li>
                                            <li><a href="./vista/registro/AltaLocal.php"><span> Dar de alta un local</span></a></li>
                                            <?php if ($usuarioController->es_propietario($_SESSION['user'])): ?>
                                                <?php foreach ($localesUser as $local): ?>
                                                    <li>
                                                        <a href="./vista/usuario/vistaLocal.php?local_id=<?php echo $local['local_id']; ?>">
                                                            <span><?php echo $local['nombre_local']; ?></span>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php endif; ?>                                            
                                            <li><a href="./vista/usuario/vistaFavoritos.php"><span>Favoritos</span></a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-inner">
                                        <ul class="link-list">
                                            <li><a href="./vista/registro/logout.php"><em class="icon ni ni-signout"></em><span>Cerrar sesión</span></a></li>
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
              
    <div class="nk-content">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block">
                        <div class="card-inner card-inner-lg">
                            <div class="nk-block-head nk-block-head-lg">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Información personal</h4>                                                
                                    </div>
                                    <div class="nk-block-head-content">
                                        <form action="./controlador/UsuarioController.php" method="POST" onsubmit="return confirm('¿Está seguro de que desea eliminar su usuario?');">
                                            <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['user']?>">
                                            <button type="submit" name="borrarUsuario" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                                                <em class="icon ni ni-arrow-left"></em><span>Dar de baja usuario</span>
                                            </button>
                                        </form>
                                    </div> 
                                </div>
                            </div>
                            <div class="nk-block">
                                <div class="nk-data data-list">
                                    <div class="data-head">
                                        <h6 class="overline-title">Datos perfil</h6>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Nombre</span>
                                            <span class="data-value"><?php echo htmlspecialchars($dato['nombre']); ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Apellido</span>
                                            <span class="data-value"><?php echo htmlspecialchars($dato['apellido']); ?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Nombre de usuario</span>
                                            <span class="data-value"><?php echo htmlspecialchars($dato['nombre_usuario']); ?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                    <div class="data-item">
                                        <div class="data-col">
                                            <span class="data-label">Email</span>
                                            <span class="data-value"><?php echo htmlspecialchars($dato['email']); ?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Número de teléfono</span>
                                            <span class="data-value text-soft"><?php echo htmlspecialchars($dato['telefono']); ?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Fecha de nacimiento</span>
                                            <span class="data-value"><?php echo htmlspecialchars($dato['fecha_de_nacimiento']); ?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit" data-tab-target="#address">
                                        <div class="data-col">
                                            <span class="data-label">DNI</span>
                                            <span class="data-value"><?php echo htmlspecialchars($dato['dni']); ?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Editar Perfil Modal -->
    <div class="modal fade" role="dialog" id="profile-edit">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title">Editar perfil</h5>                    
                    <div class="tab-content">
                        <div class="tab-pane active" id="personal">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="nombre">Nombre</label>
                                        <input type="text" class="form-control form-control-lg" id="nombre" name="nombre" value="<?php echo htmlspecialchars($dato['nombre']); ?>" placeholder="Introduce tu nombre">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="apellido">Apellido</label>
                                        <input type="text" class="form-control form-control-lg" id="apellido" name="apellido" value="<?php echo htmlspecialchars($dato['apellido']); ?>" placeholder="Introduce tu apellido">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="nombre_usuario">Nombre de usuario</label>
                                        <input type="text" class="form-control form-control-lg" id="nombre_usuario" name="nombre_usuario" value="<?php echo htmlspecialchars($dato['nombre_usuario']); ?>" placeholder="Introduce tu nombre de usuario">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="telefono">Número de teléfono</label>
                                        <input type="text" class="form-control form-control-lg" id="telefono" name="telefono" value="<?php echo htmlspecialchars($dato['telefono']); ?>" placeholder="Número de teléfono">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="fecha_nacimiento">Fecha de nacimiento</label>
                                        <input type="text" class="form-control form-control-lg date-picker" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo htmlspecialchars($dato['fecha_de_nacimiento']); ?>" placeholder="Introduce tu fecha de nacimiento">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="dni">DNI</label>
                                        <input type="text" class="form-control form-control-lg" id="dni" name="dni" value="<?php echo htmlspecialchars($dato['dni']); ?>" placeholder="Introduce tu DNI">
                                    </div>
                                </div>
                                <div id="usuario_id" name="usuario_id" style="display: none;"><?php echo htmlspecialchars($_SESSION['user']); ?></div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <button type="button" class="btn btn-lg btn-primary" id="botonUpdate" name="botonUpdate">Actualizar perfil</button>
                                        </li>
                                        <li>
                                            <a href="vista/usuario/vistaPerfil.php" class="link link-light">Cancelar</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>             
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="./assets/js/bundle.js"></script>
    <script src="./assets/js/scripts.js"></script>
    <script src="./assets/js/form/updateProfile.js"></script>  
</body>
</html>
<?php 
    }
} else {
    echo "No data found for the user.";
}
?>
