'use strict';

$(document).ready(function()
{
    $('[data-action="copy_to_clipboard"]').on('click', function()
    {
        var string = $(this).parent().find('p').html();
        var input = $('<input>').val(string).appendTo('body').select();

        document.execCommand('copy');

        input.remove();

        show_modal_success('Copiado', 600, 'fast');
    });
});
