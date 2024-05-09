$(document).ready(function() {
    $('#list-view').click(function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: '../controlador/LocalController.php', // Enviar acción para obtener todos los locales
            dataType: 'json', 
            
            success: function(response) {
                // Limpiar el contenedor antes de mostrar nuevos datos
                $('#list-container').empty();

                // Iterar sobre los locales recibidos y mostrar la información
                response.forEach(function(local) {
                    // Crear un elemento de lista para mostrar la información del local
                    var localItem = $('<div>').addClass('local-item');
                    localItem.append($('<h4>').text(local.nombre_local));
                    localItem.append($('<p>').text('Tipo: ' + local.tipo_local));
                    localItem.append($('<p>').text('Descripción: ' + local.descripcion));

                    // Agregar el elemento de lista al contenedor
                    $('#list-container').append(localItem);
                });

                // Mostrar el contenedor de listado
                $('#map').hide();
                $('#list-container').show();
            },
            error: function() {
      /*           console.log(data); */
                // Manejar errores en la solicitud AJAX
                console.error('Error al obtener locales.');
                $('#list-container').empty(); // Limpiar el contenedor en caso de error
                $('#list-container').text('Error al cargar los locales. Inténtalo de nuevo más tarde.');
                $('#map').hide();
                $('#list-container').show();
            }
        });
    });
});
