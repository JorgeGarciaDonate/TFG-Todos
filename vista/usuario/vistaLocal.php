<?php 
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__FILE__) . DS);
require_once(ROOT . ".." . DS . ".." . DS . "core" . DS . "init.php");

$usuarioController = new UsuarioController();
$localController = new LocalController();
$datos = $localController -> getDatoslocal(81);

if (!empty($datos)) {
    foreach ($datos as $dato) {
?>
<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./assets/img/favicon.png">
    <!-- Page Title  -->
    <title>Profile | DashLite Admin Template</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.css">
    <link id="skin-default" rel="stylesheet" href="./assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>    
</head>
<body>
    <div class="nk-header nk-header-fixed is-light">
        <div class="container-fluid">
            <div class="nk-header-wrap">
                <div class="nk-header-news d-none d-xl-block">
                    <div class="nk-news-list">
                        <a href="index.php" class="logo">
                            <img src="./assets/img/png/Logotipo/Logo-Iconos_Mesa de trabajo 1 copia 7.png" alt="logo">
                        </a>
                    </div>
                </div>
                <div class="nk-header-tools">
                    <ul class="nk-quick-nav">
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
                                        <li><a href="./vista/usuario/vistaPerfil.php"><em class="icon bi bi-person"></em><span> Perfil</span></a></li>
                                        <li><a href="#"><em class="icon bi bi-gear"></em><span>Account Setting</span></a></li>
                                        <li><a href="#"><em class="icon bi bi-activity"></em><span>Login Activity</span></a></li>
                                    </ul>
                                </div>
                                <div class="dropdown-inner">
                                    <ul class="link-list">
                                        <li><a href="./registro/logout.php"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- content @s -->
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block">
                        <div class="card-inner card-inner-lg">
                            <div class="nk-block-head nk-block-head-lg">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Información local</h4>                                                            
                                    </div>
                                    <div class="nk-block-head-content align-self-start d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-block">
                                <div class="nk-data data-list">
                                    <div class="data-head">
                                        <h6 class="overline-title">Datos local</h6>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Nombre</span>
                                            <span class="data-value"><?php echo $dato['nombre_local']; ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Tipo de local</span>
                                            <span class="data-value"><?php echo $dato['tipo_local'];?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                    <div class="data-item">
                                        <div class="data-col">
                                            <span class="data-label">Género musical</span>
                                            <span class="data-value"><?php echo $dato['genero_musical'];?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Descripción</span>
                                            <span class="data-value text-soft"><?php echo $dato['descripcion'];?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Días de apertura</span>
                                            <span class="data-value"><?php echo $dato['dias_abierto'];?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Hora apertura</span>
                                            <span class="data-value"><?php echo $dato['hora_apertura'];?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit">
                                        <div class="data-col">
                                            <span class="data-label">Hora cierre</span>
                                            <span class="data-value"><?php echo $dato['hora_cierre'];?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit" data-tab-target="#address">
                                        <div class="data-col">
                                            <span class="data-label">Edad recomendada</span>
                                            <span class="data-value"><?php echo $dato['edad_recomendada'];?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#profile-edit" data-tab-target="#address">
                                        <div class="data-col">
                                            <span class="data-label">Rango de precio</span>
                                            <span class="data-value"><?php echo $dato['precio_rango'];?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                </div><!-- data-list -->
                                <!-- <div class="nk-data data-list">
                                    <div class="data-head">
                                        <h6 class="overline-title">Preferences</h6>
                                    </div>
                                    <div class="data-item">
                                        <div class="data-col">
                                            <span class="data-label">Language</span>
                                            <span class="data-value">English (United State)</span>
                                        </div>
                                        <div class="data-col data-col-end"><a href="#" class="link link-primary">Change Language</a></div>
                                    </div>
                                    <div class="data-item">
                                        <div class="data-col">
                                            <span class="data-label">Date Format</span>
                                            <span class="data-value">M d, YYYY</span>
                                        </div>
                                        <div class="data-col data-col-end"><a href="#" class="link link-primary">Change</a></div>
                                    </div>
                                    <div class="data-item">
                                        <div class="data-col">
                                            <span class="data-label">Timezone</span>
                                            <span class="data-value">Bangladesh (GMT +6)</span>
                                        </div>
                                        <div class="data-col data-col-end"><a href="#" class="link link-primary">Change</a></div>
                                    </div>
                                </div> --><!-- data-list -->
                            </div><!-- .nk-block -->
                        </div>                                                    
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content @e -->                
    
    <!-- @@ Profile Edit Modal @e -->
    <div class="modal fade" role="dialog" id="profile-edit">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title">Modificar datos local</h5>
                    <ul class="nk-nav nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personal">Datos</a>
                        </li>
                       <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#address">Ubicacion</a>
                        </li>
                    </ul><!-- .nav-tabs -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="personal">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name">Nombre</label>
                                        <input type="text" class="form-control form-control-lg" id="nombre" name="nombre" value="<?php echo $dato['nombre_local'] ?>" placeholder="Introduce un nombre del local">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="tipo-local">Tipo local</label>
                                        <input type="text" class="form-control form-control-lg" id="tipo_local" name="tipo_local" value="<?php echo $dato['tipo_local'];?>" placeholder="Enter display name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="descripcion">Descripción</label>
                                        <input type="text" class="form-control form-control-lg" id="descripcion" name="descripcion" value="<?php echo $dato['descripcion'];?>" placeholder="Phone Number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="birth-day">Date of Birth</label>
                                        <input type="text" class="form-control form-control-lg date-picker" id="date_birth" name="date_birth" value="<?php $date_birth = $controllerUser->getDateBirthById($_SESSION['user']); echo $date_birth;?>" placeholder="Enter your birth date">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="add">Address</label>
                                        <input type="text" class="form-control form-control-lg " id="address" name="address" value="<?php $address = $controllerUser->getAddressById($_SESSION['user']); echo $address;?>" placeholder="Enter your address">
                                    </div>
                                </div>
                               <!--  <div class="col-12">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="latest-sale">
                                        <label class="custom-control-label" for="latest-sale">Use full name to display </label>
                                    </div>
                                </div> -->
                                <div id="id" style="display: none;"><?php echo $_SESSION['user']; ?></div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <button type="button" class="btn btn-lg btn-primary" id="botonUpdate" name="botonUpdate">Update Profile</button>
                                        </li>
                                        <li>
                                            <a href="view/user/viewProfile.php" class="link link-light">Cancel</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- .tab-pane -->                

                        <div class="tab-pane" id="address">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="address-l1">Address Line 1</label>
                                        <input type="text" class="form-control form-control-lg" id="address-l1" value="2337 Kildeer Drive">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="address-l2">Address Line 2</label>
                                        <input type="text" class="form-control form-control-lg" id="address-l2" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="address-st">State</label>
                                        <input type="text" class="form-control form-control-lg" id="address-st" value="Kentucky">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="address-county">Country</label>
                                        <select class="form-select js-select2" id="address-county" data-ui="lg">
                                            <option>Canada</option>
                                            <option>United State</option>
                                            <option>United Kindom</option>
                                            <option>Australia</option>
                                            <option>India</option>
                                            <option>Bangladesh</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <a href="#" class="btn btn-lg btn-primary" data-bs-dismiss="modal">Update Address</a>
                                        </li>
                                        <li>
                                            <a href="#" data-bs-dismiss="modal" class="link link-light">Cancel</a>
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
