'use strict';

$(document).ready(function()
{
    var id = null;
    var edit = false;

    $(document).on('keyup', '[name="username"], [name="username"]', function()
    {
        var string = $(this).val().normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
        var filter = 'abcdefghijklmnñopqrstuvwxyz0123456789_';
        var out = '';

        for (var i = 0; i < string.length; i++)
        {
            if (filter.indexOf(string.charAt(i)) != -1)
                out += string.charAt(i);
        }

        $('[name="username"]').val(out);
    });

    $('[name="user_level"]').on('change', function()
    {
        $('[name="permissions[]"]').prop('checked', false);

        if ($(this).val() > 0)
        {
            $.ajax({
                type: 'POST',
                data: 'id=' + $(this).val() + '&action=get_user_level',
                processData: false,
                cache: false,
                dataType: 'json',
                success: function(response)
                {
                    if (response.status == 'success')
                    {
                        $.each(response.data.permissions, function (key, value)
                        {
                            $('[name="permissions[]"][value="' + value + '"]').prop('checked', true);
                        });
                    }
                    else if (response.status == 'error')
                        show_modal_error(response.message);
                }
            });
        }
    });

    $('[data-modal="new_user"]').modal().onCancel(function()
    {
        id = null;
        edit = false;

        clean_form($('form[name="new_user"]'));
    });

    $('form[name="new_user"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        if (edit == false)
            var data = '&action=new_user';
        else if (edit == true)
            var data = '&id=' + id + '&action=edit_user';

        $.ajax({
            type: 'POST',
            data: form.serialize() + data,
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 600);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('[data-action="edit_user"]').on('click', function()
    {
        id = $(this).data('id');
        edit = true;

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_user',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[name="firstname"]').val(response.data.firstname);
                    $('[name="lastname"]').val(response.data.lastname);
                    $('[name="email"]').val(response.data.email);
                    $('[name="phone_lada"]').val(response.data.phone.lada);
                    $('[name="phone_number"]').val(response.data.phone.number);
                    $('[name="username"]').val(response.data.username);
                    $('[name="whatsapp"]').prop('checked', ((response.data.whatsapp == true) ? true : false));

                    $.each(response.data.permissions, function (key, value)
                    {
                        $('[name="permissions[]"][value="' + value + '"]').prop('checked', true);
                    });

                    $.each(response.data.opportunity_areas, function (key, value)
                    {
                        $('[name="opportunity_areas[]"][value="' + value + '"]').prop('checked', true);
                    });

                    required_focus('form', $('form[name="new_user"]'), null);

                    $('[data-modal="new_user"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="restore_password_user"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="restore_password_user"]').addClass('view');
    });

    $('[data-modal="restore_password_user"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=restore_password_user',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 600);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="deactivate_user"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="deactivate_user"]').addClass('view');
    });

    $('[data-modal="deactivate_user"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=deactivate_user',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 600);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="activate_user"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="activate_user"]').addClass('view');
    });

    $('[data-modal="activate_user"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=activate_user',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 600);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="delete_user"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="delete_user"]').addClass('view');
    });

    $('[data-modal="delete_user"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_user',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 600);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });
});
