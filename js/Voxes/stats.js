'use strict';

$(document).ready(function()
{
    var action = '';

    $('[name="started_date"]').on('change', function()
    {
        $(this).parents('form').submit();
    });

    $('[name="date_end"]').on('change', function()
    {
        $(this).parents('form').submit();
    });

    $('[name="type"]').on('change', function()
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

        try {

            v_r_chart.data.datasets[0].data = response.data.r.datasets.data;
            v_r_chart.update();

            v_t_chart.data.datasets[0].data = response.data.t.datasets.data;
            v_t_chart.update();

        } catch (e) { }

        v_l_chart.data.datasets[0].data = response.data.l.datasets.data;
        v_l_chart.update();
    }
    else if (action == 'get_ar_chart_data')
    {
        ar_oa_chart.data.datasets[0].data = response.data.oa.datasets.data;
        ar_oa_chart.update();

        try {

            ar_r_chart.data.datasets[0].data = response.data.r.datasets.data;
            ar_r_chart.update();

            ar_t_chart.data.datasets[0].data = response.data.t.datasets.data;
            ar_t_chart.update();

        } catch (e) { }

        ar_l_chart.data.datasets[0].data = response.data.l.datasets.data;
        ar_l_chart.update();
    }
    else if (action == 'get_c_chart_data')
    {
        c_oa_chart.data.datasets[0].data = response.data.oa.datasets.data;
        c_oa_chart.update();

        try {

            c_r_chart.data.datasets[0].data = response.data.r.datasets.data;
            c_r_chart.update();

            c_t_chart.data.datasets[0].data = response.data.t.datasets.data;
            c_t_chart.update();

        } catch (e) { }

        c_l_chart.data.datasets[0].data = response.data.l.datasets.data;
        c_l_chart.update();
    }
}
