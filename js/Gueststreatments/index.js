'use strict';

$(document).ready(function()
{
    var id = null;
    var edit = false;

    $(document).on('keyup', '[name="name_es"], [name="name_en"]', function()
    {
        $.ajax({
            type: 'POST',
            data: 'name_es=' + $('[name="name_es"]').val() + '&action=translate',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    $('[name="name_en"]').val(response.data);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });

    });

    $('[data-modal="new_guest_treatment"]').modal().onCancel(function()
    {
        id = null;
        edit = false;

        clean_form($('form[name="new_guest_treatment"]'));
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
                    show_modal_success(response.message, 600);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('[data-action="edit_guest_treatment"]').on('click', function()
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
                    $('[name="name"]').val(response.data.name);

                    required_focus('form', $('form[name="new_guest_treatment"]'), null);

                    $('[data-modal="new_guest_treatment"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="deactivate_guest_treatment"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="deactivate_guest_treatment"]').addClass('view');
    });

    $('[data-modal="deactivate_guest_treatment"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=deactivate_guest_treatment',
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

    $('[data-action="activate_guest_treatment"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="activate_guest_treatment"]').addClass('view');
    });

    $('[data-modal="activate_guest_treatment"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=activate_guest_treatment',
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

    $('[data-action="delete_guest_treatment"]').on('click', function()
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
                    show_modal_success(response.message, 600);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });
});
