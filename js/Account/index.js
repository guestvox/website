'use strict';

$(document).ready(function()
{
    $('[data-image-select]').on('click', function()
    {
        $(this).parents('.uploader').find('[data-image-upload]').click();
    });

    $('[data-image-upload]').on('change', function()
    {
        if ($(this)[0].files[0].type.match($(this).attr('accept')))
        {
            var data = new FormData();

            data.append('logotype', $(this)[0].files[0]);
            data.append('action', 'edit_logotype');

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
                    {
                        $('[data-modal="success"] main > p').html(response.message);
                        $('[data-modal="success"]').addClass('view').animate({scrollTop: 0}, 0);

                        setTimeout(function() { window.location.href = response.path }, 1500);
                    }
                    else if (response.status == 'error')
                    {
                        $('[data-modal="alert"] main > p').html(response.message);
                        $('[data-modal="alert"]').addClass('view').animate({scrollTop: 0}, 0);
                    }
                }
            });
        }
        else
        {
            $('[data-modal="error"]').find('main > p').html('ERROR FILE NOT PERMIT');
            $('[data-modal="error"]').addClass('view');
        }
    });

    $('[data-modal="edit_account"]').modal().onSuccess(function()
    {
        $('form[name="edit_account"]').submit();
    });

    $('form[name="edit_account"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=edit_account',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                $('label.error').removeClass('error');
                $('p.error').remove();

                if (response.status == 'success')
                {
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    $('[data-modal="success"]').addClass('view');

                    setTimeout(function() { window.location.href = response.path }, 1500);
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

    $('[data-modal="request_sms"]').modal().onSuccess(function()
    {
        $('form[name="request_sms"]').submit();
    });

    $('form[name="request_sms"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=request_sms',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                $('label.error').removeClass('error');
                $('p.error').remove();

                if (response.status == 'success')
                {
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    $('[data-modal="success"]').addClass('view');

                    setTimeout(function() { window.location.href = response.path }, 1500);
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
