'use strict';

$(document).ready(function()
{
    $('[data-action="open-land-menu"]').on('click', function(e)
    {
        e.stopPropagation();
        $('header.landing-page nav > ul').toggleClass('open');
    });

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
        $('[name="rooms_number"]').val('');
        $('[name="tables_number"]').val('');
        $('[name="clients_number"]').val('');

        if ($(this).val() == 'hotel')
        {
            $('[name="rooms_number"]').parent().parent().removeClass('hidden');
            $('[name="tables_number"]').parent().parent().addClass('hidden');
            $('[name="clients_number"]').parent().parent().addClass('hidden');
        }
        else if ($(this).val() == 'restaurant')
        {
            $('[name="rooms_number"]').parent().parent().addClass('hidden');
            $('[name="tables_number"]').parent().parent().removeClass('hidden');
            $('[name="clients_number"]').parent().parent().addClass('hidden');
        }
        else if ($(this).val() == 'others')
        {
            $('[name="rooms_number"]').parent().parent().addClass('hidden');
            $('[name="tables_number"]').parent().parent().addClass('hidden');
            $('[name="clients_number"]').parent().parent().removeClass('hidden');
        }

        get_total();
    });

    $('[name="rooms_number"]').on('change', function()
    {
        get_total();
    });

    $('[name="tables_number"]').on('change', function()
    {
        get_total();
    });

    $('[name="clients_number"]').on('change', function()
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

    $('[name="logotype"]').parents('.uploader').find('a').on('click', function()
    {
        $('[name="logotype"]').click();
    });

    $('[name="logotype"]').on('change', function()
    {
        var preview = $(this).parents('.uploader').find('img');

        if ($(this)[0].files[0].type.match($(this).attr('accept')))
        {
            var reader = new FileReader();

            reader.onload = function(e)
            {
                preview.attr('src', e.target.result);
            }

            reader.readAsDataURL($(this)[0].files[0]);
        }
        else
        {
            $('[data-modal="error"]').addClass('view');
            $('[data-modal="error"]').find('main > p').html('ERROR FILE NOT PERMIT');
        }
    });

    var step;

    $('[data-action="go_to_step"]').on('click', function()
    {
        step = $(this).parent().data('step');
        $('form[name="signup"]').submit();
    });

    $('[data-modal="signup"]').modal().onCancel(function()
    {
        $('form[name="signup"]')[0].reset();
        $('fieldset.error').removeClass('error');
        $('[data-step]').removeClass('view');
        $('[data-step="1"]').addClass('view');
        $('[name="name"]').parent().parent().removeClass('span6');
        $('[name="name"]').parent().parent().addClass('span9');
        $('[name="rooms_number"]').parent().parent().addClass('hidden');
        $('[name="tables_number"]').parent().parent().addClass('hidden');
        $('[name="clients_number"]').parent().parent().addClass('hidden');
        $('[name="logotype"]').parents('.uploader').find('img').attr('src', '../images/empty.png');
        get_total();
    });

    $('form[name="signup"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);
        var data = new FormData(form[0]);

        data.append('step', step);
        data.append('action', 'go_to_step');

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
                        setTimeout(function() { location.reload(); }, 8000);
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
                    {
                        $('[data-modal="error"]').addClass('view');
                        $('[data-modal="error"]').find('main > p').html(response.message);
                    }
                }
            }
        });
    });

    $('[data-action="login"]').on('click', function()
    {
        $('form[name="login"]').submit();
    });

    $('[data-modal="login"]').modal().onCancel(function()
    {
        $('form[name="login"]')[0].reset();
        $('fieldset.error').removeClass('error');
    });

    $('form[name="login"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=login',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    window.location.href = '/dashboard';
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
            {
                $('[data-modal="error"]').addClass('view');
                $('[data-modal="error"]').find('main > p').html(response.message);
            }
        }
    });
}
