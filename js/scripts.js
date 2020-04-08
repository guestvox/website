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
    var open = false;

    $('[data-action="open-rightbar"]').on('click', function(e)
    {
        e.stopPropagation();

        $('body').toggleClass('open-rightbar');

        if (open == false)
        {
            open = true;

            $(this).find('i').removeClass('fas fa-bars');
            $(this).find('i').addClass('fas fa-times-circle');
        }
        else if (open == true)
        {
            open = false;

            $(this).find('i').removeClass('fas fa-times-circle');
            $(this).find('i').addClass('fas fa-bars');
        }
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

function menu_focus(target = null)
{
    if (target != null)
    {
        $(document).find('header.rightbar > nav > ul > li[target="' + target + '"]').addClass('active');
    }
}
