'use strict';

$(document).ready(function()
{
    $('[data-action="get_filter"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'filter=' + $(this).data('filter') + '&action=get_filter',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    location.reload();
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });
});
