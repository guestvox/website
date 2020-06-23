'use strict';

$(document).ready(function()
{
    $('[data-action="edit_profile"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'action=get_profile',
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

                    required_focus('form', $('form[name="edit_profile"]'), null);

                    $('[data-modal="edit_profile"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-modal="edit_profile"]').modal().onCancel(function()
    {
        clean_form($('form[name="edit_profile"]'));
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
                    show_modal_success(response.message, 1500);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('[data-modal="restore_password"]').modal().onCancel(function()
    {
        clean_form($('form[name="restore_password"]'));
    });

    $('form[name="restore_password"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=restore_password',
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
});
