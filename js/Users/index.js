'use strict';

$(document).ready(function()
{
    var tbl_users = $('#tbl_users').DataTable({
        ordering: false,
        pageLength: 25,
        info: false
    });

    $('[name="tbl_users_search"]').on('keyup', function()
    {
        tbl_users.search(this.value).draw();
    });

    $('[data-action="get_password_user"]').on('click', function()
    {
        var target = $(this).parent().find('[name="password"]');

        $.ajax({
            type: 'POST',
            data: 'action=get_password_user',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    target.val(response.data);
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });

    $('[name="user_level"]').on('change', function()
    {
        $('[data-modal="new_user"]').find('[name="user_permissions[]"]').prop('checked', false);

        if ($(this).val() > 0)
        {
            $.ajax({
                type: 'POST',
                data: 'id=' + $(this).val() + '&action=get_user_level',
                processData: false,
                cache: false,
                dataType: 'json',
                success: function(response)
                {
                    if (response.status == 'success')
                    {
                        $.each(response.data.user_permissions, function (key, value)
                        {
                            $('[data-modal="new_user"]').find('[name="user_permissions[]"][value="' + value + '"]').prop('checked', true);
                        });
                    }
                    else if (response.status == 'error')
                    {
                        $('[data-modal="error"]').addClass('view');
                        $('[data-modal="error"]').find('main > p').html(response.message);
                    }
                }
            });
        }
    });

    $(document).on('change', '[name="checked_all"]', function()
    {
        if ($(this).prop('checked') == true)
            $(this).parent().parent().find('[type="checkbox"]').prop('checked', true);
        else if ($(this).prop('checked') == false)
            $(this).parent().parent().find('[type="checkbox"]').prop('checked', false);
    });

    $(document).on('change', '[type="checkbox"]', function()
    {
        if ($(this).prop('checked') == false)
            $(this).parent().parent().find('[name="checked_all"]').prop('checked', false);
    });

    var id;
    var edit = false;

    $('[data-modal="new_user"]').modal().onCancel(function()
    {
        id = null;
        edit = false;
        $('[data-modal="new_user"]').removeClass('edit');
        $('[data-modal="new_user"]').addClass('new');
        $('[data-modal="new_user"]').find('header > h3').html('Nuevo');
        $('[data-modal="new_user"]').find('form')[0].reset();
        $('[data-modal="new_user"]').find('label.error').removeClass('error');
        $('[data-modal="new_user"]').find('p.error').remove();
        $('[data-modal="new_user"]').find('[name="username"]').parent().parent().parent().removeClass('span12');
        $('[data-modal="new_user"]').find('[name="username"]').parent().parent().parent().addClass('span6');
        $('[data-modal="new_user"]').find('[name="password"]').parent().parent().parent().removeClass('hidden');
    });

    $('[data-modal="new_user"]').modal().onSuccess(function()
    {
        $('[data-modal="new_user"]').find('form').submit();
    });

    $('form[name="new_user"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        if (edit == false)
            var data = '&action=new_user';
        else if (edit == true)
            var data = '&id=' + id + '&action=edit_user';

        $.ajax({
            type: 'POST',
            data: form.serialize() + data,
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

    $(document).on('click', '[data-action="edit_user"]', function()
    {
        id = $(this).data('id');
        edit = true;

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_user',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="new_user"]').removeClass('new');
                    $('[data-modal="new_user"]').addClass('edit');
                    $('[data-modal="new_user"]').addClass('view');
                    $('[data-modal="new_user"]').find('header > h3').html('Editar');
                    $('[data-modal="new_user"]').find('[name="firstname"]').val(response.data.firstname);
                    $('[data-modal="new_user"]').find('[name="lastname"]').val(response.data.lastname);
                    $('[data-modal="new_user"]').find('[name="email"]').val(response.data.email);
                    $('[data-modal="new_user"]').find('[name="phone_lada"]').val(response.data.phone.lada);
                    $('[data-modal="new_user"]').find('[name="phone_number"]').val(response.data.phone.number);
                    $('[data-modal="new_user"]').find('[name="username"]').parent().parent().parent().removeClass('span6');
                    $('[data-modal="new_user"]').find('[name="username"]').parent().parent().parent().addClass('span12');
                    $('[data-modal="new_user"]').find('[name="username"]').val(response.data.username);
                    $('[data-modal="new_user"]').find('[name="password"]').parent().parent().parent().addClass('hidden');

                    $.each(response.data.user_permissions, function (key, value)
                    {
                        $('[data-modal="new_user"]').find('[name="user_permissions[]"][value="' + value + '"]').prop('checked', true);
                    });

                    $.each(response.data.opportunity_areas, function (key, value)
                    {
                        $('[data-modal="new_user"]').find('[name="opportunity_areas[]"][value="' + value + '"]').prop('checked', true);
                    });
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });

    $(document).on('click', '[data-action="restore_password_user"]', function()
    {
        id = $(this).data('id');
        $('[data-modal="restore_password_user"]').addClass('view');
    });

    $('[data-modal="restore_password_user"]').modal().onCancel(function()
    {
        $('[data-modal="restore_password_user"]').find('form')[0].reset();
        $('[data-modal="restore_password_user"]').find('label.error').removeClass('error');
        $('[data-modal="restore_password_user"]').find('p.error').remove();
    });

    $('[data-modal="restore_password_user"]').modal().onSuccess(function()
    {
        $('[data-modal="restore_password_user"]').find('form').submit();
    });

    $('form[name="restore_password_user"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&id=' + id + '&action=restore_password_user',
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

    $(document).on('click', '[data-action="deactivate_user"]', function()
    {
        id = $(this).data('id');
        $('[data-modal="deactivate_user"]').addClass('view');
    });

    $('[data-modal="deactivate_user"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=deactivate_user',
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

    $(document).on('click', '[data-action="activate_user"]', function()
    {
        id = $(this).data('id');
        $('[data-modal="activate_user"]').addClass('view');
    });

    $('[data-modal="activate_user"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=activate_user',
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

    $(document).on('click', '[data-action="delete_user"]', function()
    {
        id = $(this).data('id');
        $('[data-modal="delete_user"]').addClass('view');
    });

    $('[data-modal="delete_user"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_user',
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
