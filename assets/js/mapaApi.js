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
            type: 'POST',
            url: '../controlador/LocalController.php',
            data: { action: 'allLocales' }, // Aquí envías la acción 'allLocales' al controlador
            dataType: 'json',
            success: function(response) {
                $('#list-container').empty();
                response.forEach(function(local) {
                    var localItem = $('<div>').addClass('local-item');
                    
                    if (local.fotos.length > 0) {
                        var fotosContainer = $('<div>').addClass('fotos-container');
                        local.fotos.forEach(function(foto) {
                            var fotoPath = 'http://localhost/TFG-Todos/TFG-Todos/assets/img/locales/' + foto.nombre_foto + ".jpg";
                            var fotoElement = $('<img>').attr('src', fotoPath).addClass('foto-local');
                            fotosContainer.append(fotoElement);
                        });
                        localItem.append(fotosContainer);
                    }
            
                    var localContent = $('<div>').addClass('local-content');
                    var leftColumn = $('<div>').addClass('left-column');
                    var rightColumn = $('<div>').addClass('right-column');
                    
                    leftColumn.append($('<h4>').text(local.nombre_local));
                    leftColumn.append($('<p>').text('Tipo: ' + local.tipo_local));
                    leftColumn.append($('<p>').text('Descripción: ' + local.descripcion));
                    leftColumn.append($('<p>').text('Hora de apertura: ' + local.hora_apertura + ' - Hora de cierre: ' + local.hora_cierre));
                    leftColumn.append($('<p>').text('Abierto: ' + local.dias_abierto));
                    leftColumn.append($('<p>').text('Tipo de música: ' + local.genero_musical));
                    leftColumn.append($('<p>').text('Edad media: ' + local.edad_recomendada));
                    leftColumn.append($('<p>').text('Precio medio: ' + local.precio_rango + " €"));
                    
                    rightColumn.append($('<h6>').text('Ubicación:'));
                    rightColumn.append($('<p>').text('Calle: ' + local.ubicacion.calle + ' ' + local.ubicacion.num_calle));
                    rightColumn.append($('<p>').text('Ciudad: ' + local.ubicacion.ciudad + ' Zona: ' + local.ubicacion.zona));
                    rightColumn.append($('<p>').text('Código postal: ' + local.ubicacion.cod_postal));
                    
                    localContent.append(leftColumn);
                    localContent.append(rightColumn);
                    localItem.append(localContent);
                    
                    $('#list-container').append(localItem);
                });
            
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