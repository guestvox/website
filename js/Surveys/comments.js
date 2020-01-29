'use strict';

$(document).ready(function()
{
    var tbl_survey_comments = $('#tbl_survey_comments').DataTable({
        ordering: false,
        pageLength: 25,
        info: false,
    });

    $('[name="tbl_survey_comments_search"]').on('keyup', function()
    {
        tbl_survey_comments.search(this.value).draw();
    });

});
