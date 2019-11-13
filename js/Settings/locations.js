'use strict';

$(document).ready(function()
{
    var id;

    $('.multi-tabs').multiTabs();

    var tbl_locations = $('#locations').DataTable({
        ordering: false,
        autoWidth: false,
        pageLength: 25,
        info: false,
    });

    $('[data-action="new_location"]').on('click', function()
    {
        $('form[name="new_location"]').submit();
    });

    $('form[name="new_location"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=new_location',
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

    $(document).on('click','[data-action="edit_location"]', function()
    {
        id = $(this).data('id');

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_location',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('form[name="edit_location"]').find('[name="name_es"]').val(response.data.name.es);
                    $('form[name="edit_location"]').find('[name="name_en"]').val(response.data.name.en);

                    if (response.data.request == true)
                        $('form[name="edit_location"]').find('[name="request"]').attr('checked', true);

                    if (response.data.incident == true)
                        $('form[name="edit_location"]').find('[name="incident"]').attr('checked', true);

                    if (response.data.public == true)
                        $('form[name="edit_location"]').find('[name="public"]').attr('checked', true);

                    $('[data-modal="edit_location"]').addClass('view');
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').find('main > p').html(response.message);
                    $('[data-modal="error"]').addClass('view');
                }
            }
        });
    });

    $('[data-modal="edit_location"]').modal().onCancel(function()
    {
        $('label.error').removeClass('error');
        $('p.error').remove();
        $('form[name="edit_location"]').find('[name="request"]').attr('checked', false);
        $('form[name="edit_location"]').find('[name="incident"]').attr('checked', false);
        $('form[name="edit_location"]').find('[name="public"]').attr('checked', false);
        $('form[name="edit_location"]')[0].reset();
    });

    $('[data-modal="edit_location"]').modal().onSuccess(function()
    {
        $('form[name="edit_location"]').submit();
    });

    $('form[name="edit_location"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&id=' + id + '&action=edit_location',
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

    $(document).on('click', '[data-action="delete_location"]', function()
    {
        id = $(this).data('id');

        $('[data-modal="delete_location"]').addClass('view');
    });

    $('[data-modal="delete_location"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_location',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    $('[data-modal="success"]').addClass('view');

                    setTimeout(function() { location.reload(); }, 1500);
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').find('main > p').html(response.message);
                    $('[data-modal="error"]').addClass('view');
                }
            }
        });
    });

});
