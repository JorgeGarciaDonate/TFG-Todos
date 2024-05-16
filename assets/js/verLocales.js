$(document).ready(function() {
    // Agregar un event listener al botón "Listado" (#list-view)
    $('#list-view').click(function(e) {
        e.preventDefault(); // Evitar la acción predeterminada del botón (navegar a una nueva página)

        // Realizar una solicitud AJAX al servidor para obtener locales
        $.ajax({
            type: 'POST', // Tipo de solicitud HTTP (POST)
            url: '../controlador/LocalController.php', // URL del controlador para obtener locales
            dataType: 'json', // Tipo de datos esperados en la respuesta (JSON)

            success: function(response) {
                // Limpiar el contenedor antes de mostrar nuevos datos
                $('#list-container').empty();

                // Iterar sobre los locales recibidos y mostrar la información
                response.forEach(function(local) {
                    var localItem = $('<div>').addClass('local-item'); // Crear un elemento div con la clase 'local-item'
                    localItem.append($('<h4>').text(local.nombre_local)); // Agregar un encabezado h4 con el nombre del local
                    localItem.append($('<p>').text('Tipo: ' + local.tipo_local)); // Agregar un párrafo p con el tipo de local
                    localItem.append($('<p>').text('Descripción: ' + local.descripcion)); // Agregar un párrafo p con la descripción del local

                    // Agregar el elemento de lista al contenedor '#list-container'
                    $('#list-container').append(localItem);
                });

                // Mostrar el contenedor de listado y ocultar el mapa
                $('#map').hide();
                $('#list-container').show();
            },

            error: function() {
                // Limpiar el contenedor en caso de error
                $('#list-container').empty();
                // Mostrar un mensaje de error en el contenedor de listado
                $('#list-container').text('Error al cargar los locales. Inténtalo de nuevo más tarde.');
                // Ocultar el mapa y mostrar el contenedor de listado
                $('#map').hide();
                $('#list-container').show();
            }
        });
    });
});
