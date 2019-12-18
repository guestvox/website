'use strict';

$(document).ready(function ()
{
    var tbl_vox_reports = $('#tbl_vox_reports').DataTable({
        ordering: false,
        pageLength: 25,
        info: false,
    });

    $('[name="tbl_vox_reports_search"]').on('keyup', function()
    {
        tbl_vox_reports.search(this.value).draw();
    });

    $('[name="type"]').on('change', function()
    {
        var parent = $(this).parents('form');

        $.ajax({
            type: 'POST',
            data: 'option=' + $(this).val() + '&action=get_opt_opportunity_areas',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    parent.find('[name="opportunity_area"]').html(response.data);
                    parent.find('[name="opportunity_type"]').html('<option value="all">Todo</option>');
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });

        $.ajax({
            type: 'POST',
            data: 'option=' + $(this).val() + '&action=get_opt_locations',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    parent.find('[name="location"]').html(response.data);
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });

        $.ajax({
            type: 'POST',
            data: 'option=' + $(this).val() + '&action=get_cbx_addressed_to_opportunity_areas',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    parent.find('[name="addressed_to_opportunity_areas[]"]').parent().parent().html(response.data);
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });

        $.ajax({
            type: 'POST',
            data: 'option=' + $(this).val() + '&action=get_cbx_fields',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    parent.find('[name="fields[]"]').parent().parent().html(response.data);
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });

    $('[name="opportunity_area"]').on('change', function()
    {
        var parent = $(this).parents('form');

        $.ajax({
            type: 'POST',
            data: 'opportunity_area=' + $(this).val() + '&option=' + parent.find('[name="type"]').val() + '&action=get_opt_opportunity_types',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    parent.find('[name="opportunity_type"]').html(response.data);
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });

    $('[name="addressed_to"]').on('change', function()
    {
        var parent = $(this).parents('form');

        if ($(this).val() == 'opportunity_areas')
            parent.find('[name="addressed_to_opportunity_areas[]"]').parent().parent().parent().parent().parent().parent().removeClass('hidden');
        else
            parent.find('[name="addressed_to_opportunity_areas[]"]').parent().parent().parent().parent().parent().parent().addClass('hidden');
    });

    $(document).on('change', '[name="checked_all"]', function()
    {
        if ($(this).prop('checked') == true)
            $(this).parent().parent().find('[type="checkbox"]').prop('checked', true);
        else if ($(this).prop('checked') == false)
            $(this).parent().parent().find('[type="checkbox"]').prop('checked', false);
    });

    $(document).on('change', '[type="checkbox"]', function()
    {
        if ($(this).prop('checked') == false)
            $(this).parent().parent().find('[name="checked_all"]').prop('checked', false);
    });

    var id;
    var edit = false;

    $('[data-modal="new_vox_report"]').modal().onCancel(function()
    {
        id = null;
        edit = false;
        $('[data-modal="new_vox_report"]').removeClass('edit');
        $('[data-modal="new_vox_report"]').addClass('new');
        $('[data-modal="new_vox_report"]').find('header > h3').html('Nuevo');
        $('[data-modal="new_vox_report"]').find('form')[0].reset();
        $('[data-modal="new_vox_report"]').find('[name="addressed_to_opportunity_areas[]"]').prop('checked', false)
        $('[data-modal="new_vox_report"]').find('[name="addressed_to_opportunity_areas[]"]').parent().parent().parent().parent().parent().parent().addClass('hidden');
        $('[data-modal="new_vox_report"]').find('[name="fields[]"]').prop('checked', false)
        $('[data-modal="new_vox_report"]').find('label.error').removeClass('error');
        $('[data-modal="new_vox_report"]').find('p.error').remove();
    });

    $('[data-modal="new_vox_report"]').modal().onSuccess(function()
    {
        $('[data-modal="new_vox_report"]').find('form').submit();
    });

    $('form[name="new_vox_report"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        if (edit == false)
            var data = '&action=new_vox_report';
        else if (edit == true)
            var data = '&id=' + id + '&action=edit_vox_report';

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

    $(document).on('click','[data-action="edit_vox_report"]', function()
    {
        id = $(this).data('id');
        edit = true;

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_vox_report',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="new_vox_report"]').removeClass('new');
                    $('[data-modal="new_vox_report"]').addClass('edit');
                    $('[data-modal="new_vox_report"]').addClass('view');
                    $('[data-modal="new_vox_report"]').find('header > h3').html('Editar');
                    $('[data-modal="new_vox_report"]').find('[name="name"]').val(response.data.name);
                    $('[data-modal="new_vox_report"]').find('[name="type"]').val(response.data.type);
                    $('[data-modal="new_vox_report"]').find('[name="opportunity_area"]').val(response.data.opportunity_area);
                    $('[data-modal="new_vox_report"]').find('[name="opportunity_type"]').val(response.data.opportunity_type);
                    $('[data-modal="new_vox_report"]').find('[name="room"]').val(response.data.room);
                    $('[data-modal="new_vox_report"]').find('[name="table"]').val(response.data.table);
                    $('[data-modal="new_vox_report"]').find('[name="location"]').val(response.data.location);
                    $('[data-modal="new_vox_report"]').find('[name="order"]').val(response.data.order);
                    $('[data-modal="new_vox_report"]').find('[name="time_period"]').val(response.data.time_period);
                    $('[data-modal="new_vox_report"]').find('[name="addressed_to"]').val(response.data.addressed_to);

                    if (response.data.addressed_to == 'opportunity_areas')
                    {
                        $('[data-modal="new_vox_report"]').find('[name="addressed_to_opportunity_areas[]"]').parent().parent().parent().parent().parent().parent().removeClass('hidden');

                        $.each(response.data.addressed_to_opportunity_areas, function (key, value)
                        {
                            $('[data-modal="new_vox_report"]').find('[name="addressed_to_opportunity_areas[]"][value="' + value + '"]').prop('checked', true);
                        });
                    }

                    $.each(response.data.fields, function (key, value)
                    {
                        $('[data-modal="new_vox_report"]').find('[name="fields[]"][value="' + value + '"]').prop('checked', true);
                    });
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });

    $(document).on('click', '[data-action="delete_vox_report"]', function()
    {
        id = $(this).data('id');
        $('[data-modal="delete_vox_report"]').addClass('view');
    });

    $('[data-modal="delete_vox_report"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_vox_report',
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
