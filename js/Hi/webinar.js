'use strict';

$(document).ready(function()
{
    const second = 1000;
    const minute = second * 60;
    const hour = minute * 60;
    const day = hour * 24;
    let date = new Date($('#countdown').data('date')).getTime();
    let interval = setInterval(function()
    {
        let today = new Date().getTime();
        let difference = date - today;

        if (difference > 0)
        {
            var days = Math.floor(difference / day);

            if (days <= 9)
                days = '0' + days;

            var hours = Math.floor((difference % day) / hour);

            if (hours <= 9)
                hours = '0' + hours;

            var minutes = Math.floor((difference % hour) / minute);

            if (minutes <= 9)
                minutes = '0' + minutes;

            var seconds = Math.floor((difference % minute) / second);

            if (seconds <= 9)
                seconds = '0' + seconds;

            document.getElementById('days').innerText = days;
            document.getElementById('hours').innerText = hours;
            document.getElementById('minutes').innerText = minutes;
            document.getElementById('seconds').innerText = seconds;
        }
        else if (difference <= 0)
        {
            document.getElementById('days').innerText = '00';
            document.getElementById('hours').innerText = '00';
            document.getElementById('minutes').innerText = '00';
            document.getElementById('seconds').innerText = '00';

            clearInterval(interval);
        }
    }, second);

    $('[data-modal="signup"]').modal().onCancel(function()
    {
        $('[data-modal="signup"]').find('form')[0].reset();
        $('[data-modal="signup"]').find('label.error').removeClass('error');
        $('[data-modal="signup"]').find('p.error').remove();
    });

    $('form[name="signup"]').on('submit', function(e)
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
                    show_modal_success(response.message, 8000);
                else if (response.status == 'error')
                    how_form_errors(form, response);
            }
        });
    });
});
