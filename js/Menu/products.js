'use strict';

$(document).ready(function()
{
    // var image_crop;
    // var name_image = '';

    // image_crop = $('#upload-image').croppie({
    //     enableExif: true,
    //     viewport: {
    //       width:200,
    //       height:200,
    //       type:'circle' //circle
    //     },
    //     boundary:{
    //       width:300,
    //       height:300
    //     }
    // });

    // $('#image').on('change', function(){
    //     var reader = new FileReader();
    //     reader.onload = function (event) {
    //       image_crop.croppie('bind', {
    //         url: event.target.result
    //       }).then(function(){
    //         console.log('jQuery bind complete');
    //       });
    //     }

    //     name_image = this.files[0]['name'];
    //     reader.readAsDataURL(this.files[0]);
    //     $('[data-modal="image_crop"]').addClass('view');
    // });

    // $('form[name="image_crop"]').on('submit', function(e)
    // {
    //     e.preventDefault();

    //     image_crop.croppie('result', {
    //         type: 'canvas',
    //         size: 'viewport'
    //       }).then(function(data_image){
    //         $.ajax({
    //             type: 'POST',
    //             data: 'name=' + name_image + '&image=' + data_image + '&action=image_crop',
    //             processData: false,
    //             cache: false,
    //             dataType: 'json',
    //             success: function(response)
    //             {
    //                 if (response.status == 'success')
    //                     $('[name="image"]').parents('[data-uploader]').find('[data-preview] > img').attr('src', '../uploads/' + response.data);
    //                 else if (response.status == 'error')
    //                     show_form_errors(form, response);
    //             }
    //         });
            
    //       })
    // });
    
    $('.chosen-select').chosen();

    change_height_menu_preview();

    window.addEventListener('resize', function(e)
    {
        window.requestAnimationFrame(function()
        {
            change_height_menu_preview();
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
                {
                    $('[name="position"]').val(response.data);

                    required_focus('input', $('[name="position"]'), null);
                }
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
            success: function(response)
            {
                if (response.status == 'success')
                    $('div.menu_topics_groups > div > aside').html(response.html);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });

        $('[name="available_days[]"]').val(['monday','tuesday','wednesday','thursday','friday','saturday','sunday']).trigger("chosen:updated");
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
                        $('div.menu_topics_groups > div > aside').html(response.html);
                        $('[name="topics[]"]').prop('checked', false);
                        $('[name="selection"]').val('checkbox');

                        load_menu_topics_groups_actions();

                        add_menu_topics_group = false;
                    }
                    else
                        show_modal_success(response.message, 600);
                }
                else if (response.status == 'error')
                {
                    if (response.labels)
                    {
                        form.find('.error').removeClass('error');

                        $.each(response.labels, function(i, label)
                        {
                            form.find('[name="' + label[0] + '"]').parent().addClass('error');
                        });

                        form.find('.error [name]')[0].focus();
                    }
                    else if (response.message)
                        show_modal_error(response.message);
                }
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
                    $('[name="available_days[]"]').val(response.data.available.days).trigger("chosen:updated");
                    $('[name="available_start_date"]').val(response.data.available.start_date);
                    $('[name="available_end_date"]').val(response.data.available.end_date);
                    $('div.menu_topics_groups > div > aside').html(response.data.topics);
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

    $('form[name="filter_categories"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=filter_categories',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    location.reload();
                else if (response.status == 'error')
                    show_form_errors(form, response);
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
                    $('div.menu_topics_groups > div > aside').html(response.html);

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

function change_height_menu_preview()
{
    $('div.phone').css({
        'height': ($('html').height() - parseInt(100))
    });
}
