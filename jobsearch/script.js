/* MARIO RUBY ARIESUSANDI / NIM 0706012410028 / CLASS WEB PROGRAMMING B */
/* FILEMON JOSE HAGEN / NIM 0706012410016 / CLASS WEB PROGRAMMING B */

$(document).ready(function () {
    const menuToggle = $('#menu-toggle');
    const dropdown = $('#mobile-dropdown');
    const iconOpen = $('#menu-toggle-icon');
    const iconClose = $('#menu-close-icon');
    let isOpen = false;

    menuToggle.on('click', function () {
        if (!isOpen) {
            // Show dropdown dengan animasi slide-in
            dropdown.removeClass('hidden slide-down-active').addClass('slide-down');

            // Force reflow agar animasi bisa jalan
            void dropdown[0].offsetWidth;

            dropdown.addClass('slide-down-active');

            iconOpen.addClass('hidden');
            iconClose.removeClass('hidden');
        } else {
            // Hide dropdown dengan animasi slide-out
            dropdown.removeClass('slide-down-active').addClass('slide-down');

            iconOpen.removeClass('hidden');
            iconClose.addClass('hidden');

            setTimeout(() => {
                dropdown.addClass('hidden');
            }, 300);
        }
        isOpen = !isOpen;
    });

    // Klik di luar dropdown nutup menu
    $(document).on('click', function (e) {
        if (
            isOpen &&
            !$(e.target).closest('#menu-toggle, #mobile-dropdown').length
        ) {
            dropdown.removeClass('slide-down-active').addClass('slide-down');

            iconOpen.removeClass('hidden');
            iconClose.addClass('hidden');

            setTimeout(() => {
                dropdown.addClass('hidden');
                isOpen = false;
            }, 300);
        }
    });

    // Logout Button Clicked (desktop)
    $('#logout-button').click(function (e) {
        e.preventDefault();
        $('#logout-box').removeClass('hidden');
    });

    // Logout Button Clicked (mobile)
    $('#logout-button-mobile').click(function (e) {
        e.preventDefault();
        $('#logout-box').removeClass('hidden');
    });

    // Cancel Logout Clicked
    $('#cancel-logout').click(function () {
        $('#logout-box').addClass('hidden');
    });

    // Cancel Logout Outside Clicked
    $('#logout-box').click(function (e) {
        if (e.target.id === 'logout-box') {
            $(this).addClass('hidden');
        }
    });
});
