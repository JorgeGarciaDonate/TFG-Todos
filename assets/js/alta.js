
$(document).ready(function() {
    $('#altaForm').submit(function(e) {
        e.preventDefault();

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

        console.log(diasApertura);
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
});
