'use strict';

$(document).ready(function()
{
    var token = null;
    var id = null;

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
    });

    $('[name="opportunity_area"]').on('change', function()
    {
        $.ajax({
            type: 'POST',
            data: 'opportunity_area=' + $(this).val() + '&type=' + $('[name="type"]').val() + '&action=get_opt_opportunity_types',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[name="opportunity_type"]').html(response.html);

                    required_focus('input', $('[name="opportunity_type"]'), null);
                }
            }
        });
    });

    $('form[name="filter_voxes"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=filter_voxes',
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
