'use strict';

$(document).ready(function()
{
    $('[name="type"]').on('change', function()
    {
        $('[name="rooms"]').val('');

        if ($(this).val() == 'hotel')
        {
            $(this).parent().parent().parent().removeClass('span12').addClass('span8');
            $('[name="rooms"]').parent().parent().parent().removeClass('hidden');
        }
        else
        {
            $(this).parent().parent().parent().removeClass('span8').addClass('span12');
            $('[name="rooms"]').parent().parent().parent().addClass('hidden');
        }
    });

    $('[data-modal="contact"]').modal().onCancel(function()
    {
        $('[name="type"]').parent().parent().parent().removeClass('span8').addClass('span12');
        $('[name="rooms"]').parent().parent().parent().addClass('hidden');

        clean_form($('form[name="contact"]'));
    });

    $('form[name="contact"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize(),
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 8000);
                else if (response.status == 'error')
                    how_form_errors(form, response);
            }
        });
    });
});
