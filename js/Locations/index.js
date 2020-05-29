'use strict';

$(document).ready(function()
{
    var id = null;
    var edit = false;

    $('[data-modal="new_location"]').modal().onCancel(function()
    {
        id = null;
        edit = false;

        $('[data-modal="new_location"]').find('form')[0].reset();
        $('[data-modal="new_location"]').find('label.error').removeClass('error');
        $('[data-modal="new_location"]').find('p.error').remove();
    });

    $('form[name="new_location"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        if (edit == false)
            var data = '&action=new_location';
        else if (edit == true)
            var data = '&id=' + id + '&action=edit_location';

        $.ajax({
            type: 'POST',
            data: form.serialize() + data,
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 1500);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('[data-action="edit_location"]').on('click', function()
    {
        id = $(this).data('id');
        edit = true;

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
                    $('[data-modal="new_location"]').addClass('view');

                    $('[data-modal="new_location"]').find('[name="name_es"]').val(response.data.name.es);
                    $('[data-modal="new_location"]').find('[name="name_en"]').val(response.data.name.en);
                    $('[data-modal="new_location"]').find('[name="request"]').prop('checked', ((response.data.request == true) ? true : false));
                    $('[data-modal="new_location"]').find('[name="incident"]').prop('checked', ((response.data.incident == true) ? true : false));
                    $('[data-modal="new_location"]').find('[name="workorder"]').prop('checked', ((response.data.workorder == true) ? true : false));
                    $('[data-modal="new_location"]').find('[name="public"]').prop('checked', ((response.data.public == true) ? true : false));

                    required_focus($('[data-modal="new_location"]').find('form'), true);
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="deactivate_location"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="deactivate_location"]').addClass('view');
    });

    $('[data-modal="deactivate_location"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=deactivate_location',
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
    });

    $('[data-action="activate_location"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="activate_location"]').addClass('view');
    });

    $('[data-modal="activate_location"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=activate_location',
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
    });

    $('[data-action="delete_location"]').on('click', function()
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
                    show_modal_success(response.message, 1500);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });
});
