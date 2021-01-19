'use strict';

$(document).ready(function()
{
    $('[name="type"]').on('change', function()
    {
        // $.ajax({
        //     type: 'POST',
        //     data: 'type=' + $(this).val() + '&action=get_opt_owners',
        //     processData: false,
        //     cache: false,
        //     dataType: 'json',
        //     success: function(response)
        //     {
        //         if (response.status == 'success')
        //         {
        //             $('[name="owner"]').html(response.html);

        //             required_focus('input', $('[name="owner"]'), null);
        //         }
        //     }
        // });

        // $.ajax({
        //     type: 'POST',
        //     data: 'type=' + $(this).val() + '&action=get_opt_opportunity_areas',
        //     processData: false,
        //     cache: false,
        //     dataType: 'json',
        //     success: function(response)
        //     {
        //         if (response.status == 'success')
        //         {
        //             $('[name="opportunity_area"]').html(response.html);

        //             required_focus('input', $('[name="opportunity_area"]'), null);
        //         }
        //     }
        // });

        // $.ajax({
        //     type: 'POST',
        //     data: 'action=get_opt_opportunity_types',
        //     processData: false,
        //     cache: false,
        //     dataType: 'json',
        //     success: function(response)
        //     {
        //         if (response.status == 'success')
        //         {
        //             $('[name="opportunity_type"]').html(response.html);
        //             $('[name="opportunity_type"]').attr('disabled', true);

        //             required_focus('input', $('[name="opportunity_type"]'), null);
        //         }
        //     }
        // });

        // $.ajax({
        //     type: 'POST',
        //     data: 'type=' + $(this).val() + '&action=get_opt_locations',
        //     processData: false,
        //     cache: false,
        //     dataType: 'json',
        //     success: function(response)
        //     {
        //         if (response.status == 'success')
        //         {
        //             $('[name="location"]').html(response.html);

        //             required_focus('input', $('[name="location"]'), null);
        //         }
        //     }
        // });

        if ($(this).val() == 'voxes')
        {
            $('.surveys_chart_rate').addClass('hidden');
            $('.voxes_counters').removeClass('hidden');
            $('#voxes_table').removeClass('hidden');
            $('#orders_table').addClass('hidden');
            $('.tbl_stl_7').addClass('hidden');
        }
        else if ($(this).val() == 'menu_orders')
        {
            $('.surveys_chart_rate').addClass('hidden');
            $('.voxes_counters').addClass('hidden');
            $('#voxes_table').addClass('hidden');
            $('#orders_table').removeClass('hidden');
            $('.tbl_stl_7').addClass('hidden');
        }
        else if ($(this).val() == 'surveys_answers')
        {
            $('.surveys_chart_rate').removeClass('hidden');
            $('.voxes_counters').addClass('hidden');
            $('#voxes_table').addClass('hidden');
            $('#orders_table').addClass('hidden');
            $('.tbl_stl_7').removeClass('hidden');
        }
    });
});
