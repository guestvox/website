'use strict';

$(document).ready(function()
{
    $('[name="search"]').on('change', function()
    {
        if ($(this).val() == 'period')
        {
            $('[name="period_type"]').parent().parent().parent().removeClass('hidden');
            $('[name="period_number"]').parent().parent().parent().removeClass('hidden');
            $('[name="started_date"]').parent().parent().parent().addClass('hidden');
            $('[name="end_date"]').parent().parent().parent().addClass('hidden');
        }
        else if ($(this).val() == 'date')
        {
            $('[name="period_type"]').parent().parent().parent().addClass('hidden');
            $('[name="period_number"]').parent().parent().parent().addClass('hidden');
            $('[name="started_date"]').parent().parent().parent().removeClass('hidden');
            $('[name="end_date"]').parent().parent().parent().removeClass('hidden');
        }
    });

    $('form[name="filter_surveys_reports"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=filter_surveys_reports',
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

    $('form[name="send_survey_report"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=send_survey_report',
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
