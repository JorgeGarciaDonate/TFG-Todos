document.addEventListener('DOMContentLoaded', function() {
    var map;

    function initMap() {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;

            // Inicializa el mapa solo si no está ya inicializado
            if (!map) {
                map = L.map('map').setView([lat, lon], 13);

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
            } else {
                // Si el mapa ya está inicializado, simplemente cambia la vista
                map.setView([lat, lon], 13);
            }
        });
    }

    // Inicializar el mapa al cargar la página
    initMap();

    // Manejar el cambio de vista al hacer clic en los botones
    document.getElementById('map-view').addEventListener('click', function() {
        // Mostrar mapa y ocultar listado
        document.getElementById('map').style.display = 'block';
        document.getElementById('list-container').style.display = 'none';
        initMap();
    });

    document.getElementById('list-view').addEventListener('click', function() {
        // Ocultar mapa y mostrar listado
        document.getElementById('map').style.display = 'none';
        document.getElementById('list-container').style.display = 'block';

        // Realizar una solicitud AJAX para obtener los datos de los locales
        $.ajax({
            type: 'POST', // Cambiar a POST
            url: '../controlador/LocalController.php',
            data: { action: 'allLocales' }, // Aquí envías la acción 'allLocales' al controlador
            dataType: 'json',
            success: function(response) {
                // Limpiar el contenedor antes de mostrar nuevos datos
                $('#list-container').empty();

                // Iterar sobre los locales recibidos y mostrar la información
                response.forEach(function(local) {
                    var localItem = $('<div>').addClass('local-item');
                    localItem.append($('<h4>').text(local.nombre_local));
                    localItem.append($('<p>').text('Tipo: ' + local.tipo_local));
                    localItem.append($('<p>').text('Descripción: ' + local.descripcion));

                    $('#list-container').append(localItem);
                });

                // Mostrar el contenedor de listado y ocultar el mapa
                $('#map').hide();
                $('#list-container').show();
            },
            error: function() {
                // Mostrar un mensaje de error en caso de fallo
                $('#list-container').text('Error al cargar los locales. Inténtalo de nuevo más tarde.');
            }
        });
    });
});