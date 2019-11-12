'use strict';

$(document).ready(function()
{
    var id;
    var key;

    $('.multi-tabs').multiTabs();

    var tbl_survey_answers = $('#tbl_survey_answers').DataTable({
        ordering: false,
        autoWidth: false,
        pageLength: 25,
        info: false,
    });

    $(document).on('click','[data-action="get_survey_answers"]', function()
    {
        id = $(this).data('id');

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_survey_answers',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="view_survey_answers"]').find('main').html(response.data);
                    $('[data-modal="view_survey_answers"]').addClass('view');
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').find('main > p').html(response.message);
                    $('[data-modal="error"]').addClass('view');
                }
            }
        });
    });
});
