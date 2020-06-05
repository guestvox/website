'use strict';

$(document).ready(function()
{
    var id = null;
    var edit = false;

    $('[data-modal="new_user_level"]').modal().onCancel(function()
    {
        id = null;
        edit = false;

        clean_form($('form[name="new_user_level"]'));
    });

    $('form[name="new_user_level"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        if (edit == false)
            var data = '&action=new_user_level';
        else if (edit == true)
            var data = '&id=' + id + '&action=edit_user_level';

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

    $('[data-action="edit_user_level"]').on('click', function()
    {
        id = $(this).data('id');
        edit = true;

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_user_level',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="new_user_level"]').find('[name="name"]').val(response.data.name);

                    $.each(response.data.permissions, function (key, value)
                    {
                        $('[data-modal="new_user_level"]').find('[name="permissions[]"][value="' + value + '"]').prop('checked', true);
                    });

                    required_focus('form', $('form[name="new_user_level"]'), null);

                    $('[data-modal="new_user_level"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="deactivate_user_level"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="deactivate_user_level"]').addClass('view');
    });

    $('[data-modal="deactivate_user_level"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=deactivate_user_level',
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

    $('[data-action="activate_user_level"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="activate_user_level"]').addClass('view');
    });

    $('[data-modal="activate_user_level"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=activate_user_level',
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

    $('[data-action="delete_user_level"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="delete_user_level"]').addClass('view');
    });

    $('[data-modal="delete_user_level"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_user_level',
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
