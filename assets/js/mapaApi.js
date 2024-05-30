document.addEventListener('DOMContentLoaded', function () {
    var map;
    var currentPage = 1;
    var itemsPerPage = 5;
    var allLocales = [];

    function initMap(lat, lon) {
        if (!map) {
            map = L.map('map').setView([lat, lon], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            L.marker([lat, lon]).addTo(map)
                .bindPopup('¡Estás aquí!')
                .openPopup();

            locations.forEach(function (location) {
                L.marker([location.ubicacion.latitud, location.ubicacion.longitud]).addTo(map)
                    .bindPopup(location.nombre_local);
            });
        } else {
            map.setView([lat, lon], 13);
        }
    }

    function getCurrentPosition() {
        navigator.geolocation.getCurrentPosition(function (position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;
            initMap(lat, lon);
        });
    }

    // Inicializar el mapa al cargar la página
    getCurrentPosition();

    document.getElementById('map-view').addEventListener('click', function () {
        document.getElementById('map').style.display = 'block';
        document.getElementById('list-container').style.display = 'none';
        document.getElementById('pagination-container').style.display = 'none';
        getCurrentPosition();
    });

    document.getElementById('list-view').addEventListener('click', function () {
        document.getElementById('map').style.display = 'none';
        document.getElementById('list-container').style.display = 'block';
        document.getElementById('pagination-container').style.display = 'block';
        if (allLocales.length === 0) {
            loadLocales();
        } else {
            loadPage(currentPage);
        }
    });

    function loadLocales() {
        $.ajax({
            type: 'POST',
            url: '../controlador/LocalController.php',
            data: { action: 'allLocales' },
            dataType: 'json',
            success: function (response) {
                allLocales = response;
                loadPage(1);
            },
            error: function () {
                $('#list-container').text('Error al cargar los locales. Inténtalo de nuevo más tarde.');
            }
        });
    }

    function loadPage(page) {
        currentPage = page;
        var startIndex = (currentPage - 1) * itemsPerPage;
        var endIndex = Math.min(startIndex + itemsPerPage, allLocales.length);

        $('#list-container').empty();
        for (var i = startIndex; i < endIndex; i++) {
            var local = allLocales[i];
            var localItem = $('<div>').addClass('local-item');
    
            if (local.fotos.length > 0) {
                var fotosContainer = $('<div>').addClass('fotos-container');
                local.fotos.forEach(function (foto) {
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
            leftColumn.append($('<p>').text('Hora de apertura: ' + local.hora_apertura));
            leftColumn.append($('<p>').text('Hora de cierre: ' + local.hora_cierre));
            leftColumn.append($('<p>').text('Abierto: ' + local.dias_abierto));
            leftColumn.append($('<p>').text('Tipo de música: ' + local.genero_musical));
            leftColumn.append($('<p>').text('Edad media: ' + local.edad_recomendada));
            leftColumn.append($('<p>').text('Precio medio: ' + local.precio_rango + " €"));

            var ubicacionContent = $('<div>').addClass('ubicacion-content'); // Nuevo contenedor para los datos de ubicación
            ubicacionContent.append($('<h6>').text('Ubicación:'));
            ubicacionContent.append($('<p>').text('Calle: ' + local.ubicacion.calle + ' ' + local.ubicacion.num_calle));
            ubicacionContent.append($('<p>').text('Ciudad: ' + local.ubicacion.ciudad + ' Zona: ' + local.ubicacion.zona));
            ubicacionContent.append($('<p>').text('Código postal: ' + local.ubicacion.cod_postal));
                ubicacionContent.append(
                    $('<a>')
                      .attr('href', local.web)
                      .attr('target', '_blank')
                      .text('Sitio web')
                );
            localContent.append(leftColumn);
            localContent.append(ubicacionContent); // Agregar el bloque de ubicación
            localItem.append(localContent);
            localItem.append(rightColumn); // Añadir rightColumn al final
    
            if (isLoggedIn) {
                var saveButton = $('<button class="favs-button">').text('Añadir a favoritos').addClass('save-button').attr('data-local-id', local.local_id);

                // Contenedor para el checkbox y el botón de guardar
                var actionsContainer = $('<div>').addClass('actions-container');
                actionsContainer.append(saveButton);
                
                localItem.append(actionsContainer);

                saveButton.on('click', function() {
                    var localId = $(this).attr('data-local-id'); // Obtener el ID del local desde el atributo data-local-id del botón
                    guardarFav(localId); // Llamar a la función saveFavorite con el ID del local
                });
            }

            $('#list-container').append(localItem);
        }

        renderPagination();
    }

    function renderPagination() {
        $('#pagination-container').empty(); // Limpiar la paginación existente
        var totalPages = Math.ceil(allLocales.length / itemsPerPage);
    
        if (totalPages > 1) { // Solo mostrar paginación si hay más de una página
            if (currentPage > 1) {
                var prevButton = $('<button>').text('Anterior').addClass('pagination-button').on('click', function () {
                    loadPage(currentPage - 1);
                });
                $('#pagination-container').append(prevButton);
            }
    
            for (var i = 1; i <= totalPages; i++) {
                (function (pageNum) {
                    var pageButton = $('<button>').text(pageNum).addClass('pagination-button').on('click', function () {
                        loadPage(pageNum);
                    });
                    if (pageNum === currentPage) {
                        pageButton.addClass('paginacioActive');
                    }
                    $('#pagination-container').append(pageButton);
                })(i);
            }
    
            if (currentPage < totalPages) {
                var nextButton = $('<button>').text('Siguiente').addClass('pagination-button').on('click', function () {
                    loadPage(currentPage + 1);
                });
                $('#pagination-container').append(nextButton);
            }
        }
    }
    
    function guardarFav(localId) {
        $.ajax({
            type: 'POST',
            url: '../controlador/LocalController.php',
            data: { action: 'addFavorite', localId: localId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Local guardado como favorito.');
                } 
                else {
                    alert('Este local ya está guardado como favorito.');
                }
            },
            error: function() {
                console.error('Error al guardar el favorito:');
            }
        });
    }
});
