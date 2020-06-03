'use strict';

$(document).ready(function()
{
    $('#screenshots').owlCarousel({
        autoplay: true,
        autoplayTimeout: 2000,
        stagePadding: 100,
        loop: false,
        margin: 10,
        rewind: true,
        autoplayHoverPause: true,
        responsive:{
            0:{
                items: 1,
                stagePadding: 50,
            },
            600:{
                items: 2,
                stagePadding: 50,
            },
            1000:{
                items: 3
            }
        }
    });

    $('[name="type"]').on('change', function()
    {
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

        $('[name="rooms"]').val('');
    });

    $('[data-modal="contact"]').modal().onCancel(function()
    {
        $('[data-modal="contact"]').find('[name="type"]').parent().parent().parent().removeClass('span8').addClass('span12');
        $('[data-modal="contact"]').find('[name="rooms"]').parent().parent().parent().addClass('hidden');

        clean_form($('[data-modal="contact"]').find('form'));
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
