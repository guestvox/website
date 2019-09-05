'use strict';

$('.datepicker').datepicker({
    closeText: 'Cerrar',
    prevText: 'Anterior',
    nextText: 'Siguiente',
    currentText: 'Hoy',
    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
    monthNamesShort: ['ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic'],
    dayNames: ['domingo','lunes','martes','miércoles','jueves','viernes','sábado'],
    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
    weekHeader: 'Sm',
    dateFormat: 'yy-mm-dd',
});

$('.chosen-select').chosen();

// $(window).on('load', function() {
//     Push.Permission.request();
//     Push.Permission.has();
// });

$(document).ready(function()
{
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

        $('[name="room"]').val('');
        $('[name="opportunity_type"]').html('<option value="" selected hidden>Elegir...</option>');
        $('[name="opportunity_type"]').attr('disabled', true);
        $('[name="opportunity_type"]').parents('label').removeClass('success');
        $('[name="started_hour"]').parent().parent().find('p.description').toggleClass('hidden');
        $('[name="started_date"]').parent().find('p.description').toggleClass('hidden');
        $('[name="location"]').parent().find('p.description').toggleClass('hidden');
        $('[name="lastname"]').val('');

        if ($(this).val() == 'request')
        {
            $('[name="cost"]').val('');
            $('[name="cost"]').parent().parent().parent().addClass('hidden');
            $('[name="confidentiality"]').prop('checked', false);
            $('[name="confidentiality"]').parent().parent().parent().parent().addClass('hidden');
            $('[name="observations"]').val('');
            $('[name="observations"]').parent().parent().parent().removeClass('hidden');
            $('[name="subject"]').val('');
            $('[name="subject"]').parent().parent().parent().addClass('hidden');
            $('[name="description"]').val('');
            $('[name="description"]').parent().parent().parent().addClass('hidden');
            $('[name="action_taken"]').val('');
            $('[name="action_taken"]').parent().parent().parent().addClass('hidden');
            $('[name="guest_treatment"]').parent().parent().parent().removeClass('span2');
            $('[name="guest_treatment"]').parent().parent().parent().addClass('span3');
            $('[name="name"]').val('');
            $('[name="name"]').parent().parent().parent().addClass('hidden');
            $('[name="guest_id"]').val('');
            $('[name="guest_id"]').parent().parent().parent().addClass('hidden');
            $('[name="guest_type"]').val('');
            $('[name="guest_type"]').parent().parent().parent().addClass('hidden');
            $('[name="reservation_number"]').val('');
            $('[name="reservation_number"]').parent().parent().parent().addClass('hidden');
            $('[name="reservation_status"]').val('');
            $('[name="reservation_status"]').parent().parent().parent().addClass('hidden');
            $('[name="check_in"]').val('');
            $('[name="check_in"]').parent().parent().parent().addClass('hidden');
            $('[name="check_out"]').val('');
            $('[name="check_out"]').parent().parent().parent().addClass('hidden');
        }
        else if ($(this).val() == 'incident')
        {
            $('[name="cost"]').val('');
            $('[name="cost"]').parent().parent().parent().removeClass('hidden');
            $('[name="confidentiality"]').prop('checked', false);
            $('[name="confidentiality"]').parent().parent().parent().parent().removeClass('hidden');
            $('[name="observations"]').val('');
            $('[name="observations"]').parent().parent().parent().addClass('hidden');
            $('[name="subject"]').val('');
            $('[name="subject"]').parent().parent().parent().removeClass('hidden');
            $('[name="description"]').val('');
            $('[name="description"]').parent().parent().parent().removeClass('hidden');
            $('[name="action_taken"]').val('');
            $('[name="action_taken"]').parent().parent().parent().removeClass('hidden');
            $('[name="guest_treatment"]').parent().parent().parent().removeClass('span3');
            $('[name="guest_treatment"]').parent().parent().parent().addClass('span2');
            $('[name="name"]').val('');
            $('[name="name"]').parent().parent().parent().removeClass('hidden');
            $('[name="guest_id"]').val('');
            $('[name="guest_id"]').parent().parent().parent().removeClass('hidden');
            $('[name="guest_type"]').val('');
            $('[name="guest_type"]').parent().parent().parent().removeClass('hidden');
            $('[name="reservation_number"]').val('');
            $('[name="reservation_number"]').parent().parent().parent().removeClass('hidden');
            $('[name="reservation_status"]').val('');
            $('[name="reservation_status"]').parent().parent().parent().removeClass('hidden');
            $('[name="check_in"]').val('');
            $('[name="check_in"]').parent().parent().parent().removeClass('hidden');
            $('[name="check_out"]').val('');
            $('[name="check_out"]').parent().parent().parent().removeClass('hidden');
        }

        $('label.error').removeClass('error');
        $('p.error').remove();
    });

    $('[name="room"]').on('change', function()
    {
        // var xhr = new XMLHttpRequest();
        //
        // xhr.open('GET', 'https://admin.zaviaerp.com/pms/hotels/api/check_room2/?UserName=demo&UserPassword=demo&RoomNumber=1', true);
        //
        // xhr.setRequestHeader("Content-Type", "application/json");
        //
        // xhr.onload = function()
        // {
        //     console.log(xhr);
        //     // var respuesta = JSON.parse(xhr.responseText);
        //     // document.getElementById('nombre').value = respuesta.name;
        //     // document.getElementById('apellido').value = respuesta.lastName;
        // };
        //
        // xhr.send();

        $.ajax({
            type: 'POST',
            data: 'room=' + $(this).val() + '&action=get_api',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    if ($('[name="type"]:checked').val() == 'request')
                    {
                        $('[name="lastname"]').val(response.data.LastName);
                    }
                    else if ($('[name="type"]:checked').val() == 'incident')
                    {
                        $('[name="name"]').val(response.data.Name);
                        $('[name="lastname"]').val(response.data.LastName);
                        $('[name="guest_id"]').val(response.data.FolioID);
                    }
                }
                else if (response.status == 'error')
                {
                    if ($('[name="type"]:checked').val() == 'request')
                    {
                        $('[name="lastname"]').val('');
                    }
                    else if ($('[name="type"]:checked').val() == 'incident')
                    {
                        $('[name="name"]').val('');
                        $('[name="lastname"]').val('');
                        $('[name="guest_id"]').val('');
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
                $('label.error').removeClass('error');
                $('p.error').remove();

                if (response.status == 'success')
                {
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    $('[data-modal="success"]').addClass('view');

                    // Push.create('GuestVox', {
                    //     body: 'Nueva Incidencia',
                    //     icon: 'images/icon-color.svg',
                    //     timeout: 4000,
                    //     onClick: function()
                    //     {
                    //         window.location.href = '/dashboard';
                    //         this.close();
                    //     }
                    // });

                    setTimeout(function() { window.location.href = response.path; }, 1500);
                }
                else if (response.status == 'error')
                {
                    if (response.labels)
                    {
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
                        $('[data-modal="error"]').find('main > p').html(response.message);
                        $('[data-modal="error"]').addClass('view');
                    }
                }
            }
        });
    });
});
