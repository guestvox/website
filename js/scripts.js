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

    $('[data-modal="support"]').modal().onSuccess(function()
    {
        $('form[name="support"]').submit();
    });

    $('[data-modal="support"]').modal().onCancel(function()
    {
        $('form[name="support"]')[0].reset();
        $('label.error').removeClass('error');
        $('p.error').remove();
    });

    $('form[name="support"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);
        var data = new FormData(form[0]);

        data.append('action', 'support');

        $.ajax({
            url: '/dashboard',
            type: 'POST',
            data: data,
            contentType: false,
            processData: false,
            cache: false,
            dataType: 'json',
            success: function (response)
            {
                $('label.error').removeClass('error');
                $('p.error').remove();

                if (response.status == 'success')
                {
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    $('[data-modal="success"]').addClass('view');

                    setTimeout(function() { location.reload(); }, 1500);
                }
                else if (response.status == 'error')
                {
                    if (response.labels)
                    {
                        $.each(response.labels, function(i, label)
                        {
                            if (label[1].length > 0)
                                form.find('[name="' + label[0] + '"]').parents('label').addClass('error').append('<p class="error">' + label[1] + '</p>');
                            else
                                form.find('[name="' + label[0] + '"]').parents('label').addClass('error');
                        });

                        form.find('label.error [name]')[0].focus();
                    }
                    else if (response.message)
                    {
                        $('[data-modal="error"]').find('main > p').html(response.message);
                        $('[data-modal="error"]').addClass('view');
                    }
                }
            }
        });
    });
});

function menu_focus(target = null)
{
    if (target != null)
    {
        $(document).find('header.main > section.menu > nav > ul > li[target="' + target + '"]').addClass('active');
    }
}
