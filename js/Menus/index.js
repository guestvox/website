'use strict';

$(document).ready(function()
{
    var tbl_opportunity_areas = $('#tbl_menus').DataTable({
        ordering: false,
        pageLength: 25,
        info: false
    });

    $('[name="tbl_menus_search"]').on('keyup', function()
    {
        tbl_menus.search(this.value).draw();
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
        $('[data-modal="new_menu"]').find('label.error').removeClass('error');
        $('[data-modal="new_menu"]').find('p.error').remove();
        $('[data-modal="new_menu"]').find('[name="request"]').attr('checked', false);
        $('[data-modal="new_menu"]').find('[name="incident"]').attr('checked', false);
        $('[data-modal="new_menu"]').find('[name="workorder"]').attr('checked', false);
        $('[data-modal="new_menu"]').find('[name="public"]').attr('checked', false);
    });

    $('[data-modal="new_menu"]').modal().onSuccess(function()
    {
        $('[data-modal="new_menu"]').find('form').submit();
    });

    $('form[name="new_menu"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        if (edit == false)
            var data = '&action=new_menu';
        else if (edit == true)
            var data = '&id=' + id + '&action=edit_menu';

        $.ajax({
            type: 'POST',
            data: form.serialize() + data,
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

                    if (response.data.request == true)
                        $('[data-modal="new_menu"]').find('[name="request"]').attr('checked', true);

                    if (response.data.incident == true)
                        $('[data-modal="new_menu"]').find('[name="incident"]').attr('checked', true);

                    if (response.data.workorder == true)
                        $('[data-modal="new_menu"]').find('[name="workorder"]').attr('checked', true);

                    if (response.data.public == true)
                        $('[data-modal="new_menu"]').find('[name="public"]').attr('checked', true);
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
