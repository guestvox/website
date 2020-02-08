'use strict';

$(document).ready(function()
{
    var tbl_guest_types = $('#tbl_guest_types').DataTable({
        ordering: false,
        pageLength: 25,
        info: false
    });

    $('[name="tbl_guest_types_search"]').on('keyup', function()
    {
        tbl_guest_types.search(this.value).draw();
    });

    var id;
    var edit = false;

    $('[data-modal="new_guest_type"]').modal().onCancel(function()
    {
        id = null;
        edit = false;
        $('[data-modal="new_guest_type"]').removeClass('edit');
        $('[data-modal="new_guest_type"]').addClass('new');
        $('[data-modal="new_guest_type"]').find('header > h3').html('Nuevo');
        $('[data-modal="new_guest_type"]').find('form')[0].reset();
        $('[data-modal="new_guest_type"]').find('label.error').removeClass('error');
        $('[data-modal="new_guest_type"]').find('p.error').remove();
    });

    $('[data-modal="new_guest_type"]').modal().onSuccess(function()
    {
        $('[data-modal="new_guest_type"]').find('form').submit();
    });

    $('form[name="new_guest_type"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        if (edit == false)
            var data = '&action=new_guest_type';
        else if (edit == true)
            var data = '&id=' + id + '&action=edit_guest_type';

        $.ajax({
            type: 'POST',
            data: form.serialize() + data,
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

    $(document).on('click', '[data-action="edit_guest_type"]', function()
    {
        id = $(this).data('id');
        edit = true;

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_guest_type',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="new_guest_type"]').removeClass('new');
                    $('[data-modal="new_guest_type"]').addClass('edit');
                    $('[data-modal="new_guest_type"]').addClass('view');
                    $('[data-modal="new_guest_type"]').find('header > h3').html('Editar');
                    $('[data-modal="new_guest_type"]').find('[name="name"]').val(response.data.name);
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });

    $(document).on('click', '[data-action="delete_guest_type"]', function()
    {
        id = $(this).data('id');
        $('[data-modal="delete_guest_type"]').addClass('view');
    });

    $('[data-modal="delete_guest_type"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_guest_type',
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
