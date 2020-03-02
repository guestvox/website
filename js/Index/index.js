'use strict';

$(document).ready(function()
{
    navScrollDown('header.landing-page-index', 'down', 0);

    $('[data-action="open-land-menu"]').on('click', function(e)
    {
        e.stopPropagation();
        $('header.landing-page-index nav > ul').toggleClass('open');
    });
});
