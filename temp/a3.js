'use strict';

$(document).ready(function()
{
    $('.fancybox-thumb').fancybox({
        prevEffect	: "none",
        nextEffect	: "none",
        helpers	:
        {
            thumbs	:
            {
                width	: 50,
                height	: 50
            }
        }
    });

    $('.fancybox-media').fancybox({
        openEffect  : "elastic",
        closeEffect : "none",
        helpers :
        {
            media : {}
        }
    });

    $('[data-elapsed-time]').each(function()
    {
        get_time_elapsed($(this).data('date-1').replace(/-/g, '/'), $(this).data('date-2').replace(/-/g, '/'), $(this).data('time-zone'), $(this).data('status'), $(this).find('span'));
    });

    $(document).on('change', '[important] [name]', function()
    {
        if ($(this).val() != '')
        {
            $(this).parents('label').addClass('success');
            $(this).parents('label.error').removeClass('error');
            $(this).parents('label').find('p.error').remove();
        }
        else
            $(this).parents('label').removeClass('success');
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
                {
                    $('[data-modal="success"]').addClass('view');
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    setTimeout(function() { window.location.href = '/voxes'; }, 1500);
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
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

    var response_to = '';

    $('[data-button-modal="new_vox_comment"]').on('click', function()
    {
        var name = $(this).attr('value');

        if (name == 'incident' || name == 'workorder')
            $('[data-modal="new_vox_comment"]').find('#cost').show();
        else
            $('[data-modal="new_vox_comment"]').find('#cost').hide();

    });

    $('[data-modal="new_vox_comment"]').modal().onCancel(function()
    {
        response_to = '';
        $('[data-modal="new_vox_comment"]').find('form')[0].reset();
        $('[data-modal="new_vox_comment"]').find('label.error').removeClass('error');
        $('[data-modal="new_vox_comment"]').find('p.error').remove();
    });

    $('[data-modal="new_vox_comment"]').modal().onSuccess(function()
    {
        $('[data-modal="new_vox_comment"]').find('form').submit();
    });

    $('form[name="new_vox_comment"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);
        var data = new FormData(form[0]);

        data.append('action', 'new_vox_comment');
        data.append('response_to', response_to);

        $.ajax({
            type: 'POST',
            data: data,
            contentType: false,
            processData: false,
            cache: false,
            dataType: 'json',
            success: function (response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="success"]').addClass('view');
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    setTimeout(function() { location.reload(); }, 1500);
                }
                else if (response.status == 'error')
                {
                    if (response.labels)
                    {
                        form.find('label.error').removeClass('error');
                        form.find('p.error').remove();

                        $.each(response.labels, function(i, label)
                        {
                            if (label[1].length > 0)
                                form.find('[name="' + label[0] + '"]').parents('label').addClass('error').append('<p class="error">' + label[1] + '</p>');
                            else
                                form.find('[name="' + label[0] + '"]').parents('label').addClass('error');
                        });

                        form.find('label.error [name]')[0].focus();
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

    $('[data-response-to]').on('click', function()
    {
        response_to = '<span class="response-to">@' + $(this).data('response-to') + ':</span>';
        $('form[name="new_vox_comment"]').find('[name="message"]').attr('placeholder', 'Responder a @' + $(this).data('response-to'));
    });
});

function get_time_elapsed(date_1, date_2, time_zone, status, target)
{
    var date_1 = new Date(date_1);

    if (status == 'open')
        var date_2 = new Date(moment().tz(time_zone).format('YYYY-MM-DD hh:mm:ss'));
    else if (status == 'close')
        var date_2 = new Date(date_2);

    var months = '';
    var days = '';
    var hours = '';
    var minutes = '';
    var seconds = '';
    var time_elapsed = '';

    if (date_2 >= date_1)
    {
        days = Math.floor((date_2 - date_1) / (1000*60*60*24));

        seconds = Math.floor((date_2 - date_1) / 1000);
        minutes = Math.floor(seconds / 60);
        hours = Math.floor(minutes / 60);

        seconds = seconds - (60 * minutes);
        minutes = minutes - (60 * hours);
        hours = hours - (24 * days);

        months = days / 30.4;
        months = months.toFixed(1);

        if (days <= 9)
            days = '0' + days;

        if (seconds <= 9)
            seconds = '0' + seconds;

        if (minutes <= 9)
            minutes = '0' + minutes;

        if (hours <= 9)
            hours = '0' + hours;

        if (status == 'open')
        {
            if (days == '00')
                time_elapsed = '<strong>' + hours + ':' + minutes + ':' + seconds + ' Hrs</strong>';
            else if (days <= 30)
                time_elapsed = '<strong>' + days + ' Días, ' + hours + ':' + minutes + ':' + seconds + ' Hrs</strong>';
            else if (days > 30)
                time_elapsed = '<strong>' + months + ' Meses, ' + hours + ':' + minutes + ':' + seconds + ' Hrs</strong>';
        }
        else if (status == 'close')
        {
            if (minutes == '00')
                time_elapsed = '<strong>' + seconds + ' Seg</strong>';
            else if (hours == '00')
                time_elapsed = '<strong>' + minutes + ' Min</strong>';
            else if (days == '00')
                time_elapsed = '<strong>' + hours + ' Min ' + minutes + ' Hrs</strong>';
            else if (days <= 30)
                time_elapsed = '<strong>' + days + ' Días, ' + hours + ':' + minutes + ' Hrs</strong>';
            else if (days > 30)
                time_elapsed = '<strong>' + months + ' Meses, ' + hours + ':' + minutes + ' Hrs</strong>';
        }
    }
    else
        time_elapsed = 'Programada';

    target.html(time_elapsed);

    setTimeout(function() { get_time_elapsed(date_1, date_2, time_zone, status, target); }, 1000);
}
