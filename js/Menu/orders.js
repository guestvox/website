'use strict';

$(document).ready(function()
{
    var id = null;

    $('[data-modal="view_map_menu_order"]').modal().onCancel(function()
    {
        id = null;

        $('#view_map_menu_order').html('');
    });

    $('[data-action="view_map_menu_order"]').on('click', function()
    {
        id = $(this).data('id');

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=view_map_menu_order',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('#view_map_menu_order').html(response.html);

                    $('[data-modal="view_map_menu_order"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="accept_menu_order"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="accept_menu_order"]').addClass('view');
    });

    $('[data-modal="accept_menu_order"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=accept_menu_order',
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

    $('[data-action="deliver_menu_order"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="deliver_menu_order"]').addClass('view');
    });

    $('[data-modal="deliver_menu_order"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=deliver_menu_order',
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
