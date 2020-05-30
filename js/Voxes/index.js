'use strict';

$(document).ready(function()
{
    $('[data-elapsed-time]').each(function()
    {
        get_time_elapsed($(this).data('date-1').replace(/-/g, '/'), $(this).data('date-2').replace(/-/g, '/'), $(this).data('time-zone'), $(this).data('status'), $(this));
    });
});

function get_time_elapsed(date_1, date_2, time_zone, status, target)
{
    var date_1 = new Date(date_1);

    if (status == true)
        var date_2 = new Date(moment().tz(time_zone).format('YYYY-MM-DD HH:mm:ss'));
    else
        var date_2 = new Date(date_2);

    var months = '';
    var days = '';
    var hours = '';
    var minutes = '';
    var seconds = '';
    var time_measure = '';
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

        if (status == true)
        {
            if (minutes == '00')
                time_measure = 'Segundos';
            else if (hours == '00')
                time_measure = 'Minutos';
            else if (days == '00')
                time_measure = 'Horas';

            if (days < 1)
                time_elapsed = '<strong>' + hours + ':' + minutes + ':' + seconds + ' ' + time_measure + '</strong>';
            else if (days >= 1 && days <= 30)
                time_elapsed = '<strong>' + days + ' Días ' + hours + ':' + minutes + ':' + seconds + ' ' + time_measure + '</strong>';
            else if (days > 30)
                time_elapsed = '<strong>' + months + ' Meses ' + hours + ':' + minutes + ':' + seconds + ' ' + time_measure + '</strong>';
        }
        else
        {
            if (days < 1)
            {
                if (minutes == '00')
                    time_elapsed = '<strong>' + seconds + ' Segundos</strong>';
                else if (hours == '00')
                    time_elapsed = '<strong>' + minutes + ' Minutos</strong>';
                else if (days == '00')
                    time_elapsed = '<strong>' + hours + ' Horas</strong>';
            }
            else if (days >= 1 && days <= 30)
                time_elapsed = '<strong>' + days + ' Días</strong>';
            else if (days > 30)
                time_elapsed = '<strong>' + months + ' Meses</strong>';
        }
    }
    else
        time_elapsed = '<strong>Programada</strong>';

    target.html(time_elapsed);

    setTimeout(function() { get_time_elapsed(date_1, date_2, time_zone, status, target); }, 1000);
}
