'use strict';

$(document).ready(function()
{
    var id = null;
    var edit = false;

    $('[data-modal="new_reservation_status"]').modal().onCancel(function()
    {
        id = null;
        edit = false;

        clean_form($('form[name="new_reservation_status"]'));
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
                if (response.status == 'success')
                    show_modal_success(response.message, 600);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('[data-action="edit_reservation_status"]').on('click', function()
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
                    $('[name="name"]').val(response.data.name);

                    required_focus('form', $('form[name="new_reservation_status"]'), null);

                    $('[data-modal="new_reservation_status"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="deactivate_reservation_status"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="deactivate_reservation_status"]').addClass('view');
    });

    $('[data-modal="deactivate_reservation_status"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=deactivate_reservation_status',
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

    $('[data-action="activate_reservation_status"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="activate_reservation_status"]').addClass('view');
    });

    $('[data-modal="activate_reservation_status"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=activate_reservation_status',
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

    $('[data-action="delete_reservation_status"]').on('click', function()
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
                    show_modal_success(response.message, 600);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });
});
