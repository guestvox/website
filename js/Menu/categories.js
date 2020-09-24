'use strict';

$(document).ready(function()
{
    $('[data-button-modal="new_menu_category"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'action=get_menu_category_position',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    $('[name="position"]').val(response.data);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="create_other_category"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'action=get_menu_category_position',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    clean_form($('form[name="new_menu_category"]'));

                    $('[name="position"]').val(response.data);

                    $('[data-modal="new_menu_category"]').addClass('view');
                    $('[data-modal="actions"]').removeClass('view');

                    $('[name="name_es"]').focus();
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    var id = null;
    var edit = false;

    $('[data-modal="new_menu_category"]').modal().onCancel(function()
    {
        id = null;
        edit = false;

        clean_form($('form[name="new_menu_category"]'));
    });

    $('form[name="new_menu_category"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);
        var data = new FormData(form[0]);

        if (edit == false)
            data.append('action', 'new_menu_category');
        else if (edit == true)
        {
            data.append('id', id);
            data.append('action', 'edit_menu_category');
        }

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
                {
                    if (edit == false)
                        show_modal_success(response.message, null, 'actions');
                    else if (edit == true)
                        show_modal_success(response.message, 600);
                }
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('[data-action="edit_menu_category"]').on('click', function()
    {
        id = $(this).data('id');
        edit = true;

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_menu_category',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[name="name_es"]').val(response.data.name.es);
                    $('[name="name_en"]').val(response.data.name.en);
                    $('[name="position"]').val(response.data.position);
                    $('[name="icon"][value="' + response.data.icon + '"]').prop('checked', true);

                    required_focus('form', $('form[name="new_menu_category"]'), null);

                    $('[data-modal="new_menu_category"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="up_menu_category"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + $(this).data('id') + '&action=up_menu_category',
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

    $('[data-action="down_menu_category"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + $(this).data('id') + '&action=down_menu_category',
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

    $('[data-action="deactivate_menu_category"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="deactivate_menu_category"]').addClass('view');
    });

    $('[data-modal="deactivate_menu_category"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=deactivate_menu_category',
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

    $('[data-action="activate_menu_category"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="activate_menu_category"]').addClass('view');
    });

    $('[data-modal="activate_menu_category"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=activate_menu_category',
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

    $('[data-action="delete_menu_category"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="delete_menu_category"]').addClass('view');
    });

    $('[data-modal="delete_menu_category"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_menu_category',
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
