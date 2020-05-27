'use strict';

$(document).ready(function()
{
    $('[name="path"]').on('keyup', function()
    {
        var filter = 'abcdefghijklmnñopqrstuvwxyz';
        var string = $(this).val();
        var out = '';

        for (var i = 0; i < string.length; i++)
        {
            if (filter.indexOf(string.charAt(i)) != -1)
                out += string.charAt(i);
        }

        $(this).val(out);

        if (out.length > 0)
            $(this).parent().find('span').find('strong').html(out);
        else
            $(this).parent().find('span').find('strong').html('micuenta');
    });

    $('[name="type"]').on('change', function()
    {
        $(this).parent().parent().removeClass('span6');
        $(this).parent().parent().addClass('span3');

        $('[name="quantity"]').val('');
        $('[name="quantity"]').parent().parent().removeClass('hidden');

        if ($(this).val() == 'hotel')
            $('[name="quantity"]').attr('placeholder', 'N. de habitaciones');
        else if ($(this).val() == 'restaurant')
            $('[name="quantity"]').attr('placeholder', 'N. de mesas');
        else if ($(this).val() == 'hospital')
            $('[name="quantity"]').attr('placeholder', 'N. de camas');
        else if ($(this).val() == 'others')
            $('[name="quantity"]').attr('placeholder', 'N. de clientes');

        get_total();
    });

    $('[name="quantity"]').on('change', function()
    {
        get_total();
    });

    $('[name="operation"]').on('change', function()
    {
        get_total();
    });

    $('[name="reputation"]').on('change', function()
    {
        get_total();
    });

    var step;

    $('[data-action="next"]').on('click', function()
    {
        step = $(this).parent().data('step');

        $('form[name="signup"]').submit();
    });

    $('form[name="signup"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);
        var data = new FormData(form[0]);

        data.append('step', step);
        data.append('action', 'next');

        $.ajax({
            type: 'POST',
            data: data,
            contentType: false,
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    step = step + 1;

                    $('[data-step]').removeClass('view');
                    $('[data-step="' + step + '"]').addClass('view');

                    if (step == 6)
                    {
                        $('#success').html(response.message);
                        setTimeout(function() { window.location.href = response.path; }, 8000);
                    }
                }
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
                        show_modal_error(response.message);
                }
            }
        });
    });
});

function get_total()
{
    var data = new FormData($('form[name="signup"]')[0]);

    data.append('action', 'get_total');

    $.ajax({
        type: 'POST',
        data: data,
        contentType: false,
        processData: false,
        cache: false,
        dataType: 'json',
        success: function(response)
        {
            if (response.status == 'success')
            {
                $('#operation').find('h4 > span').html(response.data.price.operation);
                $('#reputation').find('h4 > span').html(response.data.price.reputation);
                $('#total').find('h4 > span').html(response.data.total);
            }
            else if (response.status == 'error')
                show_modal_error(response.message);
        }
    });
}
