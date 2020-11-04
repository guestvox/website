'use strict';

$(document).ready(function()
{
    $('a[data-target]').on('click', function()
    {
        var target = $(this).data('target');

        $.ajax({
            type: 'POST',
            data: 'target=' + target + '&action=change_target',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('header').find('a[data-target]').removeClass('active');
                    $('header').find('a[data-target="' + target + '"]').addClass('active');

                    $('main').addClass('hidden');
                    $('main[data-target="' + target + '"]').removeClass('hidden');

                    $('body, html').animate({
            			scrollTop: '0px'
            		}, 800);
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="lpr_opn_mnu"]').on('click', function(event)
    {
        event.stopPropagation();

        $(this).parent().find('nav').toggleClass('open');
    });

    $('header.landing_page_restaurants').find('nav').on('click', function()
    {
        $(this).parent().find('nav').removeClass('open');
    });
});
