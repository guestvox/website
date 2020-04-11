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
        $('[name="rooms"]').val('');
        $('[name="tables"]').val('');

        if ($(this).val() == 'hotel' || $(this).val() == 'restaurant')
        {
            $(this).parent().parent().parent().removeClass('span12');
            $(this).parent().parent().parent().addClass('span8');

            if ($(this).val() == 'hotel')
            {
                $('[name="rooms"]').parent().parent().parent().removeClass('hidden');
                $('[name="tables"]').parent().parent().parent().addClass('hidden');
            }
            else if ($(this).val() == 'restaurant')
            {
                $('[name="rooms"]').parent().parent().parent().addClass('hidden');
                $('[name="tables"]').parent().parent().parent().removeClass('hidden');
            }
        }
        else
        {
            $(this).parent().parent().parent().removeClass('span8');
            $(this).parent().parent().parent().addClass('span12');
            $('[name="rooms"]').parent().parent().parent().addClass('hidden');
            $('[name="tables"]').parent().parent().parent().addClass('hidden');
        }
    });

    $('[data-modal="contact"]').modal().onCancel(function()
    {
        $('[name="type"]').parent().parent().parent().removeClass('span8');
        $('[name="type"]').parent().parent().parent().addClass('span12');
        $('[name="rooms"]').parent().parent().parent().addClass('hidden');
        $('[name="tables"]').parent().parent().parent().addClass('hidden');
        $('[data-modal="contact"]').find('form')[0].reset();
        $('[data-modal="contact"]').find('label.error').removeClass('error');
        $('[data-modal="contact"]').find('p.error').remove();
    });

    $('[data-modal="contact"]').modal().onSuccess(function()
    {
        $('[data-modal="contact"]').find('form').submit();
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
                {
                    $('[data-modal="success"]').addClass('view');
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    setTimeout(function() { location.reload(); }, 1500);
                }
                else if (response.status == 'error')
                {
                    if (response.labels)
                    {
                        form.find('label.error').removeClass('error');
                        form.find('p.error').remove();

                        $.each(response.labels, function(i, label)
                        {
                            if (label[1].length > 0)
                                form.find('[name="' + label[0] + '"]').parents('label').addClass('error').append('<p class="error">' + label[1] + '</p>');
                            else
                                form.find('[name="' + label[0] + '"]').parents('label').addClass('error');
                        });

                        form.find('label.error [name]')[0].focus();
                    }
                    else if (response.message)
                    {
                        $('[data-modal="error"]').addClass('view');
                        $('[data-modal="error"]').find('main > p').html(response.message);
                    }
                }
            }
        });
    });
});
