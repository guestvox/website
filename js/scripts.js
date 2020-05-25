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

    $('[required]').each(function()
    {
        required_focus($(this), false);
    });

    $('[required]').on('change', function()
    {
        required_focus($(this), false);
    });

    $('[unrequired]').each(function()
    {
        required_focus($(this), false);
    });

    $('[unrequired]').on('change', function()
    {
        required_focus($(this), false);
    });

    $('[data-image-select]').on('click', function()
    {
        var type = $(this).data('type');
        var target = $(this).parents('[data-uploader]').find('[data-image-upload]');
        var name = null;
        var action = null;

        if (type == 'fast')
        {
            name = target.attr('name');
            action = $(this).data('action');
        }

        upload_image(type, target, name, action);
    });
});

function menu_focus(target)
{
    $(document).find('header.rightbar > nav > ul > li[target="' + target + '"]').addClass('active');
}

function required_focus(target, form)
{
    var subtarget = target.find('[name]');

    if (form == true)
    {
        subtarget.each(function(key, value)
        {
            var child = target.find('[name="' + value.getAttribute('name') + '"]');
            var parent = child.parent();

            if (child.val() != '')
            {
                parent.addClass('success');
                parent.removeClass('error');
                parent.find('p.error').remove();
            }
            else
                parent.removeClass('success');
        });
    }
    else
    {
        if (subtarget.val() != '')
        {
            target.addClass('success');
            target.removeClass('error');
            target.find('p.error').remove();
        }
        else
            target.removeClass('success');
    }
}

function show_form_errors(form, response)
{
    if (response.labels)
    {
        form.find('label.error').removeClass('error');
        form.find('p.error').remove();

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
        show_modal_error(response.message);
}

function show_modal_success(message)
{
    $('[data-modal="success"]').addClass('view');
    $('[data-modal="success"]').find('main > p').html(message);
    setTimeout(function() { location.reload(); }, 1500);
}

function show_modal_error(message)
{
    $('[data-modal="error"]').addClass('view');
    $('[data-modal="error"]').find('main > p').html(message);
}

function upload_image(type, target, name, action)
{
    if (type == 'fast')
    {
        target.click();

        target.on('change', function()
        {
            if (target[0].files[0].type.match(target.attr('accept')))
            {
                var data = new FormData();

                data.append(name, target[0].files[0]);
                data.append('action', action);

                $.ajax({
                    type: 'POST',
                    data: data,
                    contentType: false,
                    processData: false,
                    cache: false,
                    dataType: 'json',
                    success: function(response)
                    {
                        if (response.status == 'success')
                            show_modal_success(response.message);
                        else if (response.status == 'error')
                            show_modal_error(response.message);
                    }
                });
            }
            else
                show_modal_error('ERROR');
        });
    }
}
