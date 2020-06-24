'use strict';

$(document).ready(function()
{
    $('[data-action="filter_menu_products_by_category"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + $(this).data('id') + '&action=filter_menu_products_by_category',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    $('[data-menu-products]').html(response.html);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $(document).on('click', '[data-action="remove_to_menu_order"]', function()
    {
        var target = $(this);

        $.ajax({
            type: 'POST',
            data: 'id=' + $(this).data('id') + '&action=remove_to_menu_order',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    target.parent().find('span').html(response.data.quantity);
                    $('[data-total] > span').html(response.data.total);
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $(document).on('click', '[data-action="add_to_menu_order"]', function()
    {
        var target = $(this);

        $.ajax({
            type: 'POST',
            data: 'id=' + $(this).data('id') + '&action=add_to_menu_order',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    target.parent().find('span').html(response.data.quantity);
                    $('[data-total] > span').html(response.data.total);
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $(document).on('click', '[data-action="delete_to_menu_order"]', function()
    {
        var target = $(this);

        $.ajax({
            type: 'POST',
            data: 'id=' + $(this).data('id') + '&action=delete_to_menu_order',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    target.parent().parent().remove();
                    $('[data-total] > span').html(response.data.total);
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[name="owner"]').on('change', function()
    {
        $.ajax({
            type: 'POST',
            data: 'owner=' + $(this).val() + '&action=get_owner',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response) { }
        });
    });

    $('form[name="new_menu_order"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=new_menu_order',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 8000, response.path);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });
});
