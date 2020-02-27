'use strict';

$(document).ready(function()
{
    var tbl_voxes = $('#tbl_voxes').DataTable({
        ordering: false,
        pageLength: 50,
        info: false,
        'drawCallback': function()
        {
            $('[data-elapsed-time]').each(function()
            {
                get_time_elapsed($(this).data('date-1').replace(/-/g, '/'), $(this).data('date-2').replace(/-/g, '/'), $(this).data('time-zone'), $(this).data('status'), $(this));
            });
        }
    });

    $('[name="tbl_voxes_search"]').on('keyup', function()
    {
        tbl_voxes.search(this.value).draw();
    });

    $(document).on('click', '#tbl_voxes > tbody > tr > td', function()
    {
        window.location.href = '/voxes/view/details/' + $(this).parents('tr').data('id');
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
                time_elapsed = seconds + ' Seg';
            else if (hours == '00')
                time_elapsed = minutes + ' Min';
            else if (days == '00')
                time_elapsed = hours + ' Min ' + minutes + ' Hrs';
            else if (days <= 30)
                time_elapsed = days + ' Días, ' + hours + ':' + minutes + ' Hrs';
            else if (days > 30)
                time_elapsed = months + ' Meses, ' + hours + ':' + minutes + ' Hrs';
        }
    }
    else
        time_elapsed = 'Programada';

    target.html(time_elapsed);

    setTimeout(function() { get_time_elapsed(date_1, date_2, time_zone, status, target); }, 1000);
}
