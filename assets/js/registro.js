$(document).ready(function() {
    $('#registerForm').submit(function(e) {
        e.preventDefault();
        var nombre = $('#nombre').val().trim();
        var apellido = $('#apellido').val().trim();
        var email = $('#email').val().trim();
        var fecha_de_nacimiento = $('#fecha_de_nacimiento').val().trim();
        var password = $('#password').val().trim();
        var nombre_usuario = $('#nombre_usuario').val().trim();

        var partes_fecha = fecha_de_nacimiento.split('/');
        var fecha_nueva = partes_fecha[1] + '/' + partes_fecha[0] + '/' + partes_fecha[2];

        $('#apellido').removeClass('error-border');
        $('#email').removeClass('error-border');
        $('#password').removeClass('error-border');
        $('#nombre_usuario').removeClass('error-border');

        if (apellido === '') {
            $('#apellido').addClass('error-border');
            return false;
        }
        if (email === '') {
            $('#email').addClass('error-border');
            return false;
        }
        if (password === '') {
            $('#password').addClass('error-border');
            return false;
        }
        

        $.ajax({
            type: 'POST',
            url: '../controlador/RegistroController.php', 
            data: {
                botonCreate: true,
                nombre: nombre,
                apellido: apellido,
                email: email,
                fecha_de_nacimiento: fecha_nueva, 
                password: password,
                nombre_usuario: nombre_usuario,
                role: 'user'
            },
            dataType: 'json', 
            success: function(response) {
                if (response.success) {
                    window.location.href = './registro/login.php'; 
                } else {
                    $('#error-msg').text(response.message);
                }
            },
            error: function() {
                $('#error-msg').text('There was an error in the server.');
            }
        });
    });    
});
