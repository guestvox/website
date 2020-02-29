'use strict';

$(document).ready(function()
{
    var tbl_menu = $('#tbl_menu').DataTable({
        ordering: false,
        pageLength: 25,
        info: false
    });

    $('[name="tbl_menu_search"]').on('keyup', function()
    {
        tbl_menu.search(this.value).draw();
    });

    $('[name="image"]').parents('.uploader').find('a').on('click', function()
    {
        $('[name="image"]').click();
    });

    $('[name="image"]').on('change', function()
    {
        var preview = $(this).parents('.uploader').find('img');

        if ($(this)[0].files[0].type.match($(this).attr('accept')))
        {
            var reader = new FileReader();

            reader.onload = function(e)
            {
                preview.attr('src', e.target.result);
            }

            reader.readAsDataURL($(this)[0].files[0]);
        }
        else
        {
            $('[data-modal="error"]').addClass('view');
            $('[data-modal="error"]').find('main > p').html('ERROR FILE NOT PERMIT');
        }
    });

    var id;
    var edit = false;

    $('[data-modal="new_menu"]').modal().onCancel(function()
    {
        id = null;
        edit = false;
        $('[data-modal="new_menu"]').removeClass('edit');
        $('[data-modal="new_menu"]').addClass('new');
        $('[data-modal="new_menu"]').find('header > h3').html('Nuevo');
        $('[data-modal="new_menu"]').find('form')[0].reset();
        $('[data-modal="new_menu"]').find('form').find('.uploader').find('img').attr('src', '../images/empty.png');
        $('[data-modal="new_menu"]').find('label.error').removeClass('error');
        $('[data-modal="new_menu"]').find('p.error').remove();
    });

    $('[data-modal="new_menu"]').modal().onSuccess(function()
    {
        $('[data-modal="new_menu"]').find('form').submit();
    });

    $('form[name="new_menu"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);
        var data = new FormData(form[0]);

        data.append('id', id);

        if (edit == false)
            data.append('action', 'new_menu');
        else if (edit == true)
            data.append('action', 'edit_menu');

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
                    $('[data-modal="success"]').addClass('view');
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    setTimeout(function() { location.reload(); }, 1500);
                }
                else if (response.status == 'error')
                {
                    if (response.labels)
                    {
                        form.find('label.error').removeClass('error');
                        form.find('p.error').remove();

                        $.each(response.labels, function(i, label)
                        {
                            if (label[1].length > 0)
                                form.find('[name="' + label[0] + '"]').parents('label').addClass('error').append('<p class="error">' + label[1] + '</p>');
                            else
                                form.find('[name="' + label[0] + '"]').parents('label').addClass('error');
                        });

                        form.find('label.error [name]')[0].focus();
                    }
                    else if (response.message)
                    {
                        $('[data-modal="error"]').addClass('view');
                        $('[data-modal="error"]').find('main > p').html(response.message);
                    }
                }
            }
        });
    });

    $(document).on('click', '[data-action="edit_menu"]', function()
    {
        id = $(this).data('id');
        edit = true;

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_menu',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="new_menu"]').removeClass('new');
                    $('[data-modal="new_menu"]').addClass('edit');
                    $('[data-modal="new_menu"]').addClass('view');
                    $('[data-modal="new_menu"]').find('header > h3').html('Editar');
                    $('[data-modal="new_menu"]').find('[name="name_es"]').val(response.data.name.es);
                    $('[data-modal="new_menu"]').find('[name="name_en"]').val(response.data.name.en);
                    $('[data-modal="new_menu"]').find('[name="price"]').val(response.data.price);
                    $('[data-modal="new_menu"]').find('[name="currency"]').val(response.data.currency);
                    $('[data-modal="new_menu"]').find('[name="description_es"]').val(response.data.description.es);
                    $('[data-modal="new_menu"]').find('[name="description_en"]').val(response.data.description.en);
                    $('[data-modal="new_menu"]').find('[name="image"]').parents('.uploader').find('img').attr('src', ((response.data.image != null) ? '../uploads/' + response.data.image : '../images/empty.png'));
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });

    var active = false;

    $(document).on('click', '[data-action="deactive_menu"]', function()
    {
        id = $(this).data('id');
        $('[data-modal="deactive_menu"]').addClass('view');
    });

    $(document).on('click', '[data-action="active_menu"]', function()
    {
        id = $(this).data('id');
        active = true;
        $('[data-modal="deactive_menu"]').find('header > h3').html('Activar');
        $('[data-modal="deactive_menu"]').addClass('view');
    });

    $('[data-modal="deactive_menu"]').modal().onCancel(function()
    {
        id = null;
        active = false;
        $('[data-modal="deactive_menu"]').find('header > h3').html('Desactivar');
    });

    $('[data-modal="deactive_menu"]').modal().onSuccess(function()
    {
        if (active == false)
            var data = 'id=' + id + '&action=deactive_menu';
        else if (active == true)
            var data = 'id=' + id + '&action=active_menu';

        $.ajax({
            type: 'POST',
            data: data,
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="success"]').addClass('view');
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    setTimeout(function() { location.reload(); }, 1500);
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });

    $(document).on('click', '[data-action="delete_menu"]', function()
    {
        id = $(this).data('id');
        $('[data-modal="delete_menu"]').addClass('view');
    });

    $('[data-modal="delete_menu"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_menu',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="success"]').addClass('view');
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    setTimeout(function() { location.reload(); }, 1500);
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });
});
