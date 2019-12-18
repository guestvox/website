'use strict';

$(document).ready(function()
{
    var tbl_tables = $('#tbl_tables').DataTable({
        ordering: false,
        pageLength: 25,
        info: false,
    });

    $('[name="tbl_tables_search"]').on('keyup', function()
    {
        tbl_tables.search(this.value).draw();
    });

    $('[name="type"]').on('change', function()
    {
        if ($(this).val() == 'many')
        {
            $('form[name="new_table"]').find('[name="since"]').parent().parent().parent().removeClass('hidden');
            $('form[name="new_table"]').find('[name="to"]').parent().parent().parent().removeClass('hidden');
            $('form[name="new_table"]').find('[name="number"]').parent().parent().parent().addClass('hidden');
            $('form[name="new_table"]').find('[name="name"]').parent().parent().parent().addClass('hidden');
        }
        else if ($(this).val() == 'one')
        {
            $('form[name="new_table"]').find('[name="since"]').parent().parent().parent().addClass('hidden');
            $('form[name="new_table"]').find('[name="to"]').parent().parent().parent().addClass('hidden');
            $('form[name="new_table"]').find('[name="number"]').parent().parent().parent().removeClass('hidden');
            $('form[name="new_table"]').find('[name="name"]').parent().parent().parent().removeClass('hidden');
        }
    });

    $('[data-modal="new_table"]').modal().onCancel(function()
    {
        $('[data-modal="new_table"]').find('form')[0].reset();
        $('[data-modal="new_table"]').find('label.error').removeClass('error');
        $('[data-modal="new_table"]').find('p.error').remove();
        $('[data-modal="new_table"]').find('[name="since"]').parent().parent().parent().removeClass('hidden');
        $('[data-modal="new_table"]').find('[name="to"]').parent().parent().parent().removeClass('hidden');
        $('[data-modal="new_table"]').find('[name="number"]').parent().parent().parent().addClass('hidden');
        $('[data-modal="new_table"]').find('[name="name"]').parent().parent().parent().addClass('hidden');
    });

    $('[data-modal="new_table"]').modal().onSuccess(function()
    {
        $('[data-modal="new_table"]').find('form').submit();
    });

    $('form[name="new_table"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=new_table',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="success"]').addClass('view');
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    setTimeout(function() { location.reload(); }, 1500);
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

    var id;

    $(document).on('click', '[data-action="edit_table"]', function()
    {
        id = $(this).data('id');

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_table',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="edit_table"]').addClass('view');
                    $('[data-modal="edit_table"]').find('[name="number"]').val(response.data.number);
                    $('[data-modal="edit_table"]').find('[name="name"]').val(response.data.name);
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });

    $('[data-modal="edit_table"]').modal().onCancel(function()
    {
        $('[data-modal="edit_table"]').find('form')[0].reset();
        $('[data-modal="edit_table"]').find('label.error').removeClass('error');
        $('[data-modal="edit_table"]').find('p.error').remove();
    });

    $('[data-modal="edit_table"]').modal().onSuccess(function()
    {
        $('[data-modal="edit_table"]').find('form').submit();
    });

    $('form[name="edit_table"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&id=' + id + '&action=edit_table',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="success"]').addClass('view');
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    setTimeout(function() { location.reload(); }, 1500);
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

    $(document).on('click', '[data-action="delete_table"]', function()
    {
        id = $(this).data('id');
        $('[data-modal="delete_table"]').addClass('view');
    });

    $('[data-modal="delete_table"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_table',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="success"]').addClass('view');
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    setTimeout(function() { location.reload(); }, 1500);
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });
});
