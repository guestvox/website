'use strict';

$(document).ready(function()
{
    var tbl_voxes_unresolve = $('#tbl_voxes_unresolve');

    if (tbl_voxes_unresolve.length > 0)
    {
        tbl_voxes_unresolve.DataTable({
            ordering: false,
            pageLength: 10,
            info: false,
            'drawCallback': function()
            {
                $('[data-elapsed-time]').each(function()
                {
                    get_elapsed_time($(this).data('started-date').replace(/-/g, '/'), $(this));
                });
            }
        });

        $('[name="tbl_voxes_unresolve_search"]').on('keyup', function()
        {
            tbl_voxes_unresolve.search(this.value).draw();
        });

        $(document).on('click', '#tbl_voxes_unresolve > tbody > tr > td', function()
        {
            window.location.href = '/voxes/view/details/' + $(this).parents('tr').data('id');
        });
    }
});

function get_elapsed_time(datehour1, target)
{
    var datehour1 = new Date(datehour1);
    var datehour2 = new Date();
    var months = '';
    var days = '';
    var hours = '';
    var minutes = '';
    var seconds = '';
    var elapsed_time = '';

    if (datehour2 >= datehour1)
    {
        days = Math.floor((datehour2 - datehour1) / (1000*60*60*24));
        seconds = Math.floor((datehour2 - datehour1) / 1000);
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

        if (days == '00')
            elapsed_time = '<strong>' + hours + ':' + minutes + ':' + seconds + ' Hrs</strong>';
        else if (days <= 30)
            elapsed_time = '<strong>' + days + ' Días, ' + hours + ':' + minutes + ':' + seconds + ' Hrs</strong>';
        else if (days > 30)
            elapsed_time = '<strong>' + months + ' Meses, ' + hours + ':' + minutes + ':' + seconds + ' Hrs</strong>';
    }
    else
        elapsed_time = 'Programada';

    target.html(elapsed_time);

    setTimeout(function() { get_elapsed_time(datehour1, target); }, 1000);
}
