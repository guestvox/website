'use strict';

$(document).ready(function()
{
    $('form[name="login"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize(),
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    window.location.href = response.path;
                else if (response.status == 'error')
                {
                    if (response.labels)
                    {
                        form.find('fieldset.error').removeClass('error');

                        $.each(response.labels, function(i, label)
                        {
                            form.find('[name="' + label[0] + '"]').parents('fieldset').addClass('error');
                        });

                        form.find('fieldset.error [name]')[0].focus();
                    }
                    else if (response.message)
                    {
                        $('[data-modal="error"]').addClass('view');
                        $('[data-modal="error"]').find('main > p').html(response.message);
                    }
                }
            }
        });
    });
});
