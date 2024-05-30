$(document).ready(function() {
    $('#altaForm').submit(function(e) {
        e.preventDefault();
        var nombre = $('#nombre').val().trim();
        var tipoLocal = $('#tipo_local').val();
        var generos = getSelectedGenres();
        var precioRango = $('#precio_rango').val();
        var musica_en_vivo = $('#musica_en_vivo').val();
        var horaApertura = $('#hora_apertura').val();
        var horaCierre = $('#hora_cierre').val();
        var diasApertura = getSelectedDays();
        var descripcion = $('#descripcion').val().trim();
        var calle = $('#calle').val().trim();
        var numero = $('#num_calle').val();
        var codigoPostal = $('#cod_postal').val().trim();
        var edad_recomendada = $('#edad_recomendada').val();
        var ciudad = $('#ciudad').val().trim();
        var barrio = $('#barrio').val().trim();
        var usuario_id = $('#usuario_id').val().trim();
        var dni = $('#dni').val().trim();
        var telefono = $('#telefono').val().trim();
        var web = $('#web').val().trim();
        var foto = $('#foto')[0].files[0];





        $('#nombre').removeClass('error-border');
        $('#calle').removeClass('error-border');
        $('#num_calle').removeClass('error-border');
        $('#cod_postal').removeClass('error-border');
        $('#ciudad').removeClass('error-border');
        $('#barrio').removeClass('error-border');

        if (nombre === '') {
            $('#nombre').addClass('error-border');
            return false;
        }
        if (calle === '') {
            $('#calle').addClass('error-border');
            return false;
        }
        if (numero === '') {
            $('#num_calle').addClass('error-border');
            return false;
        }
        if (codigoPostal === '') {
            $('#cod_postal').addClass('error-border');
            return false;
        }
        if (ciudad === '') {
            $('#ciudad').addClass('error-border');
            return false;
        }
        if (barrio === '') {
            $('#barrio').addClass('error-border');
            return false;
        }

        var direccionCompleta = calle + ' ' + numero + ', ' + ciudad + ', ' + codigoPostal;

        // Verificar si Leaflet y su módulo de geocodificación están cargados
        if (typeof L !== 'undefined' && typeof L.Control !== 'undefined' && typeof L.Control.Geocoder !== 'undefined' && typeof L.Control.Geocoder.nominatim === 'function') {
            // Obtener las coordenadas utilizando Leaflet's geocoding service
            L.Control.Geocoder.nominatim().geocode(direccionCompleta, function(results) {
                if (results.length > 0) {
                    var latlng = results[0].center;
                    var lat = latlng.lat;
                    var lon = latlng.lng;

                    // Proceed with AJAX request after getting the location
                    $.ajax({
                        type: 'POST',
                        url: '../controlador/RegistroController.php',
                        data: {
                            botonAlta: true,
                            nombre: nombre,
                            tipo_local: tipoLocal,
                            generos: generos,
                            precio_rango: precioRango,
                            hora_apertura: horaApertura,
                            hora_cierre: horaCierre,
                            dias_apertura: diasApertura,
                            musica_en_vivo: musica_en_vivo,
                            edad_recomendada:edad_recomendada,
                            descripcion: descripcion,
                            calle: calle,
                            num_calle: numero,
                            cod_postal: codigoPostal,
                            ciudad: ciudad,
                            barrio: barrio,
                            latitud: lat,
                            longitud: lon,
                            usuario_id :usuario_id,
                            telefono: telefono,
                            dni: dni,
                            web: web,
                            foto: foto
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            if (response.success) {
                                window.location.href = '../index.php';
                            } else {
                                $('#error-msg').text(response.message);
                            }
                        },
                        error: function() {
                            $('#error-msg').text('Hubo un error en el servidor.');
                        }
                    });
                } else {
                    $('#error-msg').text('No se encontraron resultados para la dirección proporcionada.');
                }
            });
        } else {
            // Leaflet o su módulo de geocodificación no están disponibles
            $('#error-msg').text('Error: Leaflet o su módulo de geocodificación no están disponibles.');
        }
    });

    // Función para obtener los géneros musicales seleccionados
    function getSelectedGenres() {
        var selectedGenres = [];
        $('#reggaeton:checked, #techno:checked, #electronica:checked, #rock:checked, #pop:checked, #jazz:checked').each(function() {
            selectedGenres.push($(this).val());
        });
        return selectedGenres;
    } 
    

    // Función para obtener los días de apertura seleccionados
    function getSelectedDays() {
        var selectedDays = [];
        $('input[type="checkbox"][id^="lunes"], input[type="checkbox"][id^="martes"], input[type="checkbox"][id^="miercoles"], input[type="checkbox"][id^="jueves"], input[type="checkbox"][id^="viernes"], input[type="checkbox"][id^="sabado"], input[type="checkbox"][id^="domingo"]').each(function() {
            if ($(this).is(":checked")) {
                selectedDays.push($(this).val());
            }
        });
        return selectedDays;
    }
    

});
