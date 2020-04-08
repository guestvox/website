'use strict';

$(document).ready(function()
{
    var id;

    var tbl_survey_comments = $('#tbl_survey_comments').DataTable({
        ordering: false,
        pageLength: 25,
        info: false
    });

    $('[name="started_date"], [name="end_date"], [name="room"]').on('change', function()
    {
        $(this).parents('form').submit();
    });

    $('[name="tbl_survey_comments_search"]').on('keyup', function()
    {
        tbl_survey_comments.search(this.value).draw();
    });

    $('form[name="get_filter_survey_comments"]').on('submit', function(e)
    {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            data: $(this).serialize() + '&action=get_filter_survey_comments',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    tbl_survey_comments.clear();
                    $('#tbl_survey_comments').find('tbody').html(response.data);
                }
                else if (response.status == 'error')
                {
                    tbl_survey_comments.clear();
                    $('#tbl_survey_comments').find('tbody').html(response.data);
                }
            }
        });
    });

    $(document).on('click', '[data-action="deactivate_comment"]', function()
    {
        id = $(this).data('id');
        $('[data-modal="deactivate_comment"]').addClass('view');
    });

    $('[data-modal="deactivate_comment"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=deactivate_comment',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="success"]').addClass('view');
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    setTimeout(function() { location.reload(); }, 1500);
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });

    $(document).on('click', '[data-action="activate_comment"]', function()
    {
        id = $(this).data('id');
        $('[data-modal="activate_comment"]').addClass('view');
    });

    $('[data-modal="activate_comment"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=activate_comment',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="success"]').addClass('view');
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    setTimeout(function() { location.reload(); }, 1500);
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
