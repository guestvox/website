'use strict';

$(document).ready(function()
{
    $('[name="type"]').on('change', function()
    {
        if ($(this).val() == 'hotel')
        {
            $(this).parent().parent().parent().removeClass('span12');
            $(this).parent().parent().parent().addClass('span8');
            $('[name="rooms"]').parent().parent().parent().removeClass('hidden');
        }
        else
        {
            $(this).parent().parent().parent().removeClass('span8');
            $(this).parent().parent().parent().addClass('span12');
            $('[name="rooms"]').parent().parent().parent().addClass('hidden');
        }

        $('[name="rooms"]').val('');
    });

    $('[data-modal="contact"]').modal().onCancel(function()
    {
        $('[data-modal="contact"]').find('[name="type"]').parent().parent().parent().removeClass('span8');
        $('[data-modal="contact"]').find('[name="type"]').parent().parent().parent().addClass('span12');
        $('[data-modal="contact"]').find('[name="rooms"]').parent().parent().parent().addClass('hidden');
        $('[data-modal="contact"]').find('form')[0].reset();
        $('[data-modal="contact"]').find('label.error').removeClass('error');
        $('[data-modal="contact"]').find('p.error').remove();
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
