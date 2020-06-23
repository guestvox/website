'use strict';

$(document).ready(function()
{
    navScrollDown('main.surveys-stats > article > main > form.charts-filter', 'down', 60);

    $('[name="started_date"], [name="end_date"], [name="question"]').on('change', function()
    {
        $(this).parents('form').submit();
    });

    $('[data-action="view_all"]').on('click', function(e)
    {
        $(this).parents('form').submit();
    });

    $('form[name="get_view_all"]').on('submit', function(e)
    {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            data: $(this).serialize() + '&action=get_view_all',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                $('.chart-rate').find('h2').html('Valoración general | Total');

                $('.average').html(response.data.rate_general);

                $('#progress_five').find('progress').attr('value', response.data.five_percentage_rate);
                $('#progress_five').find('span:last-child').text(response.data.five_percentage_rate + '%');

                $('#progress_four').find('progress').attr('value', response.data.four_percentage_rate);
                $('#progress_four').find('span:last-child').text(response.data.four_percentage_rate + '%');

                $('#progress_tree').find('progress').attr('value', response.data.tree_percentage_rate);
                $('#progress_tree').find('span:last-child').text(response.data.tree_percentage_rate + '%');

                $('#progress_two').find('progress').attr('value', response.data.two_percentage_rate);
                $('#progress_two').find('span:last-child').text(response.data.two_percentage_rate + '%');

                $('#progress_one').find('progress').attr('value', response.data.one_percentage_rate);
                $('#progress_one').find('span:last-child').text(response.data.one_percentage_rate + '%');

            }
        });
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
                $('.average').html(response.data.rate_general);

                $('#progress_five').find('progress').attr('value', response.data.five_percentage_rate);
                $('#progress_five').find('span:last-child').text(response.data.five_percentage_rate + '%');

                $('#progress_four').find('progress').attr('value', response.data.four_percentage_rate);
                $('#progress_four').find('span:last-child').text(response.data.four_percentage_rate + '%');

                $('#progress_tree').find('progress').attr('value', response.data.tree_percentage_rate);
                $('#progress_tree').find('span:last-child').text(response.data.tree_percentage_rate + '%');

                $('#progress_two').find('progress').attr('value', response.data.two_percentage_rate);
                $('#progress_two').find('span:last-child').text(response.data.two_percentage_rate + '%');

                $('#progress_one').find('progress').attr('value', response.data.one_percentage_rate);
                $('#progress_one').find('span:last-child').text(response.data.one_percentage_rate + '%');

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

    try {

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

    } catch (e) {}
}
