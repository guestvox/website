'use strict';

$(document).ready(function()
{
    var tbl_survey_questions = $('#tbl_survey_questions').DataTable({
        ordering: false,
        pageLength: 25,
        info: false,
    });

    $(document).on('click', '[data-action="preview_survey_question"]', function()
    {
        $.ajax({
            type: 'POST',
            data: 'action=preview_survey_question',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="preview_survey_question"]').addClass('view');
                    $('[data-modal="preview_survey_question"]').find('main').html(response.data);
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });

    $('[name="tbl_survey_questions_search"]').on('keyup', function()
    {
        tbl_survey_questions.search(this.value).draw();
    });

    var id;
    var edit = false;
    var key;
    var sub = false;

    $('[data-modal="new_survey_question"]').modal().onCancel(function()
    {
        id = null;
        edit = false;
        key = null;
        sub = false;
        $('[data-modal="new_survey_question"]').removeClass('edit');
        $('[data-modal="new_survey_question"]').addClass('new');
        $('[data-modal="new_survey_question"]').find('header > h3').html('Nuevo');
        $('[data-modal="new_survey_question"]').find('form')[0].reset();
        $('[data-modal="new_survey_question"]').find('label.error').removeClass('error');
        $('[data-modal="new_survey_question"]').find('p.error').remove();
    });

    $('[data-modal="new_survey_question"]').modal().onSuccess(function()
    {
        $('[data-modal="new_survey_question"]').find('form').submit();
    });

    $('form[name="new_survey_question"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        if (sub == false)
        {
            if (edit == false)
                var data = '&action=new_survey_question';
            else if (edit == true)
                var data = '&id=' + id + '&action=edit_survey_question';
        }
        else if (sub == true)
        {
            if (edit == false)
                var data = '&id=' + id + '&action=new_survey_subquestion';
            else if (edit == true)
                var data = '&id=' + id + '&key=' + key + '&action=edit_survey_subquestion';
        }

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

    $(document).on('click', '[data-action="edit_survey_question"]', function()
    {
        id = $(this).data('id');
        edit = true;

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_survey_question',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="new_survey_question"]').removeClass('new');
                    $('[data-modal="new_survey_question"]').addClass('edit');
                    $('[data-modal="new_survey_question"]').addClass('view');
                    $('[data-modal="new_survey_question"]').find('header > h3').html('Editar');
                    $('[data-modal="new_survey_question"]').find('[name="name_es"]').val(response.data.name.es);
                    $('[data-modal="new_survey_question"]').find('[name="name_en"]').val(response.data.name.en);
                    $('[data-modal="new_survey_question"]').find('[name="type"][value="' + response.data.type + '"]').prop('checked', true);
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });

    $(document).on('click', '[data-action="deactivate_survey_question"]', function()
    {
        id = $(this).data('id');
        $('[data-modal="deactivate_survey_question"]').addClass('view');
    });

    $('[data-modal="deactivate_survey_question"]').modal().onSuccess(function()
    {
        if (sub == false)
            var data = 'id=' + id + '&action=deactivate_survey_question';
        else if (sub == true)
            var data = 'id=' + id + '&key=' + key + '&action=deactivate_survey_subquestion';

        $.ajax({
            type: 'POST',
            data: data,
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

    $(document).on('click', '[data-action="activate_survey_question"]', function()
    {
        id = $(this).data('id');
        $('[data-modal="activate_survey_question"]').addClass('view');
    });

    $('[data-modal="activate_survey_question"]').modal().onSuccess(function()
    {
        if (sub == false)
            var data = 'id=' + id + '&action=activate_survey_question';
        else if (sub == true)
            var data = 'id=' + id + '&key=' + key + '&action=activate_survey_subquestion';

        $.ajax({
            type: 'POST',
            data: data,
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

    $(document).on('click', '[data-action="delete_survey_question"]', function()
    {
        id = $(this).data('id');
        $('[data-modal="delete_survey_question"]').addClass('view');
    });

    $('[data-modal="delete_survey_question"]').modal().onSuccess(function()
    {
        if (sub == false)
            var data = 'id=' + id + '&action=delete_survey_question';
        else if (sub == true)
            var data = 'id=' + id + '&key=' + key + '&action=delete_survey_subquestion';

        $.ajax({
            type: 'POST',
            data: data,
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

    $(document).on('click', '[data-action="new_survey_subquestion"]', function()
    {
        id = $(this).data('id');
        sub = true;
        $('[data-modal="new_survey_question"]').addClass('view');
    });

    $(document).on('click', '[data-action="edit_survey_subquestion"]', function()
    {
        id = $(this).data('id');
        key = $(this).data('key');
        edit = true;
        sub = true;

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_survey_question',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="new_survey_question"]').removeClass('new');
                    $('[data-modal="new_survey_question"]').addClass('edit');
                    $('[data-modal="new_survey_question"]').addClass('view');
                    $('[data-modal="new_survey_question"]').find('header > h3').html('Editar');
                    $('[data-modal="new_survey_question"]').find('[name="name_es"]').val(response.data.subquestions[key].name.es);
                    $('[data-modal="new_survey_question"]').find('[name="name_en"]').val(response.data.subquestions[key].name.en);
                    $('[data-modal="new_survey_question"]').find('[name="type"][value="' + response.data.subquestions[key].type + '"]').prop('checked', true);
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });

    $(document).on('click', '[data-action="deactivate_survey_subquestion"]', function()
    {
        id = $(this).data('id');
        key = $(this).data('key');
        sub = true;
        $('[data-modal="deactivate_survey_question"]').addClass('view');
    });

    $(document).on('click', '[data-action="activate_survey_subquestion"]', function()
    {
        id = $(this).data('id');
        key = $(this).data('key');
        sub = true;
        $('[data-modal="activate_survey_question"]').addClass('view');
    });

    $(document).on('click', '[data-action="delete_survey_subquestion"]', function()
    {
        id = $(this).data('id');
        key = $(this).data('key');
        sub = true;
        $('[data-modal="delete_survey_question"]').addClass('view');
    });
});
