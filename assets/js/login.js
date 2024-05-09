$(document).ready(function() {
    $('#loginForm').submit(function(e) {
        e.preventDefault();

        var nombre_usuario = $('#nombre_usuario').val().trim();
        var password = $('#password').val().trim();

        $('#username').removeClass('error-border');
        $('#password').removeClass('error-border');

        if (nombre_usuario === '') {
            $('#nombre_usuario').addClass('error-border');
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
                botonLog: true, 
                nombre_usuario: nombre_usuario,
                password: password 
            },
            dataType: 'json', 
            success: function(response) {
                //console.log (response);
                if (response.success) {
                    window.location.href = '../index.html';
                } else {
                    $('#error-msg').text('Usuario o contraseña incorrectos.');
                }
            },
            error: function() {
                $('#error-msg').text('Ha ocurrido un error en el servidor.');
            }
        });
    });
});
