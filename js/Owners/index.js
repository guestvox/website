'use strict';

$(document).ready(function()
{
    $('[name="type"]').on('change', function()
    {
        if ($(this).val() == 'one')
        {
            $('form[name="new_owner"]').find('[name="number"]').parent().parent().parent().removeClass('hidden');
            $('form[name="new_owner"]').find('[name="since"]').parent().parent().parent().addClass('hidden');
            $('form[name="new_owner"]').find('[name="to"]').parent().parent().parent().addClass('hidden');
        }
        else if ($(this).val() == 'many')
        {
            $('form[name="new_owner"]').find('[name="number"]').parent().parent().parent().addClass('hidden');
            $('form[name="new_owner"]').find('[name="since"]').parent().parent().parent().removeClass('hidden');
            $('form[name="new_owner"]').find('[name="to"]').parent().parent().parent().removeClass('hidden');
        }
    });

    var id = null;
    var edit = false;

    $('[data-modal="new_owner"]').modal().onCancel(function()
    {
        id = null;
        edit = false;

        $('[data-modal="new_owner"]').find('[name="type"]').parent().parent().parent().removeClass('hidden');
        $('[data-modal="new_owner"]').find('[name="number"]').parent().parent().parent().removeClass('hidden');
        $('[data-modal="new_owner"]').find('[name="since"]').parent().parent().parent().addClass('hidden');
        $('[data-modal="new_owner"]').find('[name="to"]').parent().parent().parent().addClass('hidden');

        $('[data-modal="new_owner"]').find('form')[0].reset();
        $('[data-modal="new_owner"]').find('label.error').removeClass('error');
        $('[data-modal="new_owner"]').find('p.error').remove();

        required_focus($('[data-modal="new_owner"]').find('form'), true);
    });

    $('form[name="new_owner"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        if (edit == false)
            var data = '&action=new_owner';
        else if (edit == true)
            var data = '&id=' + id + '&action=edit_owner';

        $.ajax({
            type: 'POST',
            data: form.serialize() + data,
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 1500);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('[data-action="edit_owner"]').on('click', function()
    {
        id = $(this).data('id');
        edit = true;

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_owner',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="new_owner"]').addClass('view');

                    $('[data-modal="new_owner"]').find('[name="type"]').parent().parent().parent().addClass('hidden');
                    $('[data-modal="new_owner"]').find('[name="number"]').parent().parent().parent().removeClass('hidden');
                    $('[data-modal="new_owner"]').find('[name="since"]').parent().parent().parent().addClass('hidden');
                    $('[data-modal="new_owner"]').find('[name="to"]').parent().parent().parent().addClass('hidden');

                    $('[data-modal="new_owner"]').find('[name="name_es"]').val(response.data.name.es);
                    $('[data-modal="new_owner"]').find('[name="name_en"]').val(response.data.name.en);
                    $('[data-modal="new_owner"]').find('[name="number"]').val(response.data.number);
                    $('[data-modal="new_owner"]').find('[name="request"]').prop('checked', ((response.data.request == true) ? true : false));
                    $('[data-modal="new_owner"]').find('[name="incident"]').prop('checked', ((response.data.incident == true) ? true : false));
                    $('[data-modal="new_owner"]').find('[name="workorder"]').prop('checked', ((response.data.workorder == true) ? true : false));
                    $('[data-modal="new_owner"]').find('[name="survey"]').prop('checked', ((response.data.survey == true) ? true : false));
                    $('[data-modal="new_owner"]').find('[name="public"]').prop('checked', ((response.data.public == true) ? true : false));

                    required_focus($('[data-modal="new_owner"]').find('form'), true);
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="deactivate_owner"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="deactivate_owner"]').addClass('view');
    });

    $('[data-modal="deactivate_owner"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=deactivate_owner',
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
    });

    $('[data-action="activate_owner"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="activate_owner"]').addClass('view');
    });

    $('[data-modal="activate_owner"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=activate_owner',
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
    });

    $('[data-action="delete_owner"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="delete_owner"]').addClass('view');
    });

    $('[data-modal="delete_owner"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_owner',
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
    });
});
