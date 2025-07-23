jQuery(document).ready(function ($) {
    $('.wpamc-step .wpamc-step-title').on('click', function () {
        $(this).parent().toggleClass('active');
    });
});
