
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
        var dniVisible = $('#dni').is(':visible');
        var telefonoVisible = $('#telefono').is(':visible');
        
        // Variables para los valores de los campos
        var dni = dniVisible ? $('#dni').val().trim() : null;
        var telefono = telefonoVisible ? $('#telefono').val().trim() : null;
        var web = $('#web').val().trim();
        var foto = $('#foto')[0].files[0];

        $('#nombre').removeClass('error-border');
        $('#calle').removeClass('error-border');
        $('#num_calle').removeClass('error-border');
        $('#cod_postal').removeClass('error-border');
        $('#ciudad').removeClass('error-border');
        $('#barrio').removeClass('error-border');

        if (nombre === '' || calle === '' || numero === '' || codigoPostal === '' || ciudad === '' || barrio === '') {
            if (nombre === '') $('#nombre').addClass('error-border');
            if (calle === '') $('#calle').addClass('error-border');
            if (numero === '') $('#num_calle').addClass('error-border');
            if (codigoPostal === '') $('#cod_postal').addClass('error-border');
            if (ciudad === '') $('#ciudad').addClass('error-border');
            if (barrio === '') $('#barrio').addClass('error-border');
            return false;
        }

        var direccionCompleta = calle + ' ' + numero + ', ' + ciudad + ', ' + codigoPostal;

        if (typeof L !== 'undefined' && typeof L.Control !== 'undefined' && typeof L.Control.Geocoder !== 'undefined' && typeof L.Control.Geocoder.nominatim === 'function') {
            L.Control.Geocoder.nominatim().geocode(direccionCompleta, function(results) {
                if (results.length > 0) {
                    var latlng = results[0].center;
                    var lat = latlng.lat;
                    var lon = latlng.lng;

                    var formData = new FormData();
                    formData.append('botonAlta', true);
                    formData.append('nombre', nombre);
                    formData.append('tipo_local', tipoLocal);
                    formData.append('generos', JSON.stringify(generos)); // JSON string
                    formData.append('precio_rango', precioRango);
                    formData.append('hora_apertura', horaApertura);
                    formData.append('hora_cierre', horaCierre);
                    formData.append('dias_apertura', JSON.stringify(diasApertura)); // JSON string
                    formData.append('musica_en_vivo', musica_en_vivo);
                    formData.append('edad_recomendada', edad_recomendada);
                    formData.append('descripcion', descripcion);
                    formData.append('calle', calle);
                    formData.append('num_calle', numero);
                    formData.append('cod_postal', codigoPostal);
                    formData.append('ciudad', ciudad);
                    formData.append('barrio', barrio);
                    formData.append('latitud', lat);
                    formData.append('longitud', lon);
                    formData.append('usuario_id', usuario_id);
                    formData.append('telefono', telefono);
                    formData.append('dni', dni);
                    formData.append('web', web);
                    formData.append('foto', foto);

                    $.ajax({
                        type: 'POST',
                        url: '../controlador/RegistroController.php',
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            if (response.success) {
                                window.location.href = '../index.php';
                            } else {
                                $('#error-message').html(response.message).show();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error en la solicitud AJAX:', status, error);
                            $('#error-message').html('Error en la solicitud AJAX: ' + status + ' ' + error).show();
                        }
                    });
                } else {
                    console.error('No se encontraron coordenadas para la dirección.');
                }
            });
        } else {
            console.error('L.Control.Geocoder o L.Control.Geocoder.nominatim no está disponible.');
        }
    });

    function getSelectedGenres() {
        var selectedGenres = [];
        $('input[name="genero_musical[]"]:checked').each(function() {
            selectedGenres.push($(this).val());
        });
        return selectedGenres;
    }

    function getSelectedDays() {
        var selectedDays = [];
        $('input[name="dias_abierto[]"]:checked').each(function() {
            selectedDays.push($(this).val());
        });
        return selectedDays;
    }
});
/* $(document).ready(function() {
    $('#altaForm').submit(function(e) {
        e.preventDefault();

        // Obtener valores de los campos
        var nombre = $('#nombre').val().trim();
        var tipoLocal = $('#tipo_local').val();
        var generos = $('input[name="genero_musical[]"]:checked').map(function() {
            return this.value;
        }).get();
        var precioRango = $('#precio_rango').val();
        var musica_en_vivo = $('#musica_en_vivo').val();
        var horaApertura = $('#hora_apertura').val();
        var horaCierre = $('#hora_cierre').val();
        var diasApertura = $('input[name="dias_abierto[]"]:checked').map(function() {
            return this.value;
        }).get();
        var descripcion = $('#descripcion').val().trim();
        var calle = $('#calle').val().trim();
        var numero = $('#num_calle').val();
        var codigoPostal = $('#cod_postal').val().trim();
        var ciudad = $('#ciudad').val().trim();
        var barrio = $('#barrio').val().trim();
        var usuario_id = $('#usuario_id').val().trim();
        var dni = $('#dni').val();
        var telefono = $('#telefono').val();
        var web = $('#web').val().trim();
        var foto = $('#foto')[0].files[0];

        // Remover clases de error y mensajes de error
        $('.form-control').removeClass('error-border');
        $('.error-msg').text('');

        // Validaciones
        var valid = true;
        if (nombre === '') {
            $('#error-nombre').text('Introduce un nombre de local.');
            $('#nombre').addClass('error-border');
            valid = false;
        }
        if (tipoLocal === '') {
            $('#error-local').text('Seleccione un tipo de local.');
            $('#tipo_local').addClass('error-border');
            valid = false;
        }
        if (generos.length === 0) {
            $('#error-genero').text('Seleccione al menos un género musical.');
            $('.checkbox-group').addClass('error-border');
            valid = false;
        }
        if (precioRango === '') {
            $('#error-precio').text('Seleccione un rango de precio.');
            $('#precio_rango').addClass('error-border');
            valid = false;
        }
        if (horaApertura === '' || horaCierre === '') {
            $('#error-horaap').text('Seleccione una hora válida.');
            $('#error-horaci').text('Seleccione una hora válida.');
            $('#hora_apertura, #hora_cierre').addClass('error-border');
            valid = false;
        }
        if (diasApertura.length === 0) {
            $('#error-dias').text('Seleccione al menos un día de apertura.');
            $('.checkbox-group').addClass('error-border');
            valid = false;
        }
        if (descripcion.length < 10) {
            $('#error-desc').text('La descripción debe tener al menos 10 caracteres.');
            $('#descripcion').addClass('error-border');
            valid = false;
        }
        if (calle === '') {
            $('#error-calle').text('Introduce una calle.');
            $('#calle').addClass('error-border');
            valid = false;
        }
        if (numero === '') {
            $('#error-num').text('Introduce un número.');
            $('#num_calle').addClass('error-border');
            valid = false;
        }
        if (codigoPostal === '' || !/^\d+$/.test(codigoPostal)) {
            $('#error-cod').text('Introduce un código postal válido.');
            $('#cod_postal').addClass('error-border');
            valid = false;
        }
        if (ciudad === '') {
            $('#error-ciudad').text('Introduce una ciudad.');
            $('#ciudad').addClass('error-border');
            valid = false;
        }
        if (barrio === '') {
            $('#error-barrio').text('Introduce un barrio.');
            $('#barrio').addClass('error-border');
            valid = false;
        }
        if (telefono === '' || !/^\d+$/.test(telefono)) {
            $('#error-tel').text('Introduce un número de teléfono válido.');
            $('#telefono').addClass('error-border');
            valid = false;
        }
        if (web !== '' && !/^https?:\/\/[^\s]+$/.test(web)) {
            $('#error-web').text('Introduce una dirección web válida.');
            $('#web').addClass('error-border');
            valid = false;
        }

        if (!valid) {
            return false;
        }

        // Dirección completa para geocodificación
        var direccionCompleta = calle + ' ' + numero + ', ' + ciudad + ', ' + codigoPostal;

        if (typeof L !== 'undefined' && typeof L.Control !== 'undefined' && typeof L.Control.Geocoder !== 'undefined' && typeof L.Control.Geocoder.nominatim === 'function') {
            L.Control.Geocoder.nominatim().geocode(direccionCompleta, function(results) {
                if (results.length > 0) {
                    var latlng = results[0].center;
                    var latitud = latlng.lat;
                    var longitud = latlng.lng;

                    

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
                            descripcion: descripcion,
                            calle: calle,
                            num_calle: numero,
                            cod_postal: codigoPostal,
                            ciudad: ciudad,
                            barrio: barrio,
                            latitud: latitud,
                            longitud: longitud,
                            usuario_id: usuario_id,
                            // Verificar si el teléfono tiene un valor antes de agregarlo
                            telefono: telefono !== '' ? telefono : undefined,
                            // Verificar si el DNI tiene un valor antes de agregarlo
                            dni: dni !== '' ? dni : undefined,
                            web: web,
                            foto: foto
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            if (response.success) {
                                window.location.href = './index.php';
                            } else {
                                $('#error-message').html(response.message).show();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error en la solicitud AJAX:', status, error);
                            $('#error-message').html('Error en la solicitud AJAX: ' + status + ' ' + error).show();
                        }
                    });
                } else {
                    console.error('No se encontraron coordenadas para la dirección.');
                }
            });
        } else {
            console.error('L.Control.Geocoder o L.Control.Geocoder.nominatim no está disponible.');
        }
    });

});

 */