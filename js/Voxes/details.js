'use strict';

$(document).ready(function()
{
    $('[data-modal="comment_vox"]').modal().onCancel(function()
    {
        $('[data-modal="comment_vox"]').find('[data-uploader] > [data-preview] > div').removeClass('active');
        $('[data-modal="comment_vox"]').find('[data-uploader] > [data-preview] > div > span > strong').val('0');

        clean_form($('[data-modal="comment_vox"]').find('form'));
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
