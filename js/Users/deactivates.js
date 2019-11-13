'use strict';

$(document).ready(function()
{
    var id;

    $('.multi-tabs').multiTabs();

    $('#users_deactivate').DataTable({
        ordering: false,
        autoWidth: false,
        info: false,
    });

    $(document).on('click', '[data-action="activate_user"]', function()
    {
        id = $(this).data('id');

        $('[data-modal="activate_user"]').addClass('view');
    });

    $('[data-modal="activate_user"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=activate_user',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    $('[data-modal="success"]').addClass('view');

                    setTimeout(function() { location.reload(); }, 1500);
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
