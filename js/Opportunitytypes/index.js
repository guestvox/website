'use strict';

$(document).ready(function()
{
    var tbl_opportunity_types = $('#tbl_opportunity_types').DataTable({
        ordering: false,
        pageLength: 25,
        info: false
    });

    $('[name="tbl_opportunity_types_search"]').on('keyup', function()
    {
        tbl_opportunity_types.search(this.value).draw();
    });

    $('[name="opportunity_area"]').on('change', function()
    {
        tbl_opportunity_types.columns(0).search($(this).find('option:selected').text()).draw();
    });

    var id;
    var edit = false;

    $('[data-modal="new_opportunity_type"]').modal().onCancel(function()
    {
        id = null;
        edit = false;
        tbl_opportunity_types.columns(0).search('').draw();
        $('[data-modal="new_opportunity_type"]').removeClass('edit');
        $('[data-modal="new_opportunity_type"]').addClass('new');
        $('[data-modal="new_opportunity_type"]').find('header > h3').html('Nuevo');
        $('[data-modal="new_opportunity_type"]').find('form')[0].reset();
        $('[data-modal="new_opportunity_type"]').find('label.error').removeClass('error');
        $('[data-modal="new_opportunity_type"]').find('p.error').remove();
        $('[data-modal="new_opportunity_type"]').find('[name="request"]').attr('checked', false);
        $('[data-modal="new_opportunity_type"]').find('[name="incident"]').attr('checked', false);
        $('[data-modal="new_opportunity_type"]').find('[name="workorder"]').attr('checked', false);
        $('[data-modal="new_opportunity_type"]').find('[name="public"]').attr('checked', false);
    });

    $('[data-modal="new_opportunity_type"]').modal().onSuccess(function()
    {
        $('[data-modal="new_opportunity_type"]').find('form').submit();
    });

    $('form[name="new_opportunity_type"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        if (edit == false)
            var data = '&action=new_opportunity_type';
        else if (edit == true)
            var data = '&id=' + id + '&action=edit_opportunity_type';

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

    $(document).on('click', '[data-action="edit_opportunity_type"]', function()
    {
        id = $(this).data('id');
        edit = true;

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_opportunity_type',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="new_opportunity_type"]').removeClass('new');
                    $('[data-modal="new_opportunity_type"]').addClass('edit');
                    $('[data-modal="new_opportunity_type"]').addClass('view');
                    $('[data-modal="new_opportunity_type"]').find('header > h3').html('Editar');
                    $('[data-modal="new_opportunity_type"]').find('[name="opportunity_area"]').val(response.data.opportunity_area);
                    $('[data-modal="new_opportunity_type"]').find('[name="name_es"]').val(response.data.name.es);
                    $('[data-modal="new_opportunity_type"]').find('[name="name_en"]').val(response.data.name.en);

                    if (response.data.request == true)
                        $('[data-modal="new_opportunity_type"]').find('[name="request"]').attr('checked', true);

                    if (response.data.incident == true)
                        $('[data-modal="new_opportunity_type"]').find('[name="incident"]').attr('checked', true);

                    if (response.data.workorder == true)
                        $('[data-modal="new_opportunity_type"]').find('[name="workorder"]').attr('checked', true);

                    if (response.data.public == true)
                        $('[data-modal="new_opportunity_type"]').find('[name="public"]').attr('checked', true);
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });

    $(document).on('click', '[data-action="delete_opportunity_type"]', function()
    {
        id = $(this).data('id');
        $('[data-modal="delete_opportunity_type"]').addClass('view');
    });

    $('[data-modal="delete_opportunity_type"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_opportunity_type',
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
