'use strict';

$(document).ready(function()
{
    var id = null;
    var edit = false;

    $('[data-modal="new_opportunity_area"]').modal().onCancel(function()
    {
        id = null;
        edit = false;

        clean_form($('form[name="new_opportunity_area"]'));
    });

    $('form[name="new_opportunity_area"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        if (edit == false)
            var data = '&action=new_opportunity_area';
        else if (edit == true)
            var data = '&id=' + id + '&action=edit_opportunity_area';

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

    $('[data-action="edit_opportunity_area"]').on('click', function()
    {
        id = $(this).data('id');
        edit = true;

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_opportunity_area',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[name="name_es"]').val(response.data.name.es);
                    $('[name="name_en"]').val(response.data.name.en);
                    $('[name="request"]').prop('checked', ((response.data.request == true) ? true : false));
                    $('[name="incident"]').prop('checked', ((response.data.incident == true) ? true : false));
                    $('[name="workorder"]').prop('checked', ((response.data.workorder == true) ? true : false));
                    $('[name="public"]').prop('checked', ((response.data.public == true) ? true : false));

                    required_focus('form', $('form[name="new_opportunity_area"]'), null);

                    $('[data-modal="new_opportunity_area"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="deactivate_opportunity_area"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="deactivate_opportunity_area"]').addClass('view');
    });

    $('[data-modal="deactivate_opportunity_area"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=deactivate_opportunity_area',
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

    $('[data-action="activate_opportunity_area"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="activate_opportunity_area"]').addClass('view');
    });

    $('[data-modal="activate_opportunity_area"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=activate_opportunity_area',
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

    $('[data-action="delete_opportunity_area"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="delete_opportunity_area"]').addClass('view');
    });

    $('[data-modal="delete_opportunity_area"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_opportunity_area',
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
