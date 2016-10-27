$(document).ready(function() {

    $('html').on('click', '.content-block a.title', function() {

        $(this).parent().find('.content-desc').slideToggle('fast');

    });

});