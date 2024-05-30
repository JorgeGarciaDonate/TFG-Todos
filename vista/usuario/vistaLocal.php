<?php 
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__FILE__) . DS);
require_once(ROOT . ".." . DS . ".." . DS . "core" . DS . "init.php");

$usuarioController = new UsuarioController();
$localController = new LocalController();
$ubicacionController = new UbicacionController();
if(!$_SESSION['user']){
    Redirect::to('../index.php');
}
$localesUser = $localController->getLocalesByUsuario_id($_SESSION['user']);
$local_id = $_GET['local_id'];
$datos = $localController -> getDatoslocal($local_id);


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
    <title>Datos local</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.css">
    <link id="skin-default" rel="stylesheet" href="./assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 
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
                                        <li><a href="vista/usuario/vistaPerfil.php"><span> Perfil</span></a></li>
                                        <?php if ($usuarioController->es_propietario($_SESSION['user'])): ?>
                                            <?php foreach ($localesUser as $local): ?>
                                                <li>
                                                    <a href="vista/usuario/vistaLocal.php?local_id=<?php echo $local['local_id']; ?>">
                                                        <span><?php echo $local['nombre_local']; ?></span>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>                                            
                                        <li><a href="vista/usuario/vistaFavoritos.php"><span>Favoritos</span></a></li>
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
                                    <div class="nk-block-head-content">
                                        <form action="./controlador/LocalController.php" method="POST" onsubmit="return confirm('¿Está seguro de que desea eliminar este local?');">
                                            <input type="hidden" name="local_id" value="<?php echo $local_id?>">
                                            <button type="submit" name="borrarLocal" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                                                <em class="icon ni ni-arrow-left"></em><span>Dar de baja local</span>
                                            </button>
                                        </form>
                                    </div> 
                                </div>
                            </div>
                            <div class="nk-block">
                                <div class="nk-data data-list">
                                    <div class="data-head">
                                        <h6 class="overline-title">Datos local</h6>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#datos-edit">
                                        <div class="data-col">
                                            <span class="data-label">Nombre</span>
                                            <span class="data-value"><?php echo $dato['nombre_local']; ?></span>
                                        </div>
                                        <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#datos-edit">
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
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#datos-edit">
                                        <div class="data-col">
                                            <span class="data-label">Descripción</span>
                                            <span class="data-value text-soft"><?php echo $dato['descripcion'];?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>                                    
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#datos-edit" data-tab-target="#address">
                                        <div class="data-col">
                                            <span class="data-label">Edad recomendada</span>
                                            <span class="data-value"><?php echo $dato['edad_recomendada'];?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#datos-edit" data-tab-target="#address">
                                        <div class="data-col">
                                            <span class="data-label">Rango de precio</span>
                                            <span class="data-value"><?php echo $dato['precio_rango'];?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                </div><!-- data-list -->
                                <div class="nk-data data-list">
                                    <div class="data-head">
                                        <h6 class="overline-title">Horarios</h6>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#datos-edit">
                                        <div class="data-col">
                                            <span class="data-label">Días de apertura</span>
                                            <span class="data-value"><?php echo $dato['dias_abierto'];?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#datos-edit">
                                        <div class="data-col">
                                            <span class="data-label">Hora apertura</span>
                                            <span class="data-value"><?php echo $dato['hora_apertura'];?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#datos-edit">
                                        <div class="data-col">
                                            <span class="data-label">Hora cierre</span>
                                            <span class="data-value"><?php echo $dato['hora_cierre'];?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                    
                                </div> <!-- data-list -->
                                <div class="nk-data data-list">
                                    <?php 
                                    $datosUbicacion = $ubicacionController -> getDatosUbicacion($dato['ubicacion_id']);
                                    foreach($datosUbicacion as $datoUbi){ ?>
                                    <div class="data-head">
                                        <h6 class="overline-title">Ubicacion</h6>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#datos-edit">
                                        <div class="data-col">
                                            <span class="data-label">Calle</span>
                                            <span class="data-value"><?php echo $datoUbi['calle'];?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#datos-edit">
                                        <div class="data-col">
                                            <span class="data-label">Número de calle</span>
                                            <span class="data-value"><?php echo $datoUbi['num_calle'];?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#datos-edit">
                                        <div class="data-col">
                                            <span class="data-label">Zona</span>
                                            <span class="data-value"><?php echo $datoUbi['zona'];?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#datos-edit">
                                        <div class="data-col">
                                            <span class="data-label">Ciudad</span>
                                            <span class="data-value"><?php echo $datoUbi['ciudad'];?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>
                                    <div class="data-item" data-bs-toggle="modal" data-bs-target="#datos-edit">
                                        <div class="data-col">
                                            <span class="data-label">Código postal</span>
                                            <span class="data-value"><?php echo $datoUbi['cod_postal'];?></span>
                                        </div>
                                        <div class="data-col data-col-end"></div>
                                    </div>                                                                        
                                </div> <!-- data-list -->
                            </div><!-- .nk-block -->
                        </div>                                                    
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content @e -->                
    
    <!-- @@ Profile Edit Modal @e -->
    <div class="modal fade" role="dialog" id="datos-edit">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title">Modificar datos local</h5>
                    <ul class="nk-nav nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#datos">Datos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#horarios">Horarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#address">Ubicacion</a>
                        </li>
                    </ul><!-- .nav-tabs -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="datos">
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
                                        <select class="form-control form-control-lg" id="tipo_local" name="tipo_local">
                                            <option value="" disabled selected>Seleccione un tipo de local</option>
                                            <option value="BAR" <?php echo ($dato['tipo_local'] == 'BAR') ? 'selected' : ''; ?>>BAR</option>
                                            <option value="PUB" <?php echo ($dato['tipo_local'] == 'PUB') ? 'selected' : ''; ?>>PUB</option>
                                            <option value="DISCOTECA" <?php echo ($dato['tipo_local'] == 'DISCOTECA') ? 'selected' : ''; ?>>DISCOTECA</option>
                                            <option value="RESTAURANTE" <?php echo ($dato['tipo_local'] == 'RESTAURANTE') ? 'selected' : ''; ?>>RESTAURANTE</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="genero_musical">Género musical</label>
                                        <div class="checkbox-group" id="genero_musical">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="genero_musical[]" value="REGGAETON" id="reggaeton" <?php echo (in_array('REGGAETON', explode(',', $dato['genero_musical']))) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="reggaeton">REGGAETON</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="genero_musical[]" value="TECHNO" id="techno" <?php echo (in_array('TECHNO', explode(',', $dato['genero_musical']))) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="techno">TECHNO</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="genero_musical[]" value="ELECTRÓNICA" id="electronica" <?php echo (in_array('ELECTRÓNICA', explode(',', $dato['genero_musical']))) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="electronica">ELECTRÓNICA</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="genero_musical[]" value="ROCK" id="rock" <?php echo (in_array('ROCK', explode(',', $dato['genero_musical']))) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="rock">ROCK</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="genero_musical[]" value="POP" id="pop" <?php echo (in_array('POP', explode(',', $dato['genero_musical']))) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="pop">POP</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="genero_musical[]" value="JAZZ" id="jazz" <?php echo (in_array('JAZZ', explode(',', $dato['genero_musical']))) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="jazz">JAZZ</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="precio_rango">Rango de precio</label>
                                        <select class="form-control form-control-lg" id="precio_rango" name="precio_rango">
                                            <option value="" disabled selected>Seleccione un rango de precio</option>
                                            <option value="0-20" <?php echo ($dato['precio_rango'] == '0-20') ? 'selected' : ''; ?>>0-20</option>
                                            <option value="20-50" <?php echo ($dato['precio_rango'] == '20-50') ? 'selected' : ''; ?>>20-50</option>
                                            <option value="50+" <?php echo ($dato['precio_rango'] == '50+') ? 'selected' : ''; ?>>50+</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="edad_recomendada">Edad recomendada</label>
                                        <input type="number" class="form-control form-control-lg" id="edad_recomendada" name="edad_recomendada" value="<?php echo $dato['edad_recomendada']; ?>" placeholder="Ingrese la edad recomendada">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="descripcion">Descripción</label>
                                        <input type="text" class="form-control form-control-lg" id="descripcion" name="descripcion" value="<?php echo $dato['descripcion'];?>" placeholder="Introduce una descripción">
                                    </div>
                                </div> 
                                <div id="local_id" style="display: none;"><?php echo $dato['local_id']; ?></div>                               
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <button type="button" class="btn btn-lg btn-primary" id="botonUpdateDatos" name="botonUpdateDatos">Actualizar datos</button>
                                        </li>
                                        <li>
                                            <a href="vista/usuario/vistaLocal.php?local_id=<?php echo $local['local_id']; ?>" class="link link-light">Cancelar</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- .tab-pane -->                

                        <div class="tab-pane" id="horarios">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="dias_abierto">Días abierto</label>
                                        <div class="checkbox-group" id="dias_abierto">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="dias_abierto[]" value="LUNES" id="lunes" <?php echo (in_array('LUNES', explode(',', $dato['dias_abierto']))) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="lunes">LUNES</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="dias_abierto[]" value="MARTES" id="martes" <?php echo (in_array('MARTES', explode(',', $dato['dias_abierto']))) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="martes">MARTES</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="dias_abierto[]" value="MIÉRCOLES" id="miercoles" <?php echo (in_array('MIÉRCOLES', explode(',', $dato['dias_abierto']))) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="miercoles">MIÉRCOLES</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="dias_abierto[]" value="JUEVES" id="jueves" <?php echo (in_array('JUEVES', explode(',', $dato['dias_abierto']))) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="jueves">JUEVES</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="dias_abierto[]" value="VIERNES" id="viernes" <?php echo (in_array('VIERNES', explode(',', $dato['dias_abierto']))) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="viernes">VIERNES</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="dias_abierto[]" value="SÁBADO" id="sabado" <?php echo (in_array('SÁBADO', explode(',', $dato['dias_abierto']))) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="sabado">SÁBADO</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="dias_abierto[]" value="DOMINGO" id="domingo" <?php echo (in_array('DOMINGO', explode(',', $dato['dias_abierto']))) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="domingo">DOMINGO</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="horario_apertura">Hora apertura</label>
                                        <input type="time" class="form-control form-control-lg" id="hora_apertura" name="hora_apertura" value="<?php echo $dato['hora_apertura']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="horario_cierre">Hora cierre</label>
                                        <input type="time" class="form-control form-control-lg" id="hora_cierre" name="hora_cierre" value="<?php echo $dato['hora_cierre']; ?>">
                                    </div>
                                </div>
                                <div id="local_id" style="display: none;"><?php echo $dato['local_id']; ?></div>                               
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <a href="#" class="btn btn-lg btn-primary" data-bs-dismiss="modal" id="botonUpdateHorario" name="botonUpdateHorario">Actualizar horarios</a>
                                        </li>
                                        <li>
                                            <a href="vista/usuario/vistaLocal.php?local_id=<?php echo $local['local_id']; ?>" data-bs-dismiss="modal" class="link link-light">Cancelar</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div> 
                        <div class="tab-pane" id="address">
                            <div class="row gy-4">                               
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="calle">Calle</label>
                                        <input type="text" class="form-control form-control-lg" id="calle" name="calle" value="<?php echo $datoUbi['calle']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="num_calle">Número de calle</label>
                                        <input type="text" class="form-control form-control-lg" id="num_calle" name="num_calle" value="<?php echo $datoUbi['num_calle']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="zona">Zona</label>
                                        <input type="text" class="form-control form-control-lg" id="zona" name="zona" value="<?php echo $datoUbi['zona']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="ciudad">Ciudad</label>
                                        <input type="text" class="form-control form-control-lg" id="ciudad" name="ciudad" value="<?php echo $datoUbi['ciudad']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="cod_postal">Código postal</label>
                                        <input type="text" class="form-control form-control-lg" id="cod_postal" name="cod_postal" value="<?php echo $datoUbi['cod_postal']; ?>">
                                    </div>
                                </div>
                                <div id="ubicacion_id" style="display: none;"><?php echo $datoUbi['ubicacion_id']; ?></div>
                                <div id="longitud" style="display: none;"><?php echo $datoUbi['longitud']; ?></div>
                                <div id="latitud" style="display: none;"><?php echo $datoUbi['latitud']; ?></div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <a href="#" class="btn btn-lg btn-primary" data-bs-dismiss="modal" id="botonUpdateUbicacion" name="botonUpdateUbicacion">Actualizar ubicacion</a>
                                        </li>
                                        <li>
                                            <a href="vista/usuario/vistaLocal.php?local_id=<?php echo $local['local_id']; ?>" data-bs-dismiss="modal" class="link link-light">Cancelar</a>
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
    <script src="./assets/js/form/updateLocal.js"></script>  
</body>

</html>
<?php 
        }
    }
} else {
    echo "No data found for the user.";
}
?>
