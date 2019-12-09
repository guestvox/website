'use strict';

$(document).ready(function()
{
    $('[data-image-select]').on('click', function()
    {
        $(this).parent().find('[data-image-upload]').click();
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
                        $('[data-modal="success"]').addClass('view');
                        $('[data-modal="success"] main > p').html(response.message);
                        setTimeout(function() { location.reload(); }, 1500);
                    }
                    else if (response.status == 'error')
                    {
                        $('[data-modal="alert"]').addClass('view');
                        $('[data-modal="alert"] main > p').html(response.message);
                    }
                }
            });
        }
        else
        {
            $('[data-modal="error"]').addClass('view');
            $('[data-modal="error"]').find('main > p').html('Error de operación');
        }
    });

    $('[data-modal="edit_profile"]').modal().onCancel(function()
    {
        $('[data-modal="edit_profile"]').find('label.error').removeClass('error');
        $('[data-modal="edit_profile"]').find('p.error').remove();
    });

    $('[data-modal="edit_profile"]').modal().onSuccess(function()
    {
        $('[data-modal="edit_profile"]').find('form').submit();
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
                if (response.status == 'success')
                {
                    $('[data-modal="success"]').addClass('view');
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    setTimeout(function() { location.reload(); }, 1500);
                }
                else if (response.status == 'error')
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
                    {
                        $('[data-modal="error"]').addClass('view');
                        $('[data-modal="error"]').find('main > p').html(response.message);
                    }
                }
            }
        });
    });

    $('[data-modal="edit_fiscal"]').modal().onCancel(function()
    {
        $('[data-modal="edit_fiscal"]').find('label.error').removeClass('error');
        $('[data-modal="edit_fiscal"]').find('p.error').remove();
    });

    $('[data-modal="edit_fiscal"]').modal().onSuccess(function()
    {
        $('[data-modal="edit_fiscal"]').find('form').submit();
    });

    $('form[name="edit_fiscal"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=edit_fiscal',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="success"]').addClass('view');
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    setTimeout(function() { location.reload(); }, 1500);
                }
                else if (response.status == 'error')
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
                    {
                        $('[data-modal="error"]').addClass('view');
                        $('[data-modal="error"]').find('main > p').html(response.message);
                    }
                }
            }
        });
    });

    $('[data-modal="edit_myvox"]').modal().onCancel(function()
    {
        $('[data-modal="edit_myvox"]').find('label.error').removeClass('error');
        $('[data-modal="edit_myvox"]').find('p.error').remove();
    });

    $('[data-modal="edit_myvox"]').modal().onSuccess(function()
    {
        $('[data-modal="edit_myvox"]').find('form').submit();
    });

    $('form[name="edit_myvox"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=edit_myvox',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="success"]').addClass('view');
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    setTimeout(function() { location.reload(); }, 1500);
                }
                else if (response.status == 'error')
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
                    {
                        $('[data-modal="error"]').addClass('view');
                        $('[data-modal="error"]').find('main > p').html(response.message);
                    }
                }
            }
        });
    });
});