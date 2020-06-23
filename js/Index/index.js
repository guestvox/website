'use strict';

$(document).ready(function()
{
    nav_scroll_down('main.landing_page_index > header', 'down', 0);
});

function nav_scroll_down(target, css, height)
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
                $(target).addClass(css);
            else
                $(target).removeClass(css);
        }
    }

    nav.initialize();
}
