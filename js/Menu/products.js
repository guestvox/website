'use strict';

$(document).ready(function()
{
    $('[data-button-modal="new_menu_product"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'action=get_menu_products_outstandings',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    $('[name="outstanding"]').val(response.data);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[name="avatar"]').on('change', function()
    {
        if ($(this).val() == 'image')
        {
            $('[name="image"]').parents('.span12').removeClass('hidden');
            $('[name="icon"]').parents('.span12').addClass('hidden');
        }
        else if ($(this).val() == 'icon')
        {
            $('[name="image"]').parents('.span12').addClass('hidden');
            $('[name="icon"]').parents('.span12').removeClass('hidden');
        }
    });

    var id = null;
    var edit = false;

    $('[data-modal="new_menu_product"]').modal().onCancel(function()
    {
        id = null;
        edit = false;

        $('[name="image"]').parents('.span12').removeClass('hidden');
        $('[name="icon"]').parents('.span12').addClass('hidden');

        clean_form($('form[name="new_menu_product"]'));
    });

    $('form[name="new_menu_product"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);
        var data = new FormData(form[0]);

        if (edit == false)
            data.append('action', 'new_menu_product');
        else if (edit == true)
        {
            data.append('id', id);
            data.append('action', 'edit_menu_product');
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

                    $.each(response.data.topics, function (key, value)
                    {
                        $('[name="topics[]"][value="' + value + '"]').prop('checked', true);
                    });

                    $('[name="price"]').val(response.data.price);
                    $('[name="outstanding"]').val(response.data.outstanding);
                    $('[name="avatar"]').val(response.data.avatar);
                    $('[name="image"]').parents('[data-uploader]').find('[data-preview] > img').attr('src', ((response.data.image) ? '../uploads/' + response.data.image : '../images/empty.png'));
                    $('[name="icon"][value="' + response.data.icon + '"]').prop('checked', true);

                    $.each(response.data.categories, function (key, value)
                    {
                        $('[name="categories[]"][value="' + value + '"]').prop('checked', true);
                    });

                    $('[name="restaurant"]').val(response.data.restaurant);

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
                    show_modal_success(response.message, 600);
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
                    show_modal_success(response.message, 600);
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
                    show_modal_success(response.message, 600);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });
});
