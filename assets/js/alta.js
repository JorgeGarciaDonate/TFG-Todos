$(document).ready(function() {
    $('#altaForm').submit(function(e) {
        e.preventDefault();
        var nombre = $('#nombre').val().trim();
        var tipoLocal = $('#tipo_local').val();
        var generos = getSelectedGenres();
        var precioRango = $('#precio_rango').val();
        var horaApertura = $('#hora_apertura').val();
        var horaCierre = $('#hora_cierre').val();
        var diasApertura = getSelectedDays();
        var calle = $('#calle').val().trim();
        var numero = $('#num_calle').val().trim();
        var codigoPostal = $('#cod_postal').val().trim();
        var ciudad = $('#ciudad').val().trim();
        var barrio = $('#barrio').val().trim();

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

        $.ajax({
            type: 'POST',
            url: '../controlador/RegistroController.php',
            data: {
                nombre: nombre,
                tipo_local: tipoLocal,
                generos: generos,
                precio_rango: precioRango,
                hora_apertura: horaApertura,
                hora_cierre: horaCierre,
                dias_apertura: diasApertura,
                calle: calle,
                num_calle: numero,
                cod_postal: codigoPostal,
                ciudad: ciudad,
                barrio: barrio
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    window.location.href = './index.php';
                } else {
                    $('#error-msg').text(response.message);
                }
            },
            error: function() {
                $('#error-msg').text('Hubo un error en el servidor.');
            }
        });
    });

    // Función para obtener los géneros musicales seleccionados
    function getSelectedGenres() {
        var selectedGenres = [];
        $('input[type="checkbox"]:checked').each(function() {
            selectedGenres.push($(this).val());
        });
        return selectedGenres;
    }

    // Función para obtener los días de apertura seleccionados
    function getSelectedDays() {
        var selectedDays = [];
        $('input[type="checkbox"]:checked').each(function() {
            selectedDays.push($(this).val());
        });
        return selectedDays;
    }
});