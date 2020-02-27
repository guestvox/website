'use strict';

$(document).ready(function()
{
    var tbl_myvox_information = $('#tbl_myvox_information').DataTable({
        ordering: false,
        pageLength: 25,
        info: false
    });

    $('[name="tbl_myvox_information_search"]').on('keyup', function()
    {
        tbl_myvox_information.search(this.value).draw();
    });

    var id;
    var edit = false;

    $('[data-modal="new_myvox_information"]').modal().onCancel(function()
    {
        id = null;
        edit = false;
        $('[data-modal="new_myvox_information"]').removeClass('edit');
        $('[data-modal="new_myvox_information"]').addClass('new');
        $('[data-modal="new_myvox_information"]').find('header > h3').html('Nuevo');
        $('[data-modal="new_myvox_information"]').find('form')[0].reset();
        $('[data-modal="new_myvox_information"]').find('label.error').removeClass('error');
        $('[data-modal="new_myvox_information"]').find('p.error').remove();
    });

    $('[name="logotype"]').parents('.uploader').find('a').on('click', function()
    {
        $('[name="logotype"]').click();
    });

    $('[name="logotype"]').on('change', function()
    {
        var preview = $(this).parents('.uploader').find('img');

        if ($(this)[0].files[0].type.match($(this).attr('accept')))
        {
            var reader = new FileReader();

            reader.onload = function(e)
            {
                preview.attr('src', e.target.result);
            }

            reader.readAsDataURL($(this)[0].files[0]);
        }
        else
        {
            $('[data-modal="error"]').addClass('view');
            $('[data-modal="error"]').find('main > p').html('ERROR FILE NOT PERMIT');
        }
    });

    $('[data-modal="new_myvox_information"]').modal().onSuccess(function()
    {
        $('[data-modal="new_myvox_information"]').find('form').submit();
    });

    $('form[name="new_myvox_information"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);
        var data = new FormData(form[0])

        if (edit == false)
            data.append('action', 'new_myvox_information');
        else if (edit == true)
        {
            data.append('id', id)
            data.append('action', 'edit_myvox_information');
        }

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

    $(document).on('click', '[data-action="edit_myvox_information"]', function()
    {
        id = $(this).data('id');
        edit = true;

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_myvox_information',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="new_myvox_information"]').removeClass('new');
                    $('[data-modal="new_myvox_information"]').addClass('edit');
                    $('[data-modal="new_myvox_information"]').addClass('view');
                    $('[data-modal="new_myvox_information"]').find('header > h3').html('Editar');
                    $('[data-modal="new_myvox_information"]').find('[name="name_es"]').val(response.data.name.es);
                    $('[data-modal="new_myvox_information"]').find('[name="name_en"]').val(response.data.name.en);
                    $('[data-modal="new_myvox_information"]').find('[name="description"]').val(response.data.description);
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });

    $(document).on('click', '[data-action="delete_myvox_information"]', function()
    {
        id = $(this).data('id');
        $('[data-modal="delete_myvox_information"]').addClass('view');
    });

    $('[data-modal="delete_myvox_information"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_myvox_information',
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
