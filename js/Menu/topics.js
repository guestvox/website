'use strict';

$(document).ready(function()
{
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
    
    $('[data-button-modal="new_menu_topic"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'action=get_menu_topic_position',
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

    $('[data-action="create_other_topic"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'action=get_menu_topic_position',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    clean_form($('form[name="new_menu_topic"]'));

                    $('[name="position"]').val(response.data);

                    $('[data-modal="new_menu_topic"]').addClass('view');
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
                    $('[name="position"]').val(response.data.position);

                    required_focus('form', $('form[name="new_menu_topic"]'), null);

                    $('[data-modal="new_menu_topic"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="up_menu_topic"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + $(this).data('id') + '&action=up_menu_topic',
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

    $('[data-action="down_menu_topic"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + $(this).data('id') + '&action=down_menu_topic',
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
