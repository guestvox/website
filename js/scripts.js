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

    $('[data-action="open_rightbar"]').on('click', function(e)
    {
        e.stopPropagation();

        $('body').toggleClass('open_rightbar');

        if (open_rightbar == false)
        {
            open_rightbar = true;

            $(this).html('<i class="fas fa-times-circle"></i>');
        }
        else if (open_rightbar == true)
        {
            open_rightbar = false;

            $(this).html('<i class="fas fa-bars"></i>');
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

    $('[data-select]').on('click', function()
    {
        var type = $(this).parents('[data-uploader]').data('uploader');
        var target = $(this).parents('[data-uploader]').find('[data-upload]');
        var preview = null;
        var name = null;
        var action = null;

        if (type == 'fast')
        {
            name = target.attr('name');
            action = $(this).data('action');
        }
        else if (type == 'low')
            preview = $(this).parents('[data-uploader]').find('[data-preview] > img');

        upload_image(type, target, preview, name, action);
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

function upload_image(type, target, preview, name, action)
{
    target.click();

    target.on('change', function()
    {
        if (type == 'fast')
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
                        show_modal_success(response.message, 1500);
                    else if (response.status == 'error')
                        show_modal_error(response.message);
                }
            });
        }
        else if (type == 'low')
        {
            var reader = new FileReader();

            reader.onload = function(e)
            {
                var slt = target[0].files[0].name.split('.');
                slt = slt[1].toUpperCase();

                if (slt == 'PNG' || slt == 'JPG' || slt == 'JPEG')
                    slt = e.target.result;
                else if (slt == 'PDF')
                    slt = '../images/pdf.png';
                else if (slt == 'DOC' || slt == 'DOCX')
                    slt = '../images/word.png';
                else if (slt == 'XLS' || slt == 'XLSX')
                    slt = '../images/excel.png';

                preview.attr('src', slt);
            }

            reader.readAsDataURL(target[0].files[0]);
        }
    });
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

function show_modal_success(message, timeout)
{
    $('[data-modal="success"]').addClass('view');
    $('[data-modal="success"]').find('main > p').html(message);

    setTimeout(function() { location.reload(); }, timeout);
}

function show_modal_error(message)
{
    $('[data-modal="error"]').addClass('view');
    $('[data-modal="error"]').find('main > p').html(message);
}
