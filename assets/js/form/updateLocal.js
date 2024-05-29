$(document).ready(function() {
    $('#botonUpdateDatos').click(function() {
        var nombre = $('#nombre').val().trim();
        var tipo_local = $('#tipo_local').val().trim();
        var genero_musical = $('input[name="genero_musical[]"]:checked').map(function() {
            return this.value;
        }).get().join(',');
        var precio_rango = $('#precio_rango').val().trim();
        var edad_recomendada = $('#edad_recomendada').val().trim();
        var descripcion = $('#descripcion').val().trim();
        var local_id = $('#local_id').text().trim(); 

        $.ajax({
            type: 'POST',
            url: './controlador/LocalController.php',
            data: {
                botonUpdateDatos: true,
                nombre: nombre,
                tipo_local: tipo_local,
                genero_musical: genero_musical,
                precio_rango: precio_rango,
                edad_recomendada: edad_recomendada,
                descripcion: descripcion,
                local_id: local_id
            },
            dataType: 'json',
            success: function(response) {
                if (!response.success) {
                    $('#error-msg').text('Incorrect data.');
                } else {
                    window.location.href = "./vista/usuario/vistaLocal.php?local_id=" + local_id;
                }
            },
            error: function() {
                $('#error-msg').text('An error occurred on the server.');
            }
        });
    });

    $('#botonUpdateHorario').click(function() {
        var dias_abierto = $('input[name="dias_abierto[]"]:checked').map(function() {
            return this.value;
        }).get().join(',');
        var hora_apertura = $('#hora_apertura').val().trim();
        var hora_cierre = $('#hora_cierre').val().trim();
        var local_id = $('#local_id').text().trim(); 

        $.ajax({
            type: 'POST',
            url: './controlador/LocalController.php',
            data: {
                botonUpdateHorario: true,
                dias_abierto: dias_abierto,
                hora_apertura: hora_apertura,
                hora_cierre: hora_cierre,
                local_id: local_id
            },
            dataType: 'json',
            success: function(response) {
                if (!response.success) {
                    $('#error-msg').text('Incorrect data.');
                } else {
                    window.location.href = "./vista/usuario/vistaLocal.php?local_id=" + local_id;
                }
            },
            error: function() {
                $('#error-msg').text('An error occurred on the server.');
            }
        });
    });

    $('#botonUpdateUbicacion').click(function() {
        var calle = $('#calle').val().trim();
        var num_calle = $('#num_calle').val().trim();
        var zona = $('#zona').val().trim();
        var ciudad = $('#ciudad').val().trim();
        var cod_postal = $('#cod_postal').val().trim();
        var ubicacion_id = $('#ubicacion_id').text().trim();
        var longitud = $('#longitud').text().trim();
        var latitud = $('#latitud').text().trim();
        var local_id = $('#local_id').text().trim(); 

        $.ajax({
            type: 'POST',
            url: './controlador/UbicacionController.php',
            data: {
                botonUpdateUbicacion: true,
                calle: calle,
                num_calle: num_calle,
                zona: zona,
                ciudad: ciudad,
                cod_postal: cod_postal,
                ubicacion_id: ubicacion_id,
                longitud: longitud,
                latitud: latitud,
                local_id: local_id
            },
            dataType: 'json',
            success: function(response) {
                if (!response.success) {
                    $('#error-msg').text('Incorrect data.');
                } else {
                    window.location.href = "./vista/usuario/vistaLocal.php?local_id=" + local_id;
                }
            },
            error: function() {
                $('#error-msg').text('An error occurred on the server.');
            }
        });
    });
});