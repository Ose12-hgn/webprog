/* MARIO RUBY ARIESUSANDI / NIM 0706012410028 / CLASS WEB PROGRAMMING B */
/* FILEMON JOSE HAGEN / NIM 0706012410016 / CLASS WEB PROGRAMMING B */

$(document).ready(function () {
    $('#btn-login').click(function () {
        $('#login-form').show();
        $('#register-form').hide();
        $(this).addClass('text-amber-600').removeClass('text-gray-400');
        $('#btn-register').removeClass('text-amber-600').addClass('text-gray-400');
    });

    $('#btn-register').click(function () {
        $('#register-form').show();
        $('#login-form').hide();
        $(this).addClass('text-amber-600').removeClass('text-gray-400');
        $('#btn-login').removeClass('text-amber-600').addClass('text-gray-400');
    });
});
