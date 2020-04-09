'use strict';

$(window).on('beforeunload ajaxStart', function()
{
    $('body').prepend('<div data-ajax-loader><div class="loader"></div></div>');
});

$(window).on('ajaxStop', function()
{
    $('body').find('[data-ajax-loader]').remove();
});

$(document).ready(function ()
{
    var open_rightbar = false;

    $('[data-action="open-rightbar"]').on('click', function(e)
    {
        e.stopPropagation();

        $('body').toggleClass('open-rightbar');

        if (open_rightbar == false)
        {
            open_rightbar = true;

            $(this).find('i').removeClass('fas fa-bars');
            $(this).find('i').addClass('fas fa-times-circle');
        }
        else if (open_rightbar == true)
        {
            open_rightbar = false;

            $(this).find('i').removeClass('fas fa-times-circle');
            $(this).find('i').addClass('fas fa-bars');
        }
    });
});

function menu_focus(target = null)
{
    if (target != null)
        $(document).find('header.rightbar > nav > ul > li[target="' + target + '"]').addClass('active');
}
