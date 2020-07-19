'use strict';

$(window).on('beforeunload ajaxStart', function()
{
    $('[data-ajax-loader]').addClass('view');
});

$(window).on('ajaxStop', function()
{
    $('[data-ajax-loader]').removeClass('view');
});

$(document).ready(function ()
{
    $('[data-action="open_rightbar"]').on('click', function(e)
    {
        e.stopPropagation();

        $('body').toggleClass('open');
    });

    $('[required]').each(function()
    {
        required_focus('label', $(this), null);
    });

    $('[required]').on('change', function()
    {
        required_focus('label', $(this), null);
    });

    $('[unrequired]').each(function()
    {
        required_focus('label', $(this), null);
    });

    $('[unrequired]').on('change', function()
    {
        required_focus('label', $(this), null);
    });

    $('[data-select]').on('click', function()
    {
        var type = $(this).parents('[data-uploader]').data('uploader');
        var target = $(this).parents('[data-uploader]').find('[data-upload]');
        var preview = null;
        var name = null;
        var action = null;

        if (type == 'fast')
        {
            name = target.attr('name');
            action = $(this).data('action');
        }
        else if (type == 'low')
            preview = $(this).parents('[data-uploader]').find('[data-preview] > img');
        else if (type == 'multiple')
            preview = $(this).parents('[data-uploader]').find('[data-preview]');

        upload_image(type, target, preview, name, action);
    });

    $('[data-switcher]').each(function()
    {
        if ($(this).is(':checked'))
            $(this).parent().addClass('checked');
        else
            $(this).parent().removeClass('checked');
    });

    $('[data-switcher]').on('change', function()
    {
        $(this).parent().toggleClass('checked');
    });

    $(document).on('change', '[name="checked_all"]', function()
    {
        if ($(this).prop('checked') == true)
            $(this).parents('.checkboxes').find('[type="checkbox"]').prop('checked', true);
        else if ($(this).prop('checked') == false)
            $(this).parents('.checkboxes').find('[type="checkbox"]').prop('checked', false);
    });

    $(document).on('change', '[type="checkbox"]', function()
    {
        if ($(this).prop('checked') == false)
            $(this).parents('.checkboxes').find('[name="checked_all"]').prop('checked', false);
    });

    $('[data-elapsed-time]').each(function()
    {
        get_time_elapsed($(this).data('date-1').replace(/-/g, '/'), $(this).data('date-2').replace(/-/g, '/'), $(this).data('time-zone'), $(this).data('status'), $(this).find('strong'));
    });

    $('[data-action="get_help"]').on('click', function()
    {
        $('[data-modal="get_help"]').find('main > p').html($(this).data('text'));
        $('[data-modal="get_help"]').addClass('view');
    });

    $('[name="search"]').on('keyup', function()
    {
        var string_1 = $(this).val();
        var targets = $(this).parents('body').find('[data-table] > div');

        if (string_1.length > 0)
        {
            $.each(targets, function(key, value)
            {
                var string_2 = string_1.toLowerCase();
                var string_3 = value.innerHTML.toLowerCase();
                var result = string_3.indexOf(string_2);

                if (result > 0)
                    value.className = '';
                else if (result <= 0)
                    value.className = 'hidden';
            });
        }
        else
            targets.removeClass('hidden');
    });
});

function menu_focus(target)
{
    $(document).find('header.rightbar > nav > ul > li[target="' + target + '"]').addClass('active');
}

function required_focus(type, target, fields)
{
    if (type == 'label' || type == 'input')
    {
        var field;

        if (type == 'label')
            field = target.find('[name]');
        else if (type == 'input')
        {
            field = target;
            target = field.parent();
        }

        if (field.val() == '' || field.val() == null || field.val() == undefined)
            target.removeClass('success');
        else
            target.addClass('success');

        target.removeClass('error');
        target.find('p.error').remove();
    }
    else if (type == 'form')
    {
        fields = target.find('[name]');

        $.each(fields, function(key, value)
        {
            var field = target.find('[name="' + value.getAttribute('name') + '"]');
            var parent = field.parent();

            if (field.val() == '' || field.val() == null || field.val() == undefined)
                parent.removeClass('success');
            else
                parent.addClass('success');

            parent.removeClass('error');
            parent.find('p.error').remove();
        });

        fields = target.find('[data-switcher]');

        $.each(fields, function(key, value)
        {
            var field = target.find('[name="' + value.getAttribute('name') + '"]');
            var parent = field.parent();

            if (field.is(':checked'))
                parent.addClass('checked');
            else
                parent.removeClass('checked');
        });
    }
    else if (type == 'names')
    {
        $.each(fields, function(key, value)
        {
            var field = target.find('[name="' + value + '"]');
            var parent = field.parent();

            if (field.val() == '' || field.val() == null || field.val() == undefined)
                parent.removeClass('success');
            else
                parent.addClass('success');

            parent.removeClass('error');
            parent.find('p.error').remove();
        });
    }
}

