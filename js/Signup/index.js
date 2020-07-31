'use strict';

$(document).ready(function()
{
    $(document).on('keyup', '[name="name"], [name="path"]', function()
    {
        var string = $(this).val().normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
        var filter = 'abcdefghijklmnñopqrstuvwxyz0123456789';
        var out = '';

        for (var i = 0; i < string.length; i++)
        {
            if (filter.indexOf(string.charAt(i)) != -1)
                out += string.charAt(i);
        }

        $('[name="path"]').val(out);

        if (out.length > 0)
            $('[name="path"]').parent().find('span').find('strong').html(out);
        else
            $('[name="path"]').parent().find('span').find('strong').html('micuenta');
    });

    $('[name="type"]').on('change', function()
    {
        $('[name="rooms_number"]').val('');

        if ($(this).val() == 'hotel')
        {
            $(this).parent().parent().removeClass('span6').addClass('span3');
            $('[name="rooms_number"]').parent().parent().removeClass('hidden');
        }
        else
        {
            $(this).parent().parent().removeClass('span3').addClass('span6');
            $('[name="rooms_number"]').parent().parent().addClass('hidden');
        }
    });

    $(document).on('change', '[name="type"], [name="rooms_number"], [name="operation"], [name="reputation"]', function()
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

                    if (step == 4)
                    {
                        $('#success').html(response.message);

                        setTimeout(function() { window.location.href = response.path; }, 8000);
                    }
                }
                else if (response.status == 'error')
                {
                    if (response.labels)
                    {
                        console.log(response.labels);

                        form.find('.error').removeClass('error');

                        $.each(response.labels, function(i, label)
                        {
                            form.find('[name="' + label[0] + '"]').parent().addClass('error');
                        });

                        form.find('.error [name]')[0].focus();
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
