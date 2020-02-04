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
}
