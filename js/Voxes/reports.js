'use strict';

$(document).ready(function ()
{
    $(document).on('click', '#sasw, #gesw', function()
    {
        window.location.href = '/voxes/reports/' + $(this).val();
    });

    var id = null;
    var edit = false;
    var type = '';

    $('[name="type"]').on('change', function()
    {
        type = $(this).val();

        $.ajax({
            type: 'POST',
            data: 'type=' + type + '&action=get_opt_owners',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    $('[name="owner"]').html(response.html);
            }
        });

        $.ajax({
            type: 'POST',
            data: 'type=' + type + '&action=get_opt_opportunity_areas',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    $('[name="opportunity_area"]').html(response.html);
            }
        });

        $.ajax({
            type: 'POST',
            data: 'action=get_opt_opportunity_types',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    $('[name="opportunity_type"]').html(response.html);
            }
        });

        $.ajax({
            type: 'POST',
            data: 'type=' + type + '&action=get_opt_locations',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    $('[name="location"]').html(response.html);
            }
        });

        $.ajax({
            type: 'POST',
            data: 'type=' + type + '&action=get_cbx_opportunity_areas',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    $('[name="opportunity_areas[]"]').parent().parent().html(response.html);
            }
        });

        $.ajax({
            type: 'POST',
            data: 'type=' + type + '&action=get_cbx_vox_report_fields',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    $('[name="fields[]"]').parent().parent().html(response.html);
            }
        });
    });

    $('[name="opportunity_area"]').on('change', function()
    {
        $.ajax({
            type: 'POST',
            data: 'opportunity_area=' + $(this).val() + '&type=' + type + '&action=get_opt_opportunity_types',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    $('[name="opportunity_type"]').html(response.html);
            }
        });
    });

    $('[name="addressed_to"]').on('change', function()
    {
        if ($(this).val() == 'opportunity_areas')
            $('[name="opportunity_areas[]"]').parents('.checkboxes').parent().parent().removeClass('hidden');
        else
            $('[name="opportunity_areas[]"]').parents('.checkboxes').parent().parent().addClass('hidden');
    });

    $('[data-modal="new_vox_report"]').modal().onCancel(function()
    {
        id = null;
        edit = false;

        clean_form($('[data-modal="new_vox_report"]').find('form'));
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
                    show_modal_success(response.message, 1500);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('[data-action="edit_vox_report"]').on('click', function()
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
                    console.log(response.data);

                    $('[data-modal="new_vox_report"]').addClass('view');

                    $('[data-modal="new_vox_report"]').find('[name="name"]').val(response.data.name);
                    $('[data-modal="new_vox_report"]').find('[name="type"]').val(response.data.type);
                    $('[data-modal="new_vox_report"]').find('[name="owner"]').val(response.data.owner);
                    $('[data-modal="new_vox_report"]').find('[name="opportunity_area"]').val(response.data.opportunity_area);
                    $('[data-modal="new_vox_report"]').find('[name="opportunity_type"]').val(response.data.opportunity_type);
                    $('[data-modal="new_vox_report"]').find('[name="location"]').val(response.data.location);
                    $('[data-modal="new_vox_report"]').find('[name="order"]').val(response.data.order);
                    $('[data-modal="new_vox_report"]').find('[name="time_period"]').val(response.data.time_period);
                    $('[data-modal="new_vox_report"]').find('[name="addressed_to"]').val(response.data.addressed_to);

                    if (response.data.addressed_to == 'opportunity_areas')
                    {
                        $('[data-modal="new_vox_report"]').find('[name="opportunity_areas[]"]').parents('.checkboxes').parent().parent().removeClass('hidden');

                        $.each(response.data.opportunity_areas, function (key, value)
                        {
                            $('[data-modal="new_vox_report"]').find('[name="opportunity_areas[]"][value="' + value + '"]').prop('checked', true);
                        });
                    }

                    $.each(response.data.fields, function (key, value)
                    {
                        $('[data-modal="new_vox_report"]').find('[name="fields[]"][value="' + value + '"]').prop('checked', true);
                    });

                    required_focus($('[data-modal="new_vox_report"]').find('form'), true);
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="deactivate_vox_report"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="deactivate_vox_report"]').addClass('view');
    });

    $('[data-modal="deactivate_vox_report"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=deactivate_vox_report',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 1500);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="activate_vox_report"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="activate_vox_report"]').addClass('view');
    });

    $('[data-modal="activate_vox_report"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=activate_vox_report',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 1500);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="delete_vox_report"]').on('click', function()
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
                    show_modal_success(response.message, 1500);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });
});
