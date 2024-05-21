<?php
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__DIR__) . DS);
require_once(ROOT . DS . "core" . DS . "init.php");
$LocalController = new LocalController();
/*$locales = $LocalController->allLocales(); */
$locales = $LocalController->coordLocales();
$usuarioController = new UsuarioController();

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

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <!-- Agrega el script de Leaflet Control Geocoder -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
</head>
<body>
    <?php if(isset($_SESSION['user']) && $_SESSION['user']){?>
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
                                        <div class="user-name dropdown-indicator"><span><?php echo $usuarioController->getNombreById($_SESSION['user']);?></span></div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1">
                                <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                    <div class="user-card">
                                        <div class="user-avatar">
                                            <span><i class="bi bi-person"></i></span>
                                        </div>
                                        <div class="user-info">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-inner">
                                    <ul class="link-list">
                                        <li><a href="../Login/view/user/viewProfile.php"><i class="bi bi-person"></i><span>View Profile</span></a></li>
                                        <li><a href="#"><i class="bi bi-gear"></i><span>Account Setting</span></a></li>
                                        <li><a href="#"><i class="bi bi-activity"></i><span>Login Activity</span></a></li>
                                        <li><a class="dark-switch" href="#"><i class="bi bi-moon-fill"></i><span>Dark Mode</span></a></li>
                                    </ul>
                                </div>
                                <div class="dropdown-inner">
                                    <ul class="link-list">
                                        <li><a href="./registro/logout.php"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
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
                            <img class="" src="../assets/img/png/Logotipo/Logo-Iconos_Mesa de trabajo 1 copia 7.png" srcset="./assets/img/logo2x.png 2x" alt="logo">
                        </a>                                    
                    </div>
                </div><!-- .nk-header-news -->
                <div class="nk-header-tools">
                    <div class="nk-news-list">
                        <a href="registro/registro.php" class="btn btn-icon" ><span>Registrarse</span></a>
                        <a href="registro/login.php" class="btn btn-icon" ><span>Iniciar Sesión</span></a>                        
                    </div>                   
                </div><!-- .nk-header-tools -->
            </div><!-- .nk-header-wrap -->
        </div><!-- .container-fluid -->
    </div> 
    <?php } ?>

    <h1>Inicio</h1>
    <div class="container">

        <div class="filters">
            <h2>Filtros</h2>
            <div class="filter-item">
                <label for="hora_apertura">Hora de Apertura:</label>
                <input type="text" id="hora_apertura" name="hora_apertura" placeholder="HH:MM">
            </div>

            <div class="filter-item">
                <label for="hora_cierre">Hora de Cierre:</label>
                <input type="text" id="hora_cierre" name="hora_cierre" placeholder="HH:MM">
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
                <input type="checkbox" id="miercoles" name="dias_abierto" value="MIERCOLES">
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
                <input type="checkbox" id="sabado" name="dias_abierto" value="SABADO">
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
                <label for="genero_musical">Género Musical:</label>
                <select id="genero_musical" name="genero_musical">
                    <option value="REGGAETON">Reggaeton</option>
                    <option value="TECHNO">Techno</option>
                    <option value="ELECTRONICA">Electrónica</option>
                    <option value="ROCK">Rock</option>
                    <option value="POP">Pop</option>
                </select>
            </div>

            <div class="filter-item">
                <label for="edad_recomendada">Edad Recomendada:</label>
                <input type="number" id="edad_recomendada" name="edad_recomendada" min="0" max="99">
            </div>

            <div class="filter-item">
                <label for="precio_min">Precio Mínimo:</label>
                <input type="number" id="precio_min" name="precio_min" min="0" step="0.01">
            </div>

            <div class="filter-item">
                <label for="precio_max">Precio Máximo:</label>
                <input type="number" id="precio_max" name="precio_max" min="0" step="0.01">
            </div>

            <div class="filter-item">
                <label for="nota">Nota:</label>
                <select id="nota" name="nota">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
        </div>

        <div class="search">
    <div class="search-input" alt="formulario búsqueda">
        <h3>Introduce la zona/barrio/estación de metro:</h3>
        <input type="text" id="search-input" aria-label="Buscar zona/barrio/estación de metro">
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.js"></script>
    <script src="../assets/js/jquery-3.6.0.minundle.js"></script>
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/verLocales.js"></script>
    <script src="../assets/js/bundle.js"></script>

    <div class="view-toggle">
        <button id="map-view">Mapa</button>
        <button id="list-view">Listado</button>
    </div>

    <div id="map" class="map"></div>

   

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map');
            var locations = <?php echo json_encode($locales) ?>;

            function initMap() {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lon = position.coords.longitude;

                    // Establece la vista del mapa en la ubicación actual del usuario
                    map.setView([lat, lon], 13);

                    // Añade una capa de mapa base de OpenStreetMap
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);

                    // Añade un marcador en la ubicación actual del usuario
                    L.marker([lat, lon]).addTo(map)
                        .bindPopup('¡Estás aquí!')
                        .openPopup();

                    // Agrega marcadores para cada ubicación en el mapa
                    locations.forEach(function(location) {
                        L.marker([location.ubicacion.latitud, location.ubicacion.longitud]).addTo(map)
                            .bindPopup(location.nombre_local);
                    });
                });
            }

            // Inicializar el mapa al cargar la página
            initMap();

            // Manejar el cambio de vista al hacer clic en los botones
            document.getElementById('map-view').addEventListener('click', function() {
                document.getElementById('map').style.display = 'block';
                // Aquí puedes mostrar el mapa y ocultar la lista si es necesario
                // Por ejemplo, ocultar un elemento de lista
                // document.getElementById('lista-locales').style.display = 'none';
            });

            document.getElementById('list-view').addEventListener('click', function() {
                document.getElementById('map').style.display = 'none';
                // Aquí puedes mostrar la lista y ocultar el mapa si es necesario
                // Por ejemplo, mostrar un elemento de lista
                // document.getElementById('lista-locales').style.display = 'block';
            });
        });
    </script>
<!-- </div>

    </div> -->

</body>

<footer>
    <ul class="Redes">
        <li>
            <a href="https://www.instagram.com/cheersy.app/"><img class="" src="../assets/img/png/RRSS/Logo-Iconos_Mesa de trabajo 1 copia 15.png" alt="logo"></a>
        </li>
        <li>
            <a href="https://www.facebook.com/profile.php?id=61553869796205"><img class="" src="../assets/img/png/RRSS/Logo-Iconos_Mesa de trabajo 1 copia 16.png" alt="logo"></a>
        </li>
    </ul>
</footer>

</html>