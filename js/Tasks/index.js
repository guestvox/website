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

$(document).ready(function()
{
    var id;

    var tbl_tasks = $('#tasks').DataTable({
        ordering: false,
        autoWidth: false,
        pageLength: 25,
        info: false,
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

    });

    $('[data-action="new_task"]').on('click', function()
    {
        $('form[name="new_task"]').submit();
    });

    $('form[name="new_task"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=new_task',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                $('label.error').removeClass('error');
                $('p.error').remove();

                if (response.status == 'success')
                {
                    // $('form[name="new_opportunity_area"]')[0].reset();
                    // $('form[name="new_opportunity_area"]').find('[name="request"]').attr('checked', true);
                    // $('form[name="new_opportunity_area"]').find('[name="incident"]').attr('checked', true);
                    // $('form[name="new_opportunity_area"]').find('[name="public"]').attr('checked', true);
                    // $('label.error').removeClass('error');
                    // $('p.error').remove();
                    // $('#opportunity_areas').find('tbody').html(response.data);
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    $('[data-modal="success"]').addClass('view');

                    // tbl_opportunity_areas.row.add([
                    //     "ABCD",
                    //     "1",
                    //     "1",
                    //     "1",
                    //     "1",
                    //     "1",3
                    // ]).draw();

                    setTimeout(function(){ window.location.href = response.path; }, 1500);
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

    $(document).on('click', '[data-action="delete_task"]', function()
    {
        id = $(this).data('id');

        $('[data-modal="delete_task"]').addClass('view');
    });

    $('[data-modal="delete_task"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_task',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    $('[data-modal="success"]').addClass('view');

                    setTimeout(function() { window.location.href = response.path; }, 1500);
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').find('main > p').html(response.message);
                    $('[data-modal="error"]').addClass('view');
                }
            }
        });
    });

    $(document).on('click', '[data-action="edit_task"]', function()
    {
        id = $(this).data('id');

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_task',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('form[name="edit_task"]').find('[name="description"]').val(response.data.description);
                    $('form[name="edit_task"]').find('[name="assigned_users[]"]').val(response.data.assigned_users);
                    $('form[name="edit_task"]').find('[name="expiration_date"]').val(response.data.creation_date);
                    $('form[name="edit_task"]').find('[name="expiration_hour"]').val(response.data.creation_date);
                    $('form[name="edit_task"]').find('[name="creation_date"]').val(response.data.creation_date);
                    $('form[name="edit_task"]').find('[name="repetition"]').val(response.data.repetition);
                    $.each(response.data.assigned_users, function(key, value)
                    {
                        $('form[name="edit_task"]').find('[name="assigned_users[]"]').val(key);
                    });

                    $('[data-modal="edit_task"]').addClass('view');
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').find('main > p').html(response.message);
                    $('[data-modal="error"]').addClass('view');
                }
            }
        });
    });

    $('[data-modal="edit_task"]').modal().onCancel(function()
    {
        $('label.error').removeClass('error');
        $('p.error').remove();
        $('form[name="edit_task"]')[0].reset();
    });

    $('[data-modal="edit_task"]').modal().onSuccess(function()
    {
        $('form[name="edit_task"]').submit();
    });

    $('form[name="edit_task"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&id=' + id + '&action=edit_task',
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
