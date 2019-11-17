'use strict';

$(document).ready(function()
{
    var tbl_guest_treatments = $('#tbl_guest_treatments').DataTable({
        ordering: false,
        pageLength: 25,
        info: false,
    });

    $('[name="tbl_guest_treatments_search"]').on('keyup', function()
    {
        tbl_guest_treatments.search(this.value).draw();
    });

    var id;
    var edit = false;

    $('[data-modal="new_guest_treatment"]').modal().onCancel(function()
    {
        id = null;
        edit = false;
        $('[data-modal="new_guest_treatment"]').removeClass('edit');
        $('[data-modal="new_guest_treatment"]').addClass('new');
        $('[data-modal="new_guest_treatment"]').find('header > h3').html('Nuevo');
        $('[data-modal="new_guest_treatment"]').find('form')[0].reset();
        $('[data-modal="new_guest_treatment"]').find('label.error').removeClass('error');
        $('[data-modal="new_guest_treatment"]').find('p.error').remove();
    });

    $('[data-modal="new_guest_treatment"]').modal().onSuccess(function()
    {
        $('[data-modal="new_guest_treatment"]').find('form').submit();
    });

    $('form[name="new_guest_treatment"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        if (edit == false)
            var data = '&action=new_guest_treatment';
        else if (edit == true)
            var data = '&id=' + id + '&action=edit_guest_treatment';

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

    $(document).on('click', '[data-action="edit_guest_treatment"]', function()
    {
        id = $(this).data('id');
        edit = true;

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_guest_treatment',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="new_guest_treatment"]').removeClass('new');
                    $('[data-modal="new_guest_treatment"]').addClass('edit');
                    $('[data-modal="new_guest_treatment"]').addClass('view');
                    $('[data-modal="new_guest_treatment"]').find('header > h3').html('Editar');
                    $('[data-modal="new_guest_treatment"]').find('[name="name"]').val(response.data.name);
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });

    $(document).on('click', '[data-action="delete_guest_treatment"]', function()
    {
        id = $(this).data('id');
        $('[data-modal="delete_guest_treatment"]').addClass('view');
    });

    $('[data-modal="delete_guest_treatment"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_guest_treatment',
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
