'use strict';

$(document).ready(function()
{
    $(document).on('click', '#rtsw, #cmsw, #ctsw', function()
    {
        window.location.href = '/surveys/answers/' + $(this).val();
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

    $('[data-action="print_survey_answer"]').on('click', function()
    {
        id = $(this).data('id');

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=print_survey_answer',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    var print = window.open(' ', 'popimpr');

                    print.document.write(response.html);
                    print.document.close();

                    print.print();
                    print.close();
                }
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('[data-action="public_survey_comment"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="public_survey_comment"]').addClass('view');
    });

    $('[data-modal="public_survey_comment"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=public_survey_comment',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 600);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="unpublic_survey_comment"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="unpublic_survey_comment"]').addClass('view');
    });

    $('[data-modal="unpublic_survey_comment"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=unpublic_survey_comment',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 600);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });
});
