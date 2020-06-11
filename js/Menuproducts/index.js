'use strict';

$(document).ready(function()
{
    var id = null;
    var edit = false;

    $('[data-modal="new_menu_product"]').modal().onCancel(function()
    {
        id = null;
        edit = false;

        clean_form($('form[name="new_menu_product"]'));
    });

    $('form[name="new_menu_product"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);
        var data = new FormData(form[0]);

        data.append('id', id);

        if (edit == false)
            data.append('action', 'new_menu_product');
        else if (edit == true)
            data.append('action', 'edit_menu_product');

        $.ajax({
            type: 'POST',
            data: data,
            contentType: false,
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

    $('[data-action="edit_menu_product"]').on('click', function()
    {
        id = $(this).data('id');
        edit = true;

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_menu_product',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[name="name_es"]').val(response.data.name.es);
                    $('[name="name_en"]').val(response.data.name.en);
                    $('[name="description_es"]').val(response.data.description.es);
                    $('[name="description_en"]').val(response.data.description.en);
                    $('[name="price"]').val(response.data.price);
                    $('[name="avatar"]').parents('.stl_1').find('img').attr('src', ((response.data.avatar != null) ? '../uploads/' + response.data.avatar : '../images/empty.png'));

                    $.each(response.data.categories, function (key, value)
                    {
                        $('[name="categories[]"][value="' + value + '"]').prop('checked', true);
                    });

                    required_focus('form', $('form[name="new_menu_product"]'), null);

                    $('[data-modal="new_menu_product"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="deactivate_menu_product"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="deactivate_menu_product"]').addClass('view');
    });

    $('[data-modal="deactivate_menu_product"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=deactivate_menu_product',
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

    $('[data-action="activate_menu_product"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="activate_menu_product"]').addClass('view');
    });

    $('[data-modal="activate_menu_product"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=activate_menu_product',
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

    $('[data-action="delete_menu_product"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="delete_menu_product"]').addClass('view');
    });

    $('[data-modal="delete_menu_product"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_menu_product',
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
