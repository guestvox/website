'use strict';

$(document).ready(function()
{
    var action = '';

    $(document).on('change', '[name="started_date"], [name="date_end"], [name="type"]', function()
    {
        $(this).parents('form').submit();
    });

    $('form[name="get_v_chart_data"]').on('submit', function(e)
    {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            data: $(this).serialize() + '&action=get_v_chart_data',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                update_chart_data('get_v_chart_data', response);
            }
        });
    });

    $('form[name="get_ar_chart_data"]').on('submit', function(e)
    {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            data: $(this).serialize() + '&action=get_ar_chart_data',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                update_chart_data('get_ar_chart_data', response);
            }
        });
    });

    $('form[name="get_c_chart_data"]').on('submit', function(e)
    {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            data: $(this).serialize() + '&action=get_c_chart_data',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                update_chart_data('get_c_chart_data', response);
            }
        });
    });
});

function update_chart_data(action, response)
{
    if (action == 'get_v_chart_data')
    {
        v_oa_chart.data.datasets[0].data = response.data.oa.datasets.data;
        v_oa_chart.update();

        v_o_chart.data.datasets[0].data = response.data.o.datasets.data;
        v_o_chart.update();

        v_l_chart.data.datasets[0].data = response.data.l.datasets.data;
        v_l_chart.update();
    }
    else if (action == 'get_ar_chart_data')
    {
        ar_oa_chart.data.datasets[0].data = response.data.oa.datasets.data;
        ar_oa_chart.update();

        ar_o_chart.data.datasets[0].data = response.data.o.datasets.data;
        ar_o_chart.update();

        ar_l_chart.data.datasets[0].data = response.data.l.datasets.data;
        ar_l_chart.update();
    }
    else if (action == 'get_c_chart_data')
    {
        c_oa_chart.data.datasets[0].data = response.data.oa.datasets.data;
        c_oa_chart.update();

        c_o_chart.data.datasets[0].data = response.data.o.datasets.data;
        c_o_chart.update();

        c_l_chart.data.datasets[0].data = response.data.l.datasets.data;
        c_l_chart.update();
    }
}
