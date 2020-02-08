'use strict';

$(document).ready(function()
{
    var tbl_reservation_statuses = $('#tbl_reservation_statuses').DataTable({
        ordering: false,
        pageLength: 25,
        info: false
    });

    $('[name="tbl_reservation_statuses_search"]').on('keyup', function()
    {
        tbl_reservation_statuses.search(this.value).draw();
    });

    var id;
    var edit = false;

    $('[data-modal="new_reservation_status"]').modal().onCancel(function()
    {
        edit = false;
        $('[data-modal="new_reservation_status"]').removeClass('edit');
        $('[data-modal="new_reservation_status"]').addClass('new');
        $('[data-modal="new_reservation_status"]').find('header > h3').html('Nuevo');
        $('form[name="new_reservation_status"]')[0].reset();
        $('label.error').removeClass('error');
        $('p.error').remove();
    });

    $('[data-modal="new_reservation_status"]').modal().onSuccess(function()
    {
        $('form[name="new_reservation_status"]').submit();
    });

    $('form[name="new_reservation_status"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        if (edit == false)
            var data = '&action=new_reservation_status';
        else if (edit == true)
            var data = '&id=' + id + '&action=edit_reservation_status';

        $.ajax({
            type: 'POST',
            data: form.serialize() + data,
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

    $(document).on('click','[data-action="edit_reservation_status"]', function()
    {
        id = $(this).data('id');
        edit = true;

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_reservation_status',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="new_reservation_status"]').removeClass('new');
                    $('[data-modal="new_reservation_status"]').addClass('edit');
                    $('[data-modal="new_reservation_status"]').find('header > h3').html('Editar');
                    $('form[name="new_reservation_status"]').find('[name="name"]').val(response.data.name);
                    $('[data-modal="new_reservation_status"]').addClass('view');
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').find('main > p').html(response.message);
                    $('[data-modal="error"]').addClass('view');
                }
            }
        });
    });

    $(document).on('click', '[data-action="delete_reservation_status"]', function()
    {
        id = $(this).data('id');

        $('[data-modal="delete_reservation_status"]').addClass('view');
    });

    $('[data-modal="delete_reservation_status"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_reservation_status',
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
