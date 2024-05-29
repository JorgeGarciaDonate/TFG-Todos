document.addEventListener('DOMContentLoaded', function() {
    loadFavoritos();

    document.querySelectorAll('.remove-favorite').forEach(button => {
        button.addEventListener('click', function() {
            var localId = this.getAttribute('data-local-id');
            removeFavorite(localId);
        });
    });
});

function loadFavoritos() {
    $.ajax({
        type: 'POST',
        url: '../../controlador/LocalController.php',
        data: { action: 'getFavoritos' },
        dataType: 'json',
        success: function(response) {
            $('#list-favoritos').empty();
            if (response.length === 0) {
                $('#list-favoritos').text('No tienes locales favoritos guardados.');
            } else {
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

                    var removeButton = $('<button class="favs-button">').addClass('remove-favorite').attr('data-local-id', local.local_id).text('Eliminar');
                    removeButton.on('click', function() {
                        removeFavorite(local.local_id);
                    });
                    localItem.append(removeButton);

                    $('#list-favoritos').append(localItem);
                });
            }
        },
        error: function() {
            $('#list-favoritos').text('Error al cargar los locales. Inténtalo de nuevo más tarde.');
        }
    });
}

function removeFavorite(localId) {
    $.ajax({
        type: 'POST',
        url: '../../controlador/LocalController.php',
        data: { action: 'removeFavorite', localId: localId },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                loadFavoritos();  // Reload favoritos list
            } else {
                alert('Error al eliminar el favorito.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al eliminar el favorito:', error);
        }
    });
}
