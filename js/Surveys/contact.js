'use strict';

$(document).ready(function()
{
    var tbl_survey_contact_information = $('#tbl_survey_contact_information').DataTable({
        ordering: false,
        pageLength: 25,
        info: false,
    });

    $('[name="tbl_survey_contact_information_search"]').on('keyup', function()
    {
        tbl_survey_contact_information.search(this.value).draw();
    });

});
