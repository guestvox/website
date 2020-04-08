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

    $('[name="started_date"], [name="end_date"], [name="room"]').on('change', function()
    {
        $(this).parents('form').submit();
    });

    $('form[name="get_filter_survey_contacts"]').on('submit', function(e)
    {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            data: $(this).serialize() + '&action=get_filter_survey_contacts',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    tbl_survey_contacts.clear();
                    $('#tbl_survey_contacts').find('tbody').html(response.data);
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
