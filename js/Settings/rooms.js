'use strict';

$(document).ready(function()
{
    var id;

    $('.multi-tabs').multiTabs();

    var tbl_rooms = $('#rooms').DataTable({
        ordering: false,
        autoWidth: false,
        pageLength: 25,
        info: false,
    });

    $('[name="type"]').on('change', function()
    {
        if ($(this).val() == 'many')
        {
            $('[name="prefix"]').parent().parent().parent().removeClass('hidden');
            $('[name="since"]').parent().parent().parent().removeClass('hidden');
            $('[name="to"]').parent().parent().parent().removeClass('hidden');
            $('[name="suffix"]').parent().parent().parent().removeClass('hidden');
            $('[name="name"]').parent().parent().parent().addClass('hidden');
        }
        else if ($(this).val() == 'one')
        {
            $('[name="prefix"]').parent().parent().parent().addClass('hidden');
            $('[name="since"]').parent().parent().parent().addClass('hidden');
            $('[name="to"]').parent().parent().parent().addClass('hidden');
            $('[name="suffix"]').parent().parent().parent().addClass('hidden');
            $('[name="name"]').parent().parent().parent().removeClass('hidden');
        }
    });

    $('[data-action="new_room"]').on('click', function()
    {
        $('form[name="new_room"]').submit();
    });

    $('form[name="new_room"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=new_room',
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

    $(document).on('click', '[data-action="edit_room"]', function()
    {
        id = $(this).data('id');

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_room',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('form[name="edit_room"]').find('[name="name"]').val(response.data.name);
                    $('[data-modal="edit_room"]').addClass('view');
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').find('main > p').html(response.message);
                    $('[data-modal="error"]').addClass('view');
                }
            }
        });
    });

    $('[data-modal="edit_room"]').modal().onCancel(function()
    {
        $('label.error').removeClass('error');
        $('p.error').remove();
        $('form[name="edit_room"]')[0].reset();
    });

    $('[data-modal="edit_room"]').modal().onSuccess(function()
    {
        $('form[name="edit_room"]').submit();
    });

    $('form[name="edit_room"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&id=' + id + '&action=edit_room',
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

    $(document).on('click', '[data-action="delete_room"]', function()
    {
        id = $(this).data('id');

        $('[data-modal="delete_room"]').addClass('view');
    });

    $('[data-modal="delete_room"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_room',
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
