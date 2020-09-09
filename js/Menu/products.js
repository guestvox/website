'use strict';

$(document).ready(function()
{
    Push.Permission.DEFAULT; // 'default'
    Push.Permission.GRANTED; // 'granted'
    Push.Permission.DENIED; // 'denied'

    var pusher = new Pusher('1907b80d942422da0b8e', {
        cluster: 'us2'
      });

      var channel = pusher.subscribe('menu-orders');
      channel.bind('new-order', function(data) {
        show_modal_success(JSON.stringify(data), 3500);
        Push.create("Nuevo pedido", {
            body: "Pedido desde el menu",
            timeout: 4000,
            onClick: function () {
                window.focus();
                this.close();
            }
        });
        alert(JSON.stringify(data));
      });

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
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });

    });

    $('[data-action="open_preview_menu_product"]').on('click', function()
    {
        $(this).parents('article').find('div[data-id="' + $(this).data('id') + '"]').addClass('view');
    });

    $('[data-action="close_preview_menu_product"]').on('click', function()
    {
        $(this).parent().parent().parent().removeClass('view');
    });

    $('[data-button-modal="new_menu_product"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'action=get_menu_product_position',
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

    var add_menu_topics_group = false;

    $('[data-action="add_menu_topics_group"]').on('click', function()
    {
        add_menu_topics_group = true;

        $('form[name="new_menu_product"]').submit();
    });

    load_menu_topics_groups_actions();

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
        add_menu_topics_group = false;
        id = null;
        edit = false;

        $.ajax({
            type: 'POST',
            data: 'action=clear_menu_topics_groups',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response) {}
        });

        $('div.menu_topics_groups > aside').html('');
        $('[name="image"]').parents('.span12').removeClass('hidden');
        $('[name="icon"]').parents('.span12').addClass('hidden');

        clean_form($('form[name="new_menu_product"]'));
    });

    $('form[name="new_menu_product"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);
        var data = new FormData(form[0]);

        if (add_menu_topics_group == true)
            data.append('action', 'add_menu_topics_group');
        else
        {
            if (edit == false)
                data.append('action', 'new_menu_product');
            else if (edit == true)
            {
                data.append('id', id);
                data.append('action', 'edit_menu_product');
            }
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
                    if (add_menu_topics_group == true)
                    {
                        $('div.menu_topics_groups > aside').html(response.html);
                        $('[name="topics[]"]').prop('checked', false);
                        $('[name="selection"]').val('');

                        load_menu_topics_groups_actions();

                        add_menu_topics_group = false;
                    }
                    else
                        show_modal_success(response.message, 600);
                }
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
                    $('[name="position"]').val(response.data.position);
                    $('div.menu_topics_groups > aside').html(response.data.topics);
                    $('[name="avatar"]').val(response.data.avatar);

                    if (response.data.avatar == 'image')
                    {
                        $('[name="image"]').parents('[data-uploader]').find('[data-preview] > img').attr('src', '../uploads/' + response.data.image);

                        $('[name="image"]').parents('.span12').removeClass('hidden');
                        $('[name="icon"]').parents('.span12').addClass('hidden');
                    }
                    else if (response.data.avatar == 'icon')
                    {
                        $('[name="icon"][value="' + response.data.icon + '"]').prop('checked', true);

                        $('[name="image"]').parents('.span12').addClass('hidden');
                        $('[name="icon"]').parents('.span12').removeClass('hidden');
                    }

                    $.each(response.data.categories, function (key, value)
                    {
                        $('[name="categories[]"][value="' + value + '"]').prop('checked', true);
                    });

                    $('[name="restaurant"]').val(response.data.restaurant);

                    required_focus('form', $('form[name="new_menu_product"]'), null);

                    load_menu_topics_groups_actions();

                    $('[data-modal="new_menu_product"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="up_menu_product"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + $(this).data('id') + '&action=up_menu_product',
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

    $('[data-action="down_menu_product"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + $(this).data('id') + '&action=down_menu_product',
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

function load_menu_topics_groups_actions()
{
    $('[data-action="remove_menu_topics_group"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'key=' + $(this).data('key') + '&subkey=' + $(this).data('subkey') + '&action=remove_menu_topics_group',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('div.menu_topics_groups > aside').html(response.html);

                    load_menu_topics_groups_actions();
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[name="update_menu_topic_price"]').on('change', function()
    {
        var input = $(this);

        $.ajax({
            type: 'POST',
            data: 'key=' + input.data('key') + '&subkey=' + input.data('subkey') + '&price=' + input.val() + '&action=update_menu_topic_price',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    input.val(response.price);
                else if (response.status == 'error')
                    input.val('0');
            }
        });
    });
}
