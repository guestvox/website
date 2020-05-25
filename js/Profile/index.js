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
                    $('[data-modal="edit_profile"]').addClass('view');
                    $('[data-modal="edit_profile"]').find('[name="firstname"]').val(response.data.firstname);
                    $('[data-modal="edit_profile"]').find('[name="lastname"]').val(response.data.lastname);
                    $('[data-modal="edit_profile"]').find('[name="email"]').val(response.data.email);
                    $('[data-modal="edit_profile"]').find('[name="phone_lada"]').val(response.data.phone.lada);
                    $('[data-modal="edit_profile"]').find('[name="phone_number"]').val(response.data.phone.number);
                    $('[data-modal="edit_profile"]').find('[name="username"]').val(response.data.username);

                    required_focus($('[data-modal="edit_profile"]').find('form'), true);
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-modal="edit_profile"]').modal().onCancel(function()
    {
        $('[data-modal="edit_profile"]').find('form')[0].reset();
        $('[data-modal="edit_profile"]').find('label.error').removeClass('error');
        $('[data-modal="edit_profile"]').find('p.error').remove();
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
                    show_modal_success(response.message);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('[data-modal="restore_password"]').modal().onCancel(function()
    {
        $('[data-modal="restore_password"]').find('form')[0].reset();
        $('[data-modal="restore_password"]').find('label.error').removeClass('error');
        $('[data-modal="restore_password"]').find('p.error').remove();
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
                    show_modal_success(response.message);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });
});
