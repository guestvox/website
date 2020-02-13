'use strict';

$(document).ready(function()
{
    var tbl_survey_contacts = $('#tbl_survey_contacts').DataTable({
        ordering: false,
        pageLength: 25,
        info: false
    });

    $('[name="tbl_survey_contacts_search"]').on('keyup', function()
    {
        tbl_survey_contacts.search(this.value).draw();
    });
});
