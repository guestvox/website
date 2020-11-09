'use strict';

$(document).ready(function()
{
    var id = null;
    var edit = false;

    $('[data-action="change_account"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="change_account"]').addClass('view');
    });

    $('[data-modal="change_account"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=change_account',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    show_modal_success(response.message, 600);
                }
            }
        });
    });

});