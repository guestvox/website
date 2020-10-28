'use strict';

$(document).ready(function()
{
    $('a[data-target]').on('click', function()
    {
        $('a[data-target]').removeClass('active');
        $(this).addClass('active');

        $('main').addClass('hidden');
        $('main[data-target="' + $(this).data('target') + '"]').removeClass('hidden');
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
