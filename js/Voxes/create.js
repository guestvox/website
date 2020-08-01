'use strict';

$(document).ready(function()
{
    $('.chosen-select').chosen();

    $('[name="type"]').on('change', function()
    {
        $.ajax({
            type: 'POST',
            data: 'type=' + $(this).val() + '&action=get_opt_owners',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[name="owner"]').html(response.html);

                    required_focus('input', $('[name="owner"]'), null);
                }
            }
        });

        $.ajax({
            type: 'POST',
            data: 'type=' + $(this).val() + '&action=get_opt_opportunity_areas',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[name="opportunity_area"]').html(response.html);

                    required_focus('input', $('[name="opportunity_area"]'), null);
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
                    $('[name="opportunity_type"]').html(response.html);
                    $('[name="opportunity_type"]').attr('disabled', true);

                    required_focus('input', $('[name="opportunity_type"]'), null);
                }
            }
        });

        $.ajax({
            type: 'POST',
            data: 'type=' + $(this).val() + '&action=get_opt_locations',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[name="location"]').html(response.html);

                    required_focus('input', $('[name="location"]'), null);
                }
            }
        });

        if ($(this).val() == 'request')
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
        else if ($(this).val() == 'incident')
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
        else if ($(this).val() == 'workorder')
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
        if ($('[name="type"]:checked').val() == 'request' || $('[name="type"]:checked').val() == 'incident')
        {
            $.ajax({
                type: 'POST',
                data: 'owner=' + $(this).val() + '&action=get_reservation',
                processData: false,
                cache: false,
                dataType: 'json',
                success: function(response)
                {
                    if (response.status == 'success')
                    {
                        $('[name="firstname"]').val(response.data.firstname);
                        $('[name="lastname"]').val(response.data.lastname);

                        required_focus('names', $('form[name="new_vox"]'), [
                            'firstname',
                            'lastname'
                        ]);

                        if ($('[name="type"]:checked').val() == 'incident')
                        {
                            $('[name="guest_id"]').val(response.data.guest_id);
                            $('[name="reservation_number"]').val(response.data.reservation_number);
                            $('[name="check_in"]').val(response.data.check_in);
                            $('[name="check_out"]').val(response.data.check_out);

                            required_focus('names', $('form[name="new_vox"]'), [
                                'guest_id',
                                'reservation_number',
                                'check_in',
                                'check_out'
                            ]);
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
            data: 'opportunity_area=' + $(this).val() + '&type=' + $('[name="type"]:checked').val() + '&action=get_opt_opportunity_types',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[name="opportunity_type"]').html(response.html);
                    $('[name="opportunity_type"]').attr('disabled', false);

                    required_focus('input', $('[name="opportunity_type"]'), null);
                }
            }
        });
    });

    $('[data-action="new_vox"]').on('click', function()
    {
        $('form[name="new_vox"]').submit();
    });

    $('form[name="new_vox"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);
        var data = new FormData(form[0]);

        data.append('action', 'new_vox');

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
                    show_modal_success(response.message, 600, response.path);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });
});
