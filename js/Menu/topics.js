'use strict';

$(document).ready(function()
{
    var id = null;
    var edit = false;

    $('[data-modal="new_menu_topic"]').modal().onCancel(function()
    {
        id = null;
        edit = false;

        clean_form($('form[name="new_menu_topic"]'));
    });

    $('form[name="new_menu_topic"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);
        var data = new FormData(form[0]);

        if (edit == false)
            data.append('action', 'new_menu_topic');
        else if (edit == true)
        {
            data.append('id', id);
            data.append('action', 'edit_menu_topic');
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
                    show_modal_success(response.message, 600);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('[data-action="edit_menu_topic"]').on('click', function()
    {
        id = $(this).data('id');
        edit = true;

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_menu_topic',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[name="name_es"]').val(response.data.name.es);
                    $('[name="name_en"]').val(response.data.name.en);

                    required_focus('form', $('form[name="new_menu_topic"]'), null);

                    $('[data-modal="new_menu_topic"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="deactivate_menu_topic"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="deactivate_menu_topic"]').addClass('view');
    });

    $('[data-modal="deactivate_menu_topic"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=deactivate_menu_topic',
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

    $('[data-action="activate_menu_topic"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="activate_menu_topic"]').addClass('view');
    });

    $('[data-modal="activate_menu_topic"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=activate_menu_topic',
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

    $('[data-action="delete_menu_topic"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="delete_menu_topic"]').addClass('view');
    });

    $('[data-modal="delete_menu_topic"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_menu_topic',
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
