'use strict';

$(document).ready(function()
{
    $('[name="started_date"], [name="end_date"], [name="owner"]').on('change', function()
    {
        $(this).parents('form').submit();
    });

    // $('form[name="get_filter_survey_answer"]').on('submit', function(e)
    // {
    //     e.preventDefault();
    //
    //     $.ajax({
    //         type: 'POST',
    //         data: $(this).serialize() + '&action=get_filter_survey_answer',
    //         processData: false,
    //         cache: false,
    //         dataType: 'json',
    //         success: function(response)
    //         {
    //             if (response.status == 'success')
    //             {
    //                 tbl_survey_answers.clear();
    //                 $('#tbl_survey_answers').find('tbody').html(response.data);
    //             }
    //             else if (response.status == 'error')
    //             {
    //                 tbl_survey_answers.clear();
    //                 $('#tbl_survey_answers').find('tbody').html(response.data);
    //             }
    //         }
    //     });
    // });

    var id;

    $(document).on('click', '[data-action="view_survey_answer"]', function()
    {
        id = $(this).data('id');

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_survey_answer',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="view_survey_answer"]').addClass('view');
                    $('[data-modal="view_survey_answer"]').find('main').html(response.data);
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });
});
