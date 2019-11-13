'use strict';

$(document).ready(function()
{
    var id;

    $('.multi-tabs').multiTabs();

    var tbl_opportunity_areas = $('#opportunity_areas').DataTable({
        ordering: false,
        autoWidth: false,
        pageLength: 25,
        info: false,
    });

    // ---

    $('[data-action="new_opportunity_area"]').on('click', function()
    {
        $('form[name="new_opportunity_area"]').submit();
    });

    $('form[name="new_opportunity_area"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=new_opportunity_area',
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

    $(document).on('click','[data-action="edit_opportunity_area"]', function()
    {
        id = $(this).data('id');

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_opportunity_area',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('form[name="edit_opportunity_area"]').find('[name="name_es"]').val(response.data.name.es);
                    $('form[name="edit_opportunity_area"]').find('[name="name_en"]').val(response.data.name.en);

                    if (response.data.request == true)
                        $('form[name="edit_opportunity_area"]').find('[name="request"]').attr('checked', true);

                    if (response.data.incident == true)
                        $('form[name="edit_opportunity_area"]').find('[name="incident"]').attr('checked', true);

                    if (response.data.public == true)
                        $('form[name="edit_opportunity_area"]').find('[name="public"]').attr('checked', true);

                    $('[data-modal="edit_opportunity_area"]').addClass('view');
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').find('main > p').html(response.message);
                    $('[data-modal="error"]').addClass('view');
                }
            }
        });
    });

    $('[data-modal="edit_opportunity_area"]').modal().onCancel(function()
    {
        $('label.error').removeClass('error');
        $('p.error').remove();
        $('form[name="edit_opportunity_area"]').find('[name="request"]').attr('checked', false);
        $('form[name="edit_opportunity_area"]').find('[name="incident"]').attr('checked', false);
        $('form[name="edit_opportunity_area"]').find('[name="public"]').attr('checked', false);
        $('form[name="edit_opportunity_area"]')[0].reset();
    });

    $('[data-modal="edit_opportunity_area"]').modal().onSuccess(function()
    {
        $('form[name="edit_opportunity_area"]').submit();
    });

    $('form[name="edit_opportunity_area"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&id=' + id + '&action=edit_opportunity_area',
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

    $(document).on('click', '[data-action="delete_opportunity_area"]', function()
    {
        id = $(this).data('id');

        $('[data-modal="delete_opportunity_area"]').addClass('view');
    });

    $('[data-modal="delete_opportunity_area"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_opportunity_area',
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