function clean_form(target)
{
    target[0].reset();

    target.find('[data-uploader]').find('[data-preview] > img').attr('src', '../images/empty.png');
    target.find('[data-uploader]').find('[data-preview] > div').removeClass('active');
    target.find('[data-uploader]').find('[data-preview] > div > span > strong').val('0');
    target.find('[data-switcher]').parent().removeClass('checked');
    target.find('label.success').removeClass('success');
    target.find('label.error').removeClass('error');
    target.find('p.error').remove();
}

function upload_image(type, target, preview, name, action)
{
    target.click();

    target.on('change', function()
    {
        if (type == 'fast')
        {
            var data = new FormData();

            data.append(name, target[0].files[0]);
            data.append('action', action);

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
                        show_modal_success(response.message, 1500);
                    else if (response.status == 'error')
                        show_modal_error(response.message);
                }
            });
        }
        else if (type == 'low')
        {
            var reader = new FileReader();

            reader.onload = function(e)
            {
                var slt = target[0].files[0].name.split('.');
                slt = slt[1].toUpperCase();

                if (slt == 'PNG' || slt == 'JPG' || slt == 'JPEG')
                    slt = e.target.result;
                else if (slt == 'PDF')
                    slt = '../images/pdf.png';
                else if (slt == 'DOC' || slt == 'DOCX')
                    slt = '../images/word.png';
                else if (slt == 'XLS' || slt == 'XLSX')
                    slt = '../images/excel.png';

                preview.attr('src', slt);
            }

            reader.readAsDataURL(target[0].files[0]);
        }
        else if (type == 'multiple')
        {
            var img = 0;
            var pdf = 0;
            var wrd = 0;
            var exl = 0;

            $.each(target[0].files, function(key, value)
            {
                var slt = value.name.split('.');
                slt = slt[1].toUpperCase();

                if (slt == 'PNG' || slt == 'JPG' || slt == 'JPEG')
                    img = img + 1;
                else if (slt == 'PDF')
                    pdf = pdf + 1;
                else if (slt == 'DOC' || slt == 'DOCX')
                    wrd = wrd + 1;
                else if (slt == 'XLS' || slt == 'XLSX')
                    exl = exl + 1;
            });

            preview.find('[data-image]').find('strong').html(img);
            preview.find('[data-pdf]').find('strong').html(pdf);
            preview.find('[data-word]').find('strong').html(wrd);
            preview.find('[data-excel]').find('strong').html(exl);

            if (img > 0)
                preview.find('[data-image]').addClass('active');
            else
                preview.find('[data-image]').removeClass('active');

            if (pdf > 0)
                preview.find('[data-pdf]').addClass('active');
            else
                preview.find('[data-pdf]').removeClass('active');

            if (wrd > 0)
                preview.find('[data-word]').addClass('active');
            else
                preview.find('[data-word]').removeClass('active');

            if (exl > 0)
                preview.find('[data-excel]').addClass('active');
            else
                preview.find('[data-excel]').removeClass('active');
        }
    });
}

function show_form_errors(form, response)
{
    if (response.labels)
    {
        form.find('label.error').removeClass('error');
        form.find('p.error').remove();

        $.each(response.labels, function(key, value)
        {
            if (value[1].length > 0)
                form.find('[name="' + value[0] + '"]').parents('label').addClass('error').append('<p class="error">' + value[1] + '</p>');
            else
                form.find('[name="' + value[0] + '"]').parents('label').addClass('error');
        });

        form.find('label.error > [name]')[0].focus();
    }
    else if (response.message)
        show_modal_error(response.message);
}

function show_modal_success(message, timeout, path)
{
    $('[data-modal="success"]').find('main > p').html(message);
    $('[data-modal="success"]').addClass('view');

    if (path)
    {
        setTimeout(function()
        {
            if (path == 'fast')
                $('[data-modal="success"]').removeClass('view');
            else
                window.location.href = path;
        }, timeout);
    }
    else
        setTimeout(function() { location.reload(); }, timeout);
}

function show_modal_error(message)
{
    $('[data-modal="error"]').find('main > p').html(message);
    $('[data-modal="error"]').addClass('view');
}

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
            if (hours == '00' && minutes == '00')
                time_measure = 'Segundos';
            else if (hours == '00')
                time_measure = 'Minutos';
            else
                time_measure = 'Horas';

            if (days < 1)
                time_elapsed = hours + ':' + minutes + ':' + seconds + ' ' + time_measure;
            else if (days >= 1 && days <= 30)
                time_elapsed = days + ' Días ' + hours + ':' + minutes + ':' + seconds + ' ' + time_measure;
            else if (days > 30)
                time_elapsed = months + ' Meses ' + hours + ':' + minutes + ':' + seconds + ' ' + time_measure;
        }
        else
        {
            if (days < 1)
            {
                if (minutes == '00')
                    time_elapsed = seconds + ' Segundos';
                else if (hours == '00')
                    time_elapsed = minutes + ' Minutos';
                else if (days == '00')
                    time_elapsed = hours + ' Horas';
            }
            else if (days >= 1 && days <= 30)
                time_elapsed = days + ' Días';
            else if (days > 30)
                time_elapsed = months + ' Meses';
        }
    }
    else
        time_elapsed = 'Programada';

    target.html(time_elapsed);

    setTimeout(function() { get_time_elapsed(date_1, date_2, time_zone, status, target); }, 1000);
}
