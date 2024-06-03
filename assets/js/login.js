$(document).ready(function() {
    $('#loginForm').submit(function(e) {
        e.preventDefault();

        var nombre_usuario = $('#nombre_usuario').val().trim();
        var password = $('#password').val().trim();

        $('#nombre_usuario').removeClass('error-border');
        $('#password').removeClass('error-border');

        if (nombre_usuario === '') {
            $('#nombre_usuario').addClass('error-border');
            $('#error-username').text('El nombre deusuario es obligatorio.');
            errorMsg = true;
        }
        if (password === '') {
            $('#password').addClass('error-border');
            $('#error-password').text('La contraseña es obligatorio.');
            errorMsg = true;
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
                if (response.success) {
                    window.location.href = '../vista/index.php';
                } else {
                    $('#error-msg').text(response.message);
                }
            }
        });
    });
});
