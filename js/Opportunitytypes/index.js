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
            }
        });

    });

    $('[data-modal="new_opportunity_type"]').modal().onCancel(function()
    {
        id = null;
        edit = false;

        clean_form($('form[name="new_opportunity_type"]'));
    });

    $('form[name="new_opportunity_type"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        if (edit == false)
            var data = '&action=new_opportunity_type';
        else if (edit == true)
            var data = '&id=' + id + '&action=edit_opportunity_type';

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

    $('[data-action="edit_opportunity_type"]').on('click', function()
    {
        id = $(this).data('id');
        edit = true;

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_opportunity_type',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[name="name_es"]').val(response.data.name.es);
                    $('[name="name_en"]').val(response.data.name.en);
                    $('[name="opportunity_area"]').val(response.data.opportunity_area);
                    $('[name="request"]').prop('checked', ((response.data.request == true) ? true : false));
                    $('[name="incident"]').prop('checked', ((response.data.incident == true) ? true : false));
                    $('[name="workorder"]').prop('checked', ((response.data.workorder == true) ? true : false));
                    $('[name="public"]').prop('checked', ((response.data.public == true) ? true : false));

                    required_focus('form', $('form[name="new_opportunity_type"]'), null);

                    $('[data-modal="new_opportunity_type"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="deactivate_opportunity_type"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="deactivate_opportunity_type"]').addClass('view');
    });

    $('[data-modal="deactivate_opportunity_type"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=deactivate_opportunity_type',
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

    $('[data-action="activate_opportunity_type"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="activate_opportunity_type"]').addClass('view');
    });

    $('[data-modal="activate_opportunity_type"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=activate_opportunity_type',
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

    $('[data-action="delete_opportunity_type"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="delete_opportunity_type"]').addClass('view');
    });

    $('[data-modal="delete_opportunity_type"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_opportunity_type',
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
