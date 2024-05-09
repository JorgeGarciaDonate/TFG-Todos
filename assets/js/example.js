document.addEventListener("DOMContentLoaded", function(event) {
    const showNavbar = (toggleId, navId, bodyId, headerId) => {
        const toggle = document.getElementById(toggleId),
            nav = document.getElementById(navId),
            bodypd = document.getElementById(bodyId),
            headerpd = document.getElementById(headerId);

        // Validar que todas las variables existan
        if (toggle && nav && bodypd && headerpd) {
            toggle.addEventListener('click', () => {
                // Mostrar el navbar
                nav.classList.toggle('show');
                // Cambiar el ícono
                toggle.classList.toggle('bx-x');
                // Agregar relleno al cuerpo
                bodypd.classList.toggle('body-pd');
                // Agregar relleno al encabezado
                headerpd.classList.toggle('body-pd');
            });
        }
    }

    showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header');

    /*===== ENLACE ACTIVO =====*/
    const linkColor = document.querySelectorAll('.nav_link');

    function colorLink() {
        if (linkColor) {
            linkColor.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        }
    }

    linkColor.forEach(l => l.addEventListener('click', colorLink));
});

$(document).ready(function() {
    
    var dropdowns = document.querySelectorAll('.dropdown-toggle');
    dropdowns.forEach(function(dropdown) {
        dropdown.addEventListener('click', function() {
            var menu = dropdown.nextElementSibling;
            menu.classList.toggle('show');
        });
    });

    $(document).on('click', function(e) {
        if (!$(e.target).hasClass('dropdown-toggle')) {
            $('.dropdown-menu').removeClass('show');
        }
    });
    
});