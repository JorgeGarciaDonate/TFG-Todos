<?php
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__DIR__) . DS);
require_once (ROOT . DS . "core" . DS . "init.php");
$LocalController = new LocalController();
/*$locales = $LocalController->allLocales(); */
$locales = $LocalController->coordLocales();
$usuarioController = new UsuarioController();

$isLoggedIn = isset($_SESSION['user']) ? 'true' : 'false';

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Página</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/dashlite.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha384-DyF04EOve/0wZy8u7x3eYvPDzDW0YrYTd1zBBk0q3TK/VvqKecEK9LU5KG6+dSL2" crossorigin="anonymous">

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha384-J2BB9S6qFw4WVgZMzB8Eu5fXjkFHYj6+0QTGfVXW+XnIh+cucXDLmM3r+3OcPsAJ" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../assets/js/mapaApi.js" defer></script>
    <!--checkbox en listado si hay una sesion-->
    <script> var isLoggedIn = <?php echo $isLoggedIn; ?>; </script>
    <!-- <script src="../assets/js/verLocales.js" defer></script> -->
    <script>var locations = <?php echo json_encode($locales); ?>; </script>
    <script> var data = <?php echo json_encode($data); ?>; </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lsrc-routing-machine/3.2.12/leaflet-routing-machine.js"></script>
    <script src="../assets/js/jquery-3.6.0.minundle.js"></script>
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/mapaApi.js"></script>
    <!--  <script src="../assets/js/verLocales.js"></script> -->
    <script src="../assets/js/bundle.js"></script>

    <!-- Agrega el script de Leaflet Control Geocoder -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
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
                            <a href="index.php" class="logo">
                                <img class="" src="../assets/img/png/Logotipo/Logo-Iconos_Mesa de trabajo 1 copia 7.png" srcset="./assets/img/logo2x.png 2x" alt="logo">
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
                                            <li><a href="./usuario/vistaPerfil.php"><span> Perfil</span></a></li>
                                            <li><a href="./registro/AltaLocal.php"><span> Dar de alta un local</span></a></li>
                                            <?php if ($usuarioController->es_propietario($_SESSION['user'])): ?>
                                                <?php foreach ($localesUser as $local): ?>
                                                    <li>
                                                        <a href="./usuario/vistaLocal.php?local_id=<?php echo $local['local_id']; ?>">
                                                            <span><?php echo $local['nombre_local']; ?></span>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php endif; ?>                                            
                                            <li><a href="./usuario/vistaFavoritos.php"><span>Favoritos</span></a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-inner">
                                        <ul class="link-list">
                                            <li><a href="./registro/logout.php"><em class="icon ni ni-signout"></em><span>Cerrar sesión</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li><!-- .dropdown -->
                        </ul><!-- .nk-quick-nav -->
                    </div><!-- .nk-header-tools -->
                </div><!-- .nk-header-wrap -->
            </div><!-- .container-fluid -->
        </div>
    <?php } else { ?>
        <div class="nk-header nk-header-fixed is-light">
            <div class="container-fluid">
                <div class="nk-header-wrap">

                    <div class="nk-header-news d-none d-xl-block">
                        <div class="nk-news-list">
                            <a href="index.php" class="logo">
                                <img class="" src="../assets/img/png/Logotipo/Logo-Iconos_Mesa de trabajo 1 copia 7.png"
                                     alt="logo">
                            </a>
                        </div>
                    </div><!-- .nk-header-news -->
                    <div class="nk-header-tools">
                        <div class="nk-news-list">
                            <a href="registro/registro.php" class="btn btn-icon"><span>Registrarse</span></a>
                            <a href="registro/login.php" class="btn btn-icon"><span>Iniciar Sesión</span></a>
                        </div>
                    </div><!-- .nk-header-tools -->
                </div><!-- .nk-header-wrap -->
            </div><!-- .container-fluid -->
        </div>
    <?php } ?>

    <h1 class="h1-index" >INICIO</h1>


    <div class="container">
       <!--  <h1>Inicio</h1> -->     


       <div class="filters">
            <h2>Filtros</h2>
            <div class="filter-item">
                <label for="hora_apertura">Hora de Apertura:</label>
                <input type="time" id="hora_apertura" name="hora_apertura" placeholder="HH:MM">
            </div>

            <div class="filter-item">
                <label for="hora_cierre">Hora de Cierre:</label>
                <input type="time" id="hora_cierre" name="hora_cierre" placeholder="HH:MM">
            </div>

            <div class="filter-item">
                <label>Días Abierto:</label>
                <div>
                    <input type="checkbox" id="lunes" name="dias_abierto" value="LUNES">
                    <label for="lunes">Lunes</label>
                </div>
                <div>
                    <input type="checkbox" id="martes" name="dias_abierto" value="MARTES">
                    <label for="martes">Martes</label>
                </div>
                <div>
                    <input type="checkbox" id="miercoles" name="dias_abierto" value="MIÉRCOLES">
                    <label for="miercoles">Miércoles</label>
                </div>
                <div>
                    <input type="checkbox" id="jueves" name="dias_abierto" value="JUEVES">
                    <label for="jueves">Jueves</label>
                </div>
                <div>
                    <input type="checkbox" id="viernes" name="dias_abierto" value="VIERNES">
                    <label for="viernes">Viernes</label>
                </div>
                <div>
                    <input type="checkbox" id="sabado" name="dias_abierto" value="SÁBADO">
                    <label for="sabado">Sábado</label>
                </div>
                <div>
                    <input type="checkbox" id="domingo" name="dias_abierto" value="DOMINGO">
                    <label for="domingo">Domingo</label>
                </div>
                <div>
                    <input type="checkbox" id="todos" name="dias_abierto" value="TODOS">
                    <label for="todos">Todos</label>
                </div>
            </div>

            <div class="filter-item">
                <label for="tipo_local">Tipo de Local:</label>
                <select id="tipo_local" name="tipo_local">
                    <option value="BAR">Bar</option>
                    <option value="PUB">Pub</option>
                    <option value="DISCOTECA">Discoteca</option>
                    <option value="RESTAURANTE">Restaurante</option>
                </select>
            </div>

            <div class="filter-item">
                <label for="musica_en_vivo">Música en Vivo:</label>
                <input type="checkbox" id="musica_en_vivo" name="musica_en_vivo" value="true">
                <label for="musica_en_vivo">Sí</label>
            </div>

            <div class="filter-item">
                <label>Género Musical:</label>
                <div>
                    <input type="checkbox" id="genero_musical_reggaeton" name="genero_musical" value="REGGAETON">
                    <label for="genero_musical_reggaeton">Reggaeton</label>
                </div>
                <div>
                    <input type="checkbox" id="genero_musical_techno" name="genero_musical" value="TECHNO">
                    <label for="genero_musical_techno">Techno</label>
                </div>
                <div>
                    <input type="checkbox" id="genero_musical_electronica" name="genero_musical" value="ELECTRÓNICA">
                    <label for="genero_musical_electronica">Electrónica</label>
                </div>
                <div>
                    <input type="checkbox" id="genero_musical_rock" name="genero_musical" value="ROCK">
                    <label for="genero_musical_rock">Rock</label>
                </div>
                <div>
                    <input type="checkbox" id="genero_musical_pop" name="genero_musical" value="POP">
                    <label for="genero_musical_pop">Pop</label>
                </div>
            </div>

            <div class="filter-item">
                <label for="edad_recomendada">Edad Recomendada:</label>
                <input type="number" id="edad_recomendada" name="edad_recomendada" min="0" max="99">
            </div>
            
            <div class="filter-item">
                <label for="precio_rango">Rango de Precio:</label>
                <select id="precio_rango" name="precio_rango">
                    <option value="0-20">0-20</option>
                    <option value="20-50">20-50</option>
                    <option value="50+">50+</option>
                </select>
            </div>
            
            <button class="filters-button" id="btnFilters" name="btnFilters">Aplicar filtros</button>
        </div>


        <div class="search">
            <div class="search-input" alt="formulario búsqueda">
                <h2>Introduce la zona/barrio/estación de metro:</h2>
                <input type="text" id="search-input" aria-label="Buscar zona/barrio/estación de metro">
                <button class="search-button" id="btnSearch" name="btnSearch" >Buscar</button>
            </div>

            <div class="view-toggle">
                <button id="map-view">Mapa</button>
                <button id="list-view">Listado</button>
            </div>

            <div id="map" class="map"></div>
            <div id="list-container" style="display: none;"></div>
            <div id="pagination-container" style="display: none;"></div> <!-- Contenedor de paginación -->
        </div>
    </div>

            

</body>

<footer>
    <ul class="Redes">
        <li>
            <a href="https://www.instagram.com/cheersy.app/"><img class=""
                    src="../assets/img/png/RRSS/Logo-Iconos_Mesa de trabajo 1 copia 15.png" alt="logo"></a>
        </li>
        <li>
            <a href="https://www.facebook.com/profile.php?id=61553869796205"><img class=""
                    src="../assets/img/png/RRSS/Logo-Iconos_Mesa de trabajo 1 copia 16.png" alt="logo"></a>
        </li>
    </ul>
</footer>

</html>