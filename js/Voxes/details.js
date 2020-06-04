'use strict';

$(document).ready(function()
{
    $('[data-modal="comment_vox"]').modal().onCancel(function()
    {
        clean_form($('form[name="comment_vox"]'));
    });

    $('form[name="comment_vox"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=comment_vox',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 1500);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('[data-modal="complete_vox"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'action=complete_vox',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 1500);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-modal="reopen_vox"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'action=reopen_vox',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 1500);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });
});
