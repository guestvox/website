'use strict';

$(document).ready(function()
{
    // $('.datepicker').datepicker({
    //     closeText: 'Cerrar',
    //     prevText: 'Anterior',
    //     nextText: 'Siguiente',
    //     currentText: 'Hoy',
    //     monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
    //     monthNamesShort: ['ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic'],
    //     dayNames: ['domingo','lunes','martes','miércoles','jueves','viernes','sábado'],
    //     dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
    //     weekHeader: 'Sm',
    //     dateFormat: 'yy-mm-dd',
    // });

    $('.chosen-select').chosen();

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

    $('[name="type"]').on('change', function()
    {
        $('[name="started_hour"]').parent().parent().find('p.description').toggleClass('hidden');
        $('[name="started_date"]').parent().find('p.description').toggleClass('hidden');
        $('[name="location"]').parent().find('p.description').toggleClass('hidden');

        if ($(this).val() == 'request')
        {
            $('[name="cost"]').parent().parent().parent().addClass('hidden');
            $('[name="confidentiality"]').parent().parent().parent().parent().addClass('hidden');
            $('[name="observations"]').parent().parent().parent().removeClass('hidden');
            $('[name="subject"]').parent().parent().parent().addClass('hidden');
            $('[name="assigned_users[]"]').parent().parent().parent().removeClass('span6');
            $('[name="assigned_users[]"]').parent().parent().parent().addClass('span3');
            $('[name="description"]').parent().parent().parent().addClass('hidden');
            $('[name="action_taken"]').parent().parent().parent().addClass('hidden');
            $('[name="guest_treatment"]').parent().parent().parent().removeClass('span2');
            $('[name="guest_treatment"]').parent().parent().parent().addClass('span3');
            $('[name="guest_id"]').parent().parent().parent().addClass('hidden');
            $('[name="guest_type"]').parent().parent().parent().addClass('hidden');
            $('[name="reservation_number"]').parent().parent().parent().addClass('hidden');
            $('[name="reservation_status"]').parent().parent().parent().addClass('hidden');
            $('[name="check_in"]').parent().parent().parent().addClass('hidden');
            $('[name="check_out"]').parent().parent().parent().addClass('hidden');
        }
        else if ($(this).val() == 'incident')
        {
            $('[name="cost"]').parent().parent().parent().removeClass('hidden');
            $('[name="confidentiality"]').parent().parent().parent().parent().removeClass('hidden');
            $('[name="observations"]').parent().parent().parent().addClass('hidden');
            $('[name="subject"]').parent().parent().parent().removeClass('hidden');
            $('[name="assigned_users[]"]').parent().parent().parent().removeClass('span3');
            $('[name="assigned_users[]"]').parent().parent().parent().addClass('span6');
            $('[name="description"]').parent().parent().parent().removeClass('hidden');
            $('[name="action_taken"]').parent().parent().parent().removeClass('hidden');
            $('[name="guest_treatment"]').parent().parent().parent().removeClass('span3');
            $('[name="guest_treatment"]').parent().parent().parent().addClass('span2');
            $('[name="guest_id"]').parent().parent().parent().removeClass('hidden');
            $('[name="guest_type"]').parent().parent().parent().removeClass('hidden');
            $('[name="reservation_number"]').parent().parent().parent().removeClass('hidden');
            $('[name="reservation_status"]').parent().parent().parent().removeClass('hidden');
            $('[name="check_in"]').parent().parent().parent().removeClass('hidden');
            $('[name="check_out"]').parent().parent().parent().removeClass('hidden');
        }

        $('label.error').removeClass('error');
        $('p.error').remove();
    });

    $('[name="room"]').on('change', function()
    {
        $.ajax({
            type: 'POST',
            data: 'room=' + $(this).val() + '&action=get_guest',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    if ($('[name="type"]:checked').val() == 'request')
                    {
                        $('[name="firstname"]').val(response.data.firstname);
                        $('[name="lastname"]').val(response.data.lastname);
                    }
                    else if ($('[name="type"]:checked').val() == 'incident')
                    {
                        $('[name="firstname"]').val(response.data.firstname);
                        $('[name="lastname"]').val(response.data.lastname);
                        $('[name="reservation_number"]').val(response.data.reservation_number);
                        $('[name="check_in"]').val(response.data.check_in);
                        $('[name="check_out"]').val(response.data.check_out);
                    }
                }
                else if (response.status == 'error')
                {
                    if ($('[name="type"]:checked').val() == 'request')
                    {
                        $('[name="firstname"]').val('');
                        $('[name="lastname"]').val('');
                    }
                    else if ($('[name="type"]:checked').val() == 'incident')
                    {
                        $('[name="firstname"]').val('');
                        $('[name="lastname"]').val('');
                        $('[name="reservation_number"]').val('');
                        $('[name="check_in"]').val('');
                        $('[name="check_out"]').val('');
                    }
                }
            }
        });
    });

    $('[name="opportunity_area"]').on('change', function()
    {
        $.ajax({
            type: 'POST',
            data: 'opportunity_area=' + $(this).val() + '&option=' + $('[name="type"]:checked').val() + '&action=get_opt_opportunity_types',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[name="opportunity_type"]').html(response.data);
                    $('[name="opportunity_type"]').attr('disabled', false);
                }
            }
        });
    });

    $('[data-action="edit_vox"]').on('click', function()
    {
        $('form[name="edit_vox"]').submit();
    });

    $('form[name="edit_vox"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);
        var data = new FormData(form[0]);

        data.append('action', 'edit_vox');

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
                    $('[data-modal="success"]').addClass('view');
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    setTimeout(function() { window.location.href = response.path; }, 1500);
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
});
