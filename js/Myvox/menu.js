'use strict';

$(document).ready(function()
{
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

    var id;

    $('[name="category"]').on('change', function()
    {
        id = $(this).val();

        var target = $(this);

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_menu',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    target.parents('main.myvox').find('[data-menu]').html(response.html);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $(document).on('click', '[data-action="remove_to_menu_cart"]', function()
    {
        id = $(this).data('id');

        var target = $(this);

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=remove_to_menu_cart',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    target.parents('main.myvox').find('[data-menu-cart]').html(response.html);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $(document).on('click', '[data-action="new_menu_cart"]', function()
    {
        $('form[name="new_menu_cart"]').submit();
    });

    $(document).on('submit', 'form[name="new_menu_cart"]', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=new_menu_cart',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 8000);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $(document).on('click', '[data-action="minus_to_menu_cart"]', function()
    {
        var target = $(this).parent().find('[name="quantity"]');
        var quantity = parseInt(target.val());
        quantity = (quantity > 0) ? quantity - 1 : 0;
        target.val(quantity);
    });

    $(document).on('click', '[data-action="plus_to_menu_cart"]', function()
    {
        var target = $(this).parent().find('[name="quantity"]');
        var quantity = parseInt(target.val());
        quantity = quantity + 1;
        target.val(quantity);
    });

    $(document).on('click', '[data-action="add_to_menu_cart"]', function()
    {
        id = $(this).data('id');

        $(this).parents('form[name="add_to_menu_cart"]').submit();
    });

    $(document).on('submit', 'form[name="add_to_menu_cart"]', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&id=' + id + '&action=add_to_menu_cart',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    form.find('[name="quantity"]').val(0);

                    form.parents('main.myvox').find('[data-menu-cart]').html(response.html);
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });
});
