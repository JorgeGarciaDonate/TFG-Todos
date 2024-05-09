$(document).ready(function() {
    $('#botonUpdate').click(function() {
        var name = $('#name').val().trim();
        var username = $('#username').val().trim();
        var phone_number = $('#phone_number').val().trim();
        var date_birth = $('#date_birth').val();
        var address = $('#address').val().trim();
        var id = $('#id').text().trim(); 

        console.log(name);

        $.ajax({
            type: 'POST',
            url: './controller/ControllerUser.php',
            data: {
                botonUpdate: true,
                username: username,
                name: name,
                phone_number: phone_number,
                date_birth: date_birth,
                address: address,
                id: id
            },
            dataType: 'json',
            success: function(response) {
                console.log(data);
                console.log(response);
                alert(data);
                if (!response.success) {
                    $('#error-msg').text('Incorrect data.');
                }
                else{
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', window.location.href, true);

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            window.location.reload(true);
                        }
                    }; 
                    xhr.send();   
                }
            },
            error: function() {
                $('#error-msg').text('An error occurred on the server.');
            }
        });
    });
});
