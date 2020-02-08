'use strict';

$(document).ready(function()
{
    var tbl_rooms = $('#tbl_rooms').DataTable({
        ordering: false,
        pageLength: 25,
        info: false
    });

    $('[name="tbl_rooms_search"]').on('keyup', function()
    {
        tbl_rooms.search(this.value).draw();
    });

    $('[name="type"]').on('change', function()
    {
        if ($(this).val() == 'many')
        {
            $('form[name="new_room"]').find('[name="since"]').parent().parent().parent().removeClass('hidden');
            $('form[name="new_room"]').find('[name="to"]').parent().parent().parent().removeClass('hidden');
            $('form[name="new_room"]').find('[name="number"]').parent().parent().parent().addClass('hidden');
            $('form[name="new_room"]').find('[name="name"]').parent().parent().parent().addClass('hidden');
        }
        else if ($(this).val() == 'one')
        {
            $('form[name="new_room"]').find('[name="since"]').parent().parent().parent().addClass('hidden');
            $('form[name="new_room"]').find('[name="to"]').parent().parent().parent().addClass('hidden');
            $('form[name="new_room"]').find('[name="number"]').parent().parent().parent().removeClass('hidden');
            $('form[name="new_room"]').find('[name="name"]').parent().parent().parent().removeClass('hidden');
        }
    });

    $('[data-modal="new_room"]').modal().onCancel(function()
    {
        $('[data-modal="new_room"]').find('form')[0].reset();
        $('[data-modal="new_room"]').find('label.error').removeClass('error');
        $('[data-modal="new_room"]').find('p.error').remove();
        $('[data-modal="new_room"]').find('[name="since"]').parent().parent().parent().removeClass('hidden');
        $('[data-modal="new_room"]').find('[name="to"]').parent().parent().parent().removeClass('hidden');
        $('[data-modal="new_room"]').find('[name="number"]').parent().parent().parent().addClass('hidden');
        $('[data-modal="new_room"]').find('[name="name"]').parent().parent().parent().addClass('hidden');
    });

    $('[data-modal="new_room"]').modal().onSuccess(function()
    {
        $('[data-modal="new_room"]').find('form').submit();
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

    $('[data-modal="download_rooms"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'action=download_rooms',
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
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });

    var id;

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
                    $('[data-modal="edit_room"]').addClass('view');
                    $('[data-modal="edit_room"]').find('[name="number"]').val(response.data.number);
                    $('[data-modal="edit_room"]').find('[name="name"]').val(response.data.name);
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });

    $('[data-modal="edit_room"]').modal().onCancel(function()
    {
        $('[data-modal="edit_room"]').find('form')[0].reset();
        $('[data-modal="edit_room"]').find('label.error').removeClass('error');
        $('[data-modal="edit_room"]').find('p.error').remove();
    });

    $('[data-modal="edit_room"]').modal().onSuccess(function()
    {
        $('[data-modal="edit_room"]').find('form').submit();
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
                    $('[data-modal="success"]').addClass('view');
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    setTimeout(function() { location.reload(); }, 1500);
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });
});
