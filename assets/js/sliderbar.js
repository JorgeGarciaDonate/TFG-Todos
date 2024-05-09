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
$(document).ready(function() {
    $('.nk-nav-toggle').on('click', function(e) {
        e.preventDefault();
        var target = $(this).data('target');
        $(target).toggleClass('show');
    });

    
    $('.nk-menu-item').on('click', function(e) {
        e.preventDefault();
        $(this).toggleClass('show');
    });
});