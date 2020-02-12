'use strict';

$(document).ready(function()
{
    $('[data-action="open-land-menu"]').on('click', function(e)
    {
        e.stopPropagation();
        $('header.landing-page nav > ul').toggleClass('open');
    });
});
