'use strict';

$(document).ready(function()
{
    var tbl_survey_answers = $('#tbl_survey_answers').DataTable({
        ordering: false,
        pageLength: 25,
        info: false,
    });

    $('[name="tbl_survey_answers_search"]').on('keyup', function()
    {
        tbl_survey_answers.search(this.value).draw();
    });

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
