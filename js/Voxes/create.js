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
        $.ajax({
            type: 'POST',
            data: 'option=' + $(this).val() + '&action=get_opt_opportunity_areas',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[name="opportunity_area"]').html(response.data);
                    $('[name="opportunity_area"]').parents('label').removeClass('success');
                    $('[name="opportunity_type"]').html('<option value="" selected hidden>Elegir...</option>');
                    $('[name="opportunity_type"]').attr('disabled', true);
                    $('[name="opportunity_type"]').parents('label').removeClass('success');
                }
            }
        });

        $.ajax({
            type: 'POST',
            data: 'option=' + $(this).val() + '&action=get_opt_locations',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[name="location"]').html(response.data);
                    $('[name="location"]').parents('label').removeClass('success');
                }
            }
        });

        if ($(this).val() == 'request')
        {
            $('[name="room"]').parent().parent().parent().removeClass('hidden');
            $('[name="table"]').parent().parent().parent().removeClass('hidden');
            $('[name="cost"]').parent().parent().parent().addClass('hidden');
            $('[name="confidentiality"]').parent().parent().parent().parent().addClass('hidden');
            $('[name="observations"]').parent().parent().parent().removeClass('hidden');
            $('[name="subject"]').parent().parent().parent().addClass('hidden');
            $('[name="description"]').parent().parent().parent().addClass('hidden');
            $('[name="action_taken"]').parent().parent().parent().addClass('hidden');
            $('[name="guest_treatment"]').parent().parent().parent().removeClass('hidden');
            $('[name="firstname"]').parent().parent().parent().removeClass('hidden');
            $('[name="lastname"]').parent().parent().parent().removeClass('hidden');
            $('[name="guest_id"]').parent().parent().parent().addClass('hidden');
            $('[name="guest_type"]').parent().parent().parent().addClass('hidden');
            $('[name="reservation_number"]').parent().parent().parent().addClass('hidden');
            $('[name="reservation_status"]').parent().parent().parent().addClass('hidden');
            $('[name="check_in"]').parent().parent().parent().addClass('hidden');
            $('[name="check_out"]').parent().parent().parent().addClass('hidden');
        }
        else if ($(this).val() == 'incident')
        {
            $('[name="room"]').parent().parent().parent().removeClass('hidden');
            $('[name="table"]').parent().parent().parent().removeClass('hidden');
            $('[name="cost"]').parent().parent().parent().removeClass('hidden');
            $('[name="confidentiality"]').parent().parent().parent().parent().removeClass('hidden');
            $('[name="observations"]').parent().parent().parent().addClass('hidden');
            $('[name="subject"]').parent().parent().parent().removeClass('hidden');
            $('[name="description"]').parent().parent().parent().removeClass('hidden');
            $('[name="action_taken"]').parent().parent().parent().removeClass('hidden');
            $('[name="guest_treatment"]').parent().parent().parent().removeClass('hidden');
            $('[name="firstname"]').parent().parent().parent().removeClass('hidden');
            $('[name="lastname"]').parent().parent().parent().removeClass('hidden');
            $('[name="guest_id"]').parent().parent().parent().removeClass('hidden');
            $('[name="guest_type"]').parent().parent().parent().removeClass('hidden');
            $('[name="reservation_number"]').parent().parent().parent().removeClass('hidden');
            $('[name="reservation_status"]').parent().parent().parent().removeClass('hidden');
            $('[name="check_in"]').parent().parent().parent().removeClass('hidden');
            $('[name="check_out"]').parent().parent().parent().removeClass('hidden');
        }
        else if ($(this).val() == 'workorder')
        {
            $('[name="room"]').parent().parent().parent().addClass('hidden');
            $('[name="table"]').parent().parent().parent().addClass('hidden');
            $('[name="cost"]').parent().parent().parent().addClass('hidden');
            $('[name="confidentiality"]').parent().parent().parent().parent().addClass('hidden');
            $('[name="observations"]').parent().parent().parent().removeClass('hidden');
            $('[name="subject"]').parent().parent().parent().addClass('hidden');
            $('[name="description"]').parent().parent().parent().addClass('hidden');
            $('[name="action_taken"]').parent().parent().parent().addClass('hidden');
            $('[name="guest_treatment"]').parent().parent().parent().addClass('hidden');
            $('[name="firstname"]').parent().parent().parent().addClass('hidden');
            $('[name="lastname"]').parent().parent().parent().addClass('hidden');
            $('[name="guest_id"]').parent().parent().parent().addClass('hidden');
            $('[name="guest_type"]').parent().parent().parent().addClass('hidden');
            $('[name="reservation_number"]').parent().parent().parent().addClass('hidden');
            $('[name="reservation_status"]').parent().parent().parent().addClass('hidden');
            $('[name="check_in"]').parent().parent().parent().addClass('hidden');
            $('[name="check_out"]').parent().parent().parent().addClass('hidden');
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
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
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

    $('[data-action="new_vox"]').on('click', function()
    {
        $('form[name="new_vox"]').submit();
    });

    $('form[name="new_vox"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);
        var data = new FormData(form[0]);

        data.append('action', 'new_vox');

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
                    setTimeout(function() { window.location.href = '/voxes'; }, 1500);
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
