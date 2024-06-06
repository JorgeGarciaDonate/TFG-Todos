
$(document).ready(function() {
    $('#fecha_de_nacimiento').datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        yearRange: '-100:+0', // allows selection of dates from 100 years ago to the present
        maxDate: '-18Y', // restricts the maximum date to 18 years ago from today
        onClose: function(dateText, inst) {
            // Additional validation if needed
        }
    });

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

        $('#error-nombre').text('');
        $('#error-apellido').text('');
        $('#error-email').text('');
        $('#error-password').text('');
        $('#error-fecha_de_nacimiento').text('');        
        $('.error-msg').text(''); 

        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;

        var today = new Date();
        var birthDate = new Date(partes_fecha[2], partes_fecha[1] - 1, partes_fecha[0]);
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        var errorMsg = false;
        if (nombre === '') {
            $('#nombre').addClass('error-border');
            $('#error-nombre').text('El nombre es obligatorio.');
            errorMsg = true;
        }
        if (apellido === '') {
            $('#apellido').addClass('error-border');
            $('#error-apellido').text('El apellido es obligatorio.');
            errorMsg = true;
        }
        if (email === '' || !emailPattern.test(email)) {
            $('#email').addClass('error-border');
            $('#error-email').text('El email es obligatorio o no es válido.');
            errorMsg = true;
        }
        if (password === '' || !passwordPattern.test(password)) {
            $('#password').addClass('error-border');
            $('#error-password').text('Contraseña es obligatorio y debe contener al menos una letra mayúscula, una minúscula y un número.');
            errorMsg = true;
        }
        if (fecha_de_nacimiento === '' || age < 18) {
            $('#fecha_de_nacimiento').addClass('error-border');
            $('#error-fecha_de_nacimiento').text('Debes ser mayor de edad (al menos 18 años).');
            errorMsg = true;
        }

        if (errorMsg) {
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
                nombre_usuario: nombre_usuario
            },
            dataType: 'json', 
            success: function(response) {
                if (response.success) {
                    window.location.href = './registro/login.php'; 
                } else {
                    $('#error-msg').text(response.message);
                }
            }
        });
    });
});
