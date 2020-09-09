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

    $('[data-modal="new_menu_restaurant"]').modal().onCancel(function()
    {
        id = null;
        edit = false;

        clean_form($('form[name="new_menu_restaurant"]'));
    });

    $('form[name="new_menu_restaurant"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        if (edit == false)
            var data = '&action=new_menu_restaurant';
        else if (edit == true)
            var data = '&id=' + id + '&action=edit_menu_restaurant';

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

    $('[data-action="edit_menu_restaurant"]').on('click', function()
    {
        id = $(this).data('id');
        edit = true;

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_menu_restaurant',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[name="name_es"]').val(response.data.name.es);
                    $('[name="name_en"]').val(response.data.name.en);

                    required_focus('form', $('form[name="new_menu_restaurant"]'), null);

                    $('[data-modal="new_menu_restaurant"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="deactivate_menu_restaurant"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="deactivate_menu_restaurant"]').addClass('view');
    });

    $('[data-modal="deactivate_menu_restaurant"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=deactivate_menu_restaurant',
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

    $('[data-action="activate_menu_restaurant"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="activate_menu_restaurant"]').addClass('view');
    });

    $('[data-modal="activate_menu_restaurant"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=activate_menu_restaurant',
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

    $('[data-action="delete_menu_restaurant"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="delete_menu_restaurant"]').addClass('view');
    });

    $('[data-modal="delete_menu_restaurant"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_menu_restaurant',
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
