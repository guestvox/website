'use strict';

$(document).ready(function ()
{
    var id;

    $('.multi-tabs').multiTabs();

    $('#reports').DataTable({
        ordering: false,
        autoWidth: false,
        info: false,
    });

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

    // ---

    $('[name="filter"]').on('change', function()
    {
        var parent = $(this).parents('form');

        if ($(this).val() != 'all')
        {
            $.ajax({
                type: 'POST',
                data: 'report=' + $(this).val() + '&action=get_filter',
                processData: false,
                cache: false,
                dataType: 'json',
                success: function(response)
                {
                    if (response.status == 'success')
                    {
                        parent.find('[name="type"]').val(response.data.type);
                        parent.find('[name="opportunity_area"]').html(response.data.opt_opportunity_areas);
                        parent.find('[name="opportunity_area"]').val(response.data.opportunity_area);
                        parent.find('[name="opportunity_type"]').html(response.data.opt_opportunity_types);
                        parent.find('[name="opportunity_type"]').val(response.data.opportunity_type);
                        parent.find('[name="room"]').val(response.data.room);
                        parent.find('[name="location"]').html(response.data.opt_locations);
                        parent.find('[name="location"]').val(response.data.location);
                        parent.find('[name="order"]').val(response.data.order);
                        parent.find('[name="started_date"]').val(response.data.started_date);
                        parent.find('[name="end_date"]').val(response.data.end_date);
                        parent.find('[name="fields[]"]').parent().parent().html(response.data.cbx_fields);

                        $.each(response.data.fields, function (key, value)
                        {
                            parent.find('[name="fields[]"][value="' + value + '"]').prop('checked', true);
                        });
                    }
                }
            });
        }
        else
            location.reload();
    });

    $('[name="type"]').on('change', function()
    {
        var parent = $(this).parents('form');

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
                    parent.find('[name="opportunity_area"]').html(response.data);
                    parent.find('[name="opportunity_type"]').html('<option value="all">Todo</option>');
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
                    parent.find('[name="location"]').html(response.data);
            }
        });

        $.ajax({
            type: 'POST',
            data: 'option=' + $(this).val() + '&action=get_cbx_addressed_to_opportunity_areas',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    parent.find('[name="addressed_to_opportunity_areas[]"]').parent().parent().html(response.data);
            }
        });

        $.ajax({
            type: 'POST',
            data: 'option=' + $(this).val() + '&action=get_cbx_fields',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    parent.find('[name="fields[]"]').parent().parent().html(response.data);
            }
        });
    });

    $('[name="opportunity_area"]').on('change', function()
    {
        var parent = $(this).parents('form');

        $.ajax({
            type: 'POST',
            data: 'opportunity_area=' + $(this).val() + '&option=' + parent.find('[name="type"]').val() + '&action=get_opt_opportunity_types',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    parent.find('[name="opportunity_type"]').html(response.data);
            }
        });
    });

    $(document).on('click', '[name="checked_all"]', function()
    {
        var parent = $(this).parents('.checkboxes');

        if ($(this).prop('checked') == true)
            parent.find('[type="checkbox"]').prop('checked', true);
        else if ($(this).prop('checked') == false)
            parent.find('[type="checkbox"]').prop('checked', false);
    });

    $(document).on('change', '[type="checkbox"]', function()
    {
        var parent = $(this).parents('.checkboxes');

        if ($(this).prop('checked') == false)
            parent.find('[name="checked_all"]').prop('checked', false);
    });

    $('[data-action="generate_report"]').on('click', function()
    {
        $('form[name="generate_report"]').submit();
    });

    $('form[name="generate_report"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=generate_report',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                $('label.error').removeClass('error');
                $('p.error').remove();

                if (response.status == 'success')
                {
                    $('#report').html(response.data);
                    $('[data-action="print_report"]').removeClass('hidden');
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

    $('[data-action="print_report"]').on('click', function()
    {
        var html1 = document.body.innerHTML;
        var html2 = document.getElementById('report').innerHTML;

        document.body.innerHTML = html2;

        window.print();

        document.body.innerHTML = html1;
    });

    // ---

    $('[name="addressed_to"]').on('change', function()
    {
        var parent = $(this).parents('form');

        if ($(this).val() == 'opportunity_areas')
            parent.find('[name="addressed_to_opportunity_areas[]"]').parent().parent().parent().parent().parent().removeClass('hidden');
        else
            parent.find('[name="addressed_to_opportunity_areas[]"]').parent().parent().parent().parent().parent().addClass('hidden');
    });

    $('[data-action="new_report"]').on('click', function()
    {
        $('form[name="new_report"]').submit();
    });

    $('form[name="new_report"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=new_report',
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

                    setTimeout(function() { location.reload(); }, 1500);
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

    $(document).on('click', '[data-action="delete_report"]', function()
    {
        id = $(this).data('id');

        $('[data-modal="delete_report"]').addClass('view');
    });

    $('[data-modal="delete_report"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_report',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    $('[data-modal="success"]').addClass('view');

                    setTimeout(function() { location.reload(); }, 1500);
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').find('main > p').html(response.message);
                    $('[data-modal="error"]').addClass('view');
                }
            }
        });
    });
});
