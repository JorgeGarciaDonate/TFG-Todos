$(document).ready(function() {
    $('#botonUpdate').click(function() {
        var nombre = $('#nombre').val().trim();
        var nombre_usuario = $('#nombre_usuario').val().trim();
        var telefono = $('#telefono').val().trim();
        var fecha_nacimiento = $('#fecha_nacimiento').val();
        var apellido = $('#apellido').val().trim();
        var dni = $('#dni').val().trim();
        var usuario_id = $('#usuario_id').text().trim(); 

        console.log(nombre);

        $.ajax({
            type: 'POST',
            url: './controlador/UsuarioController.php',
            data: {
                botonUpdate: true,
                nombre_usuario: nombre_usuario,
                nombre: nombre,
                telefono: telefono,
                fecha_nacimiento: fecha_nacimiento,
                apellido: apellido,
                dni: dni,
                usuario_id: usuario_id
            },
            dataType: 'json',
            success: function(response) {
                alert(data);
                if (!response.success) {
                    $('#error-msg').text('Incorrect data.');
                }
                else{
                    window.location.href = "../vista/usuario/vistaPerfil.php";   
                }
            },
            error: function() {
                $('#error-msg').text('An error occurred on the server.');
            }
        });
    });
});
