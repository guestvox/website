'use strict';

$(document).ready(function()
{
    nav_scroll_down('main.landing_page_index > header', 'down', 0);

    $('[data-action="open_index_menu"]').on('click', function(e)
    {
        e.stopPropagation();

        $('main.landing_page_index > header > nav.desktop').toggleClass('open');
    });

    $('[data-modal="quote_hotel"]').modal().onCancel(function()
    {
        clean_form($('form[name="quote_hotel"]'));
    });

    $('form[name="quote_hotel"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&quote=hotel',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 8000);
                else if (response.status == 'error')
                    how_form_errors(form, response);
            }
        });
    });

    $('[data-modal="quote_restaurant"]').modal().onCancel(function()
    {
        clean_form($('form[name="quote_restaurant"]'));
    });

    $('form[name="quote_restaurant"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&quote=restaurant',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 8000);
                else if (response.status == 'error')
                    how_form_errors(form, response);
            }
        });
    });

    $('[data-modal="quote_personalize"]').modal().onCancel(function()
    {
        clean_form($('form[name="quote_personalize"]'));
    });

    $('form[name="quote_personalize"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&quote=personalize',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 8000);
                else if (response.status == 'error')
                    how_form_errors(form, response);
            }
        });
    });
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
