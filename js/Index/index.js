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

function navScrollDown(target, style, height)
{
    var nav = {
        initialize: function()
        {
            $(document).each(function()
            {
                nav.scroller()
            });

            $(document).on('scroll', function()
            {
                nav.scroller()
            });
        },
        scroller: function()
        {
            if ($(document).scrollTop() > height)
                $(target).addClass(style);
            else
                $(target).removeClass(style);
        }
    }

    nav.initialize();
}
