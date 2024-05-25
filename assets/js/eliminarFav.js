document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.remove-favorite').forEach(button => {
        button.addEventListener('click', function() {
            var localId = this.getAttribute('data-local-id');
            removeFavorite(localId);
        });
    });
});

function removeFavorite(localId) {
    $.ajax({
        type: 'POST',
        url: '../../controlador/LocalController.php',
        data: { action: 'removeFavorite', localId: localId },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                location.reload();
            } else {
                alert('Error al eliminar el favorito.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al eliminar el favorito:', error);
        }
    });
}
