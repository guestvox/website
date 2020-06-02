'use strict';

$(document).ready(function()
{
    $('.chosen-select').chosen();

    var type = 'request';

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

        if (type == 'request')
        {
            $('[name="cost"]').parent().parent().parent().addClass('hidden');
            $('[name="confidentiality"]').parent().parent().parent().parent().addClass('hidden');
            $('[name="observations"]').parent().parent().parent().removeClass('hidden');
            $('[name="subject"]').parent().parent().parent().addClass('hidden');
            $('[name="description"]').parent().parent().parent().addClass('hidden');
            $('[name="action_taken"]').parent().parent().parent().addClass('hidden');
            $('[name="guest_treatment"]').parent().parent().parent().removeClass('hidden');
            $('[name="firstname"]').parent().parent().parent().removeClass('hidden');
            $('[name="lastname"]').parent().parent().parent().removeClass('hidden');
            $('[name="guest_id"]').parent().parent().parent().addClass('hidden');
            $('[name="guest_type"]').parent().parent().parent().addClass('hidden');
            $('[name="reservation_number"]').parent().parent().parent().addClass('hidden');
            $('[name="reservation_status"]').parent().parent().parent().addClass('hidden');
            $('[name="check_in"]').parent().parent().parent().addClass('hidden');
            $('[name="check_out"]').parent().parent().parent().addClass('hidden');
        }
        else if (type == 'incident')
        {
            $('[name="cost"]').parent().parent().parent().removeClass('hidden');
            $('[name="confidentiality"]').parent().parent().parent().parent().removeClass('hidden');
            $('[name="observations"]').parent().parent().parent().addClass('hidden');
            $('[name="subject"]').parent().parent().parent().removeClass('hidden');
            $('[name="description"]').parent().parent().parent().removeClass('hidden');
            $('[name="action_taken"]').parent().parent().parent().removeClass('hidden');
            $('[name="guest_treatment"]').parent().parent().parent().removeClass('hidden');
            $('[name="firstname"]').parent().parent().parent().removeClass('hidden');
            $('[name="lastname"]').parent().parent().parent().removeClass('hidden');
            $('[name="guest_id"]').parent().parent().parent().removeClass('hidden');
            $('[name="guest_type"]').parent().parent().parent().removeClass('hidden');
            $('[name="reservation_number"]').parent().parent().parent().removeClass('hidden');
            $('[name="reservation_status"]').parent().parent().parent().removeClass('hidden');
            $('[name="check_in"]').parent().parent().parent().removeClass('hidden');
            $('[name="check_out"]').parent().parent().parent().removeClass('hidden');
        }
        else if (type == 'workorder')
        {
            $('[name="cost"]').parent().parent().parent().removeClass('hidden');
            $('[name="confidentiality"]').parent().parent().parent().parent().addClass('hidden');
            $('[name="observations"]').parent().parent().parent().removeClass('hidden');
            $('[name="subject"]').parent().parent().parent().addClass('hidden');
            $('[name="description"]').parent().parent().parent().addClass('hidden');
            $('[name="action_taken"]').parent().parent().parent().addClass('hidden');
            $('[name="guest_treatment"]').parent().parent().parent().addClass('hidden');
            $('[name="firstname"]').parent().parent().parent().addClass('hidden');
            $('[name="lastname"]').parent().parent().parent().addClass('hidden');
            $('[name="guest_id"]').parent().parent().parent().addClass('hidden');
            $('[name="guest_type"]').parent().parent().parent().addClass('hidden');
            $('[name="reservation_number"]').parent().parent().parent().addClass('hidden');
            $('[name="reservation_status"]').parent().parent().parent().addClass('hidden');
            $('[name="check_in"]').parent().parent().parent().addClass('hidden');
            $('[name="check_out"]').parent().parent().parent().addClass('hidden');
        }
    });

    $('[name="owner"]').on('change', function()
    {
        if (type == 'request' || type == 'incident')
        {
            $.ajax({
                type: 'POST',
                data: 'owner=' + $(this).val() + '&action=get_owner',
                processData: false,
                cache: false,
                dataType: 'json',
                success: function(response)
                {
                    if (response.status == 'success')
                    {
                        if (type == 'request' || type == 'incident')
                        {
                            $('[name="firstname"]').val(response.data.firstname);
                            $('[name="lastname"]').val(response.data.lastname);
                        }

                        if (type == 'incident')
                        {
                            $('[name="reservation_number"]').val(response.data.reservation_number);
                            $('[name="check_in"]').val(response.data.check_in);
                            $('[name="check_out"]').val(response.data.check_out);
                        }
                    }
                    else if (response.status == 'error')
                        show_modal_error(response.message);
                }
            });
        }
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
                {
                    $('[name="opportunity_type"]').attr('disabled', false);
                    $('[name="opportunity_type"]').html(response.html);
                }
            }
        });
    });

    $('[data-action="edit_vox"]').on('click', function()
    {
        $('form[name="edit_vox"]').submit();
    });

    $('form[name="edit_vox"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);
        var data = new FormData(form[0]);

        data.append('action', 'edit_vox');

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
                    show_modal_success(response.message, 1500, response.path);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });
});
