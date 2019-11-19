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
    $('[data-action="open-dash-menu"]').on('click', function(e)
    {
        e.stopPropagation();

        $('header.main > section.menu > nav').toggleClass('open');
    });

    $(document).on('click', 'section.box-container > article > header, section.box-container > aside > .widget > header', function()
    {
        var self = $(this);
        var container = self.parent();

        if (container.hasClass('rolled'))
        {
            container.removeClass('rolled');
            container.find('> main').slideDown(300);
            container.find('> footer').slideDown(300);
        }
        else
        {
            container.addClass('rolled');
            container.find('> main').slideUp(300);
            container.find('> footer').slideUp(300);
        }
    });
});

function menu_focus(target = null)
{
    if (target != null)
    {
        $(document).find('header.main > section.menu > nav > ul > li[target="' + target + '"]').addClass('active');
    }
}
