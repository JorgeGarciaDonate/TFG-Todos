<?php
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(__DIR__) . DS);
require_once (ROOT . DS . "core" . DS . "init.php");
$LocalController = new LocalController();
/* $locales = $LocalController->allLocales(); */
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Página</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;800&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 

    <!-- Agrega el script de Leaflet Control Geocoder -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
</head>

<body>
    <header>
        <div class="logo">
            <a href="index.php">
                <h2>Cheersy</h2>
            </a>
        </div>
        <div class="profile-button">
            <button id="profile-dropdown-btn">
                <img src="perfil-icono.png" alt="Perfil">
                Mi Perfil
            </button>
            <div class="dropdown-content" id="profile-dropdown">
                <!-- Formulario para registrarse -->
                <form method="POST" action="../controlador/indexController.php">
                    <input type="hidden" name="redireccion" value="registro">
                    <button type="submit" id="registroButton" name="redireccion" value="registro">Registrarme</button>
                </form>
                <!-- Formulario para iniciar sesión -->
                <form method="POST" action="../controlador/indexController.php">
                    <input type="hidden" name="redireccion" value="login">
                    <button type="submit" id="loginButton" name="redireccion" value="login">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </header>

    <style>

    </style>

    <script>
        // Función para mostrar u ocultar el menú desplegable
        function toggleDropdown() {
            const dropdownContent = document.getElementById('profile-dropdown');
            dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
        }

        // Asignar evento al botón de perfil para mostrar/ocultar el menú
        document.getElementById('profile-dropdown-btn').addEventListener('click', function () {
            toggleDropdown();
        });

        // Restaurar el estado del menú desplegable al cargar la página
        window.addEventListener('load', function () {
            const dropdownContent = document.getElementById('profile-dropdown');
            // Comprobar si el menú estaba abierto (usando una cookie o localStorage)
            const isDropdownOpen = localStorage.getItem('dropdownOpen') === 'true';
            if (isDropdownOpen) {
                dropdownContent.style.display = 'block';
            } else {
                dropdownContent.style.display = 'none';
            }
        });

        // Guardar el estado del menú desplegable al navegar lejos del index.php
        window.addEventListener('beforeunload', function () {
            const dropdownContent = document.getElementById('profile-dropdown');
            const isDropdownOpen = dropdownContent.style.display === 'block';
            localStorage.setItem('dropdownOpen', isDropdownOpen ? 'true' : 'false');
        });
    </script>





    <h1></h1>
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
                <input type="checkbox" id="lunes" name="dias_abierto" value="LUNES">
                <label for="lunes">Lunes</label>
                <input type="checkbox" id="martes" name="dias_abierto" value="MARTES">
                <label for="martes">Martes</label>
                <input type="checkbox" id="miercoles" name="dias_abierto" value="MIERCOLES">
                <label for="miercoles">Miércoles</label>
                <input type="checkbox" id="jueves" name="dias_abierto" value="JUEVES">
                <label for="jueves">Jueves</label>
                <input type="checkbox" id="viernes" name="dias_abierto" value="VIERNES">
                <label for="viernes">Viernes</label>
                <input type="checkbox" id="sabado" name="dias_abierto" value="SABADO">
                <label for="sabado">Sábado</label>
                <input type="checkbox" id="domingo" name="dias_abierto" value="DOMINGO">
                <label for="domingo">Domingo</label>
                <input type="checkbox" id="todos" name="dias_abierto" value="TODOS">
                <label for="todos">Todos</label>
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
            <div class="search-input">
                <h3>Introduce la zona/barrio/estación de metro:</h3>
                <!--  <label for="search-input">Introduce la zona/barrio/estación de metro:</label> -->
                <input type="text" id="search-input" aria-label="Buscar zona/barrio/estación de metro">
            </div>

            <div class="view-toggle">
                <button id="map-view">Mapa</button>
                <button id="list-view" name="list-view">Listado</button>
            </div>

           
            <script src="../assets/js/verLocales.js"></script>    
            <script src="../assets/js/jquery-3.6.0.minundle.js"></script>
            <script src="../assets/js/jquery-3.6.0.min.js"></script>
            <script src="../assets/js/bundle.js"></script>


<!-- 
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const mapViewButton = document.getElementById('map-view');
                    const listViewButton = document.getElementById('list-view');
                    const mapContainer = document.getElementById('map');
                    const listContainer = document.getElementById('list-container'); // Añadir el ID correcto

                    // Función para mostrar el mapa y ocultar el listado
                    function showMapView() {
                        mapContainer.style.display = 'block';
                        listContainer.style.display = 'none';
                    }

                    // Función para mostrar el listado y ocultar el mapa
                    function showListView() {
                        mapContainer.style.display = 'none';
                        listContainer.style.display = 'block'; // Mostrar el contenedor del listado
                    }

                    // Configurar eventos de clic para los botones
                    mapViewButton.addEventListener('click', showMapView);
                    listViewButton.addEventListener('click', showListView);

                    // Mostrar el mapa por defecto al cargar la página
                    showMapView(); // Opcional si quieres que el mapa sea el predeterminado
                });

            </script> -->
        </div>


        <div id="map" class="map"></div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.js"></script>
        <!-- <script>
            // Espera a que el DOM esté completamente cargado
            document.addEventListener('DOMContentLoaded', function () {
                var map = L.map('map');

                // Obtén la ubicación actual del usuario
                if ('geolocation' in navigator) {
                    navigator.geolocation.getCurrentPosition(function (position) {
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

                        // Array de ubicaciones de locales (latitud, longitud, nombre)
                        var locations = [
                            { lat: 40.435731, lon: -3.691698, name: 'Bonded' },
                            { lat: 40.436122, lon: -3.691836, name: 'Panthera' },
                            { lat: 40.435089, lon: -3.690175, name: 'Maddock' },
                            { lat: 40.423269, lon: -3.713214, name: 'Fitz Club' },
                            { lat: 40.406399, lon: -3.690660, name: 'Kapital' },
                            { lat: 40.42, lon: -3.69, name: 'Vandido' },
                            { lat: 40.42, lon: -3.69, name: 'Joy Eslava' }
                        ];

                        // Función para calcular la ruta desde la ubicación actual hasta el local
                        function calcularRuta(destLat, destLon) {
                            L.Routing.control({
                                waypoints: [
                                    L.latLng(lat, lon),  // Ubicación actual del usuario
                                    L.latLng(destLat, destLon)  // Ubicación del local seleccionado
                                ],
                                routeWhileDragging: true
                            }).addTo(map);
                        }

                        // Itera sobre cada ubicación y agrega un marcador al mapa
                        locations.forEach(function (location) {
                            var marker = L.marker([location.lat, location.lon]).addTo(map)
                                .bindPopup(location.name)
                                .on('click', function () {
                                    // Al hacer clic en el marcador, calcula la ruta desde la ubicación actual
                                    calcularRuta(location.lat, location.lon);
                                });
                        });

                    });
                } else {
                    // Si la geolocalización no está disponible, muestra un mensaje de error
                    alert('Geolocalización no disponible');
                }
            });
        </script> -->

    </div>
    </div>

    <footer>
        <ul>
            <li><a href="https://www.instagram.com/cheersy.app/">Instagram - @cheersy.app</a></li>
            <li><a href="https://www.facebook.com/profile.php?id=61553869796205">Facebook - Cheersy App</a></li>
        </ul>
    </footer>
</body>

</html>