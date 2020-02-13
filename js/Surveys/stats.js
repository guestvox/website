'use strict';

$(document).ready(function()
{
    $('[name="started_date"]').on('change', function()
    {
        $(this).parents('form').submit();
    });

    $('[name="end_date"]').on('change', function()
    {
        $(this).parents('form').submit();
    });

    $('form[name="get_charts_by_date_filter"]').on('submit', function(e)
    {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            data: $(this).serialize() + '&action=get_charts_by_date_filter',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                update_charts_by_date_filter(response);
            }
        });
    });
});

function update_charts_by_date_filter(response)
{
    s1_chart.data.labels = response.data.s1_chart_data.labels;
    s1_chart.data.datasets[0].data = response.data.s1_chart_data.datasets.data;
    s1_chart.data.datasets[0].backgroundColor = response.data.s1_chart_data.datasets.colors;
    s1_chart.update();

    s2_chart.data.labels = response.data.s2_chart_data.labels;
    s2_chart.data.datasets = response.data.s2_chart_data.datasets;
    s2_chart.update();

    s5_chart.data.labels = response.data.s5_chart_data.labels;
    s5_chart.data.datasets[0].data = response.data.s5_chart_data.datasets.data;
    s5_chart.data.datasets[0].backgroundColor = response.data.s5_chart_data.datasets.colors;
    s5_chart.update();

    s6_chart.data.labels = response.data.s6_chart_data.labels;
    s6_chart.data.datasets[0].data = response.data.s6_chart_data.datasets.data;
    s6_chart.data.datasets[0].backgroundColor = response.data.s6_chart_data.datasets.colors;
    s6_chart.update();

    s7_chart.data.labels = response.data.s7_chart_data.labels;
    s7_chart.data.datasets[0].data = response.data.s7_chart_data.datasets.data;
    s7_chart.data.datasets[0].backgroundColor = response.data.s7_chart_data.datasets.colors;
    s7_chart.update();

    s8_chart.data.labels = response.data.s8_chart_data.labels;
    s8_chart.data.datasets[0].data = response.data.s8_chart_data.datasets.data;
    s8_chart.data.datasets[0].backgroundColor = response.data.s8_chart_data.datasets.colors;
    s8_chart.update();
}
