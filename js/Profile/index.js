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

            data.append('avatar', $(this)[0].files[0]);
            data.append('action', 'edit_avatar');

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

    $('[data-modal="edit_profile"]').modal().onSuccess(function()
    {
        $('form[name="edit_profile"]').submit();
    });

    $('form[name="edit_profile"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=edit_profile',
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

    $('[data-modal="reset_password"]').modal().onSuccess(function()
    {
        $('form[name="reset_password"]').submit();
    });

    $('form[name="reset_password"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=reset_password',
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
