'use strict';

$(document).ready(function()
{
    var id = null;

    $('[data-action="preview_survey_answer"]').on('click', function()
    {
        id = $(this).data('id');

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=preview_survey_answer',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="preview_survey_answer"]').find('main').find('.survey_answer_preview').html(response.html);
                    $('[data-modal="preview_survey_answer"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('form[name="filter_surveys_answers"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=filter_surveys_answers',
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
