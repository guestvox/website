'use strict';

$(document).ready(function()
{
    $(document).on('click', '#sasw, #gesw', function()
    {
        window.location.href = '/voxes/reports/' + $(this).val();
    });

    var id = null;
    var edit = false;
    var type = 'all';

    $('[data-modal="new_vox_report"]').find('[name="type"]').on('change', function()
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
                {
                    $('[data-modal="new_vox_report"]').find('[name="owner"]').html(response.html);

                    required_focus('input', $('[data-modal="new_vox_report"]').find('[name="owner"]'), null);
                }
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
                {
                    $('[data-modal="new_vox_report"]').find('[name="opportunity_area"]').html(response.html);

                    required_focus('input', $('[data-modal="new_vox_report"]').find('[name="opportunity_area"]'), null);
                }
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
                {
                    $('[data-modal="new_vox_report"]').find('[name="opportunity_type"]').html(response.html);

                    required_focus('input', $('[data-modal="new_vox_report"]').find('[name="opportunity_type"]'), null);
                }
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
                {
                    $('[data-modal="new_vox_report"]').find('[name="location"]').html(response.html);

                    required_focus('input', $('[data-modal="new_vox_report"]').find('[name="location"]'), null);
                }
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
                    $('[data-modal="new_vox_report"]').find('[name="opportunity_areas[]"]').parent().parent().html(response.html);
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
                    $('[data-modal="new_vox_report"]').find('[name="fields[]"]').parent().parent().html(response.html);
            }
        });
    });

    $('[data-modal="new_vox_report"]').find('[name="opportunity_area"]').on('change', function()
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
                {
                    $('[data-modal="new_vox_report"]').find('[name="opportunity_type"]').html(response.html);

                    required_focus('input', $('[data-modal="new_vox_report"]').find('[name="opportunity_type"]'), null)
                }
            }
        });
    });

    $('[data-modal="new_vox_report"]').find('[name="addressed_to"]').on('change', function()
    {
        if ($(this).val() == 'opportunity_areas')
            $('[data-modal="new_vox_report"]').find('[name="opportunity_areas[]"]').parents('.checkboxes').parent().parent().removeClass('hidden');
        else
            $('[data-modal="new_vox_report"]').find('[name="opportunity_areas[]"]').parents('.checkboxes').parent().parent().addClass('hidden');
    });

    $('[data-modal="new_vox_report"]').modal().onCancel(function()
    {
        id = null;
        edit = false;

        $('[data-modal="new_vox_report"]').find('[name="opportunity_areas[]"]').parents('.checkboxes').parent().parent().addClass('hidden');

        clean_form($('form[name="new_vox_report"]'));
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
            success: function(response1)
            {
                if (response1.status == 'success')
                {
                    $('[data-modal="new_vox_report"]').find('[name="name"]').val(response1.data.name);
                    $('[data-modal="new_vox_report"]').find('[name="type"]').val(response1.data.type);
                    $('[data-modal="new_vox_report"]').find('[name="owner"]').val(response1.data.owner);
                    $('[data-modal="new_vox_report"]').find('[name="opportunity_area"]').val(response1.data.opportunity_area);

                    $.ajax({
                        type: 'POST',
                        data: 'opportunity_area=' + response1.data.opportunity_area + '&type=' + type + '&action=get_opt_opportunity_types',
                        processData: false,
                        cache: false,
                        dataType: 'json',
                        success: function(response2)
                        {
                            if (response2.status == 'success')
                            {
                                $('[data-modal="new_vox_report"]').find('[name="opportunity_type"]').html(response2.html);
                                $('[data-modal="new_vox_report"]').find('[name="opportunity_type"]').val(response1.data.opportunity_type);

                                required_focus('input', $('[data-modal="new_vox_report"]').find('[name="opportunity_type"]'), null);
                            }
                            else if (response2.status == 'error')
                                show_modal_error(response2.message);
                        }
                    });

                    $('[data-modal="new_vox_report"]').find('[name="location"]').val(response1.data.location);
                    $('[data-modal="new_vox_report"]').find('[name="order"]').val(response1.data.order);
                    $('[data-modal="new_vox_report"]').find('[name="time_period_type"]').val(response1.data.time_period.type);
                    $('[data-modal="new_vox_report"]').find('[name="time_period_number"]').val(response1.data.time_period.number);
                    $('[data-modal="new_vox_report"]').find('[name="addressed_to"]').val(response1.data.addressed_to);

                    if (response1.data.addressed_to == 'opportunity_areas')
                    {
                        $('[data-modal="new_vox_report"]').find('[name="opportunity_areas[]"]').parents('.checkboxes').parent().parent().removeClass('hidden');

                        $.each(response1.data.opportunity_areas, function (key, value)
                        {
                            $('[data-modal="new_vox_report"]').find('[name="opportunity_areas[]"][value="' + value + '"]').prop('checked', true);
                        });
                    }

                    $.each(response1.data.fields, function (key, value)
                    {
                        $('[data-modal="new_vox_report"]').find('[name="fields[]"][value="' + value + '"]').prop('checked', true);
                    });

                    required_focus('form', $('form[name="new_vox_report"]'), null);

                    $('[data-modal="new_vox_report"]').addClass('view');
                }
                else if (response1.status == 'error')
                    show_modal_error(response1.message);
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

    // var filter_vox_report = $('[data-modal="filter_vox_report"]');
    //
    // filter_vox_report.find('[name="report"]').on('change', function()
    // {
    //     $.ajax({
    //         type: 'POST',
    //         data: 'id=' + $(this).val() + '&action=get_vox_report',
    //         processData: false,
    //         cache: false,
    //         dataType: 'json',
    //         success: function(response1)
    //         {
    //             if (response1.status == 'success')
    //             {
    //                 $('[data-modal="new_vox_report"]').find('[name="type"]').val(response1.data.type);
    //                 $('[data-modal="new_vox_report"]').find('[name="owner"]').val(response1.data.owner);
    //                 $('[data-modal="new_vox_report"]').find('[name="opportunity_area"]').val(response1.data.opportunity_area);
    //
    //                 $.ajax({
    //                     type: 'POST',
    //                     data: 'opportunity_area=' + response1.data.opportunity_area + '&type=' + response1.data.type + '&action=get_opt_opportunity_types',
    //                     processData: false,
    //                     cache: false,
    //                     dataType: 'json',
    //                     success: function(response2)
    //                     {
    //                         if (response2.status == 'success')
    //                         {
    //                             $('[data-modal="new_vox_report"]').find('[name="opportunity_type"]').html(response2.html);
    //                             $('[data-modal="new_vox_report"]').find('[name="opportunity_type"]').val(response1.data.opportunity_type);
    //
    //                             required_focus('input', $('form[name="new_vox_report"]').find('[name="opportunity_type"]'), null);
    //                         }
    //                         else if (response2.status == 'error')
    //                             show_modal_error(response2.message);
    //                     }
    //                 });
    //
    //                 $('[data-modal="new_vox_report"]').find('[name="location"]').val(response1.data.location);
    //                 $('[data-modal="new_vox_report"]').find('[name="order"]').val(response1.data.order);
    //                 $('[data-modal="new_vox_report"]').find('[name="time_period_type"]').val(response1.data.time_period.type);
    //                 $('[data-modal="new_vox_report"]').find('[name="time_period_number"]').val(response1.data.time_period.number);
    //                 $('[data-modal="new_vox_report"]').find('[name="addressed_to"]').val(response1.data.addressed_to);
    //
    //                 if (response1.data.addressed_to == 'opportunity_areas')
    //                 {
    //                     $('[data-modal="new_vox_report"]').find('[name="opportunity_areas[]"]').parents('.checkboxes').parent().parent().removeClass('hidden');
    //
    //                     $.each(response1.data.opportunity_areas, function (key, value)
    //                     {
    //                         $('[data-modal="new_vox_report"]').find('[name="opportunity_areas[]"][value="' + value + '"]').prop('checked', true);
    //                     });
    //                 }
    //
    //                 $.each(response1.data.fields, function (key, value)
    //                 {
    //                     $('[data-modal="new_vox_report"]').find('[name="fields[]"][value="' + value + '"]').prop('checked', true);
    //                 });
    //
    //                 required_focus('form', $('form[name="new_vox_report"]'), null);
    //
    //                 $('[data-modal="new_vox_report"]').addClass('view');
    //             }
    //             else if (response1.status == 'error')
    //                 show_modal_error(response1.message);
    //         }
    //     });
    // });
});
