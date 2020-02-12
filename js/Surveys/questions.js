'use strict';

$(document).ready(function()
{
    var tbl_survey_questions = $('#tbl_survey_questions').DataTable({
        ordering: false,
        pageLength: 25,
        info: false
    });

    $('[name="tbl_survey_questions_search"]').on('keyup', function()
    {
        tbl_survey_questions.search(this.value).draw();
    });

    $('[data-action="get_preview_survey"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'action=get_preview_survey',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="get_preview_survey"]').addClass('view');
                    $('[data-modal="get_preview_survey"]').find('main').html(response.data);
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });

    $('[name="type"]').on('change', function()
    {
        if ($(this).val() == 'check')
            $('#check').removeClass('hidden');
        else
        {
            $('#check').addClass('hidden');
            $('[name="check_name_es"]').val('');
            $('[name="check_name_en"]').val('');
        }
    });

    var values = [];
    var values_action = 'new';
    var values_key = null;

    $('[data-action="new_check_value"]').on('click', function()
    {
        var form = $('form[name="new_survey_question"]');

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=new_check_value',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                form.find('label.error').removeClass('error');
                form.find('p.error').remove();

                if (response.status == 'success')
                {
                    if (values_action == 'new')
                    {
                        values.push({
                            'es': $('[name="check_name_es"]').val(),
                            'en': $('[name="check_name_en"]').val()
                        });
                    }
                    else if (values_action == 'edit')
                    {
                        values[values_key].es = $('[name="check_name_es"]').val();
                        values[values_key].en = $('[name="check_name_en"]').val();
                    }

                    load_check_values_list();
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
                        $('[data-modal="error"]').addClass('view');
                        $('[data-modal="error"]').find('main > p').html(response.message);
                    }
                }
            }
        });
    });

    function load_check_values_list()
    {
        $('#check > div.list').html('');

        for (var i = 0; i < values.length; i++)
        {
            $('#check > div.list').append(
                '<div>'
                + '<span>' + values[i]['es'] + '</span>'
                + '<a data-action="up_check_value" data-key="' + i + '"><i class="fas fa-arrow-up"></i></a>'
                + '<a data-action="down_check_value" data-key="' + i + '"><i class="fas fa-arrow-down"></i></a>'
                + '<a class="delete" data-action="delete_check_value" data-key="' + i + '"><i class="fas fa-trash-alt"></i></a>'
                + '<a class="edit" data-action="edit_check_value" data-key="' + i + '"><i class="fas fa-pen"></i></a>'
                + '</div>'
            );
        }

        values_action = 'new';
        values_key = null;
        $('[name="check_name_es"]').val('');
        $('[name="check_name_en"]').val('');

        setter_check_clicks();
    }

    function setter_check_clicks()
    {
        $('[data-action="edit_check_value"]').each(function( index )
        {
            $(this).on('click', function()
            {
                values_action = 'edit';
                values_key = $(this).data('key');
                $('[name="check_name_es"]').val(values[values_key].es);
                $('[name="check_name_en"]').val(values[values_key].en);
            });
        });

        $('[data-action="delete_check_value"]').each(function( index )
        {
            $(this).on('click', function()
            {
                values.splice($(this).data('key'), 1);

                load_check_values_list();
            });
        });

        $('[data-action="up_check_value"]').each(function( index )
        {
            $(this).on('click', function()
            {
                values_key = $(this).data('key');

                if (values_key > 0)
                {
                    var values_data = values[values_key];
                    var values_key_up = (values_key - 1);
                    var values_data_up = values[values_key_up];
                    values.splice(values_key_up, 1, values_data);
                    values.splice(values_key, 1, values_data_up);

                    load_check_values_list();
                }
            });
        });

        $('[data-action="down_check_value"]').each(function( index )
        {
            $(this).on('click', function()
            {
                values_key = $(this).data('key');

                if (values_key < (values.length - 1))
                {
                    var values_data = values[values_key];
                    var values_key_down = (values_key + 1);
                    var values_data_down = values[values_key_down];
                    values.splice(values_key_down, 1, values_data);
                    values.splice(values_key, 1, values_data_down);

                    load_check_values_list();
                }
            });
        });
    }

    var level;
    var id;
    var subkey;
    var parentkey;
    var type = '';
    var edit = false;

    $('[data-modal="new_survey_question"]').modal().onCancel(function()
    {
        level = null;
        id = null;
        subkey = null;
        parentkey = null;
        edit = false;
        values = [];
        values_action = 'new';
        values_key = null;
        $('[data-modal="new_survey_question"]').removeClass('edit');
        $('[data-modal="new_survey_question"]').addClass('new');
        $('[data-modal="new_survey_question"]').find('header > h3').html('Nuevo');
        $('[data-modal="new_survey_question"]').find('form')[0].reset();
        $('[data-modal="new_survey_question"]').find('input[type="radio"]').attr('disabled', false);
        $('[data-modal="new_survey_question"]').find('#check').addClass('hidden');
        $('[data-modal="new_survey_question"]').find('#check > div.list').html('');
        $('[data-modal="new_survey_question"]').find('[name="type"][value="check"]').parent().removeClass('hidden');
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

        if (edit == false)
        {
            if (level == 1)
                var data = '&id=' + id + '&level=' + level + '&action=new_survey_subquestion';
            else if (level == 2)
                var data = '&id=' + id + '&subkey=' + subkey + '&level=' + level + '&action=new_survey_subquestion';
            else
                var data = '&values=' + JSON.stringify(values) + '&action=new_survey_question';
        }
        else if (edit == true)
        {
            if (level == 1)
                var data = '&id=' + id + '&values=' + JSON.stringify(values) +  '&action=edit_survey_question';
            else if (level == 2)
                var data = '&id=' + id + '&subkey=' + subkey + '&level=' + level + '&action=edit_survey_subquestion';
            else if (level == 3)
                var data = '&id=' + id + '&subkey=' + subkey + '&parentkey=' + parentkey + '&level=' + level + '&action=edit_survey_subquestion';
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
        level = $(this).parent().parent().data('level');
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

                    if (response.data.type == 'check')
                    {
                        values = response.data.values;
                        load_check_values_list();
                        $('[data-modal="new_survey_question"]').find('#check').removeClass('hidden');
                    }

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
        level = $(this).parent().parent().data('level');
        id = $(this).data('id');
        $('[data-modal="deactivate_survey_question"]').addClass('view');
    });

    $('[data-modal="deactivate_survey_question"]').modal().onSuccess(function()
    {
        if (level == 1)
            var data = 'id=' + id + '&action=deactivate_survey_question';
        else if (level == 2)
            var data = 'id=' + id + '&subkey=' + subkey + '&level=' + level + '&action=deactivate_survey_subquestion';
        else if (level == 3)
            var data = 'id=' + id + '&subkey=' + subkey + '&parentkey=' + parentkey + '&level=' + level + '&action=deactivate_survey_subquestion';

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
        level = $(this).parent().parent().data('level');
        id = $(this).data('id');
        $('[data-modal="activate_survey_question"]').addClass('view');
    });

    $('[data-modal="activate_survey_question"]').modal().onSuccess(function()
    {
        if (level == 1)
            var data = 'id=' + id + '&action=activate_survey_question';
        else if (level == 2)
            var data = 'id=' + id + '&subkey=' + subkey + '&level=' + level + '&action=activate_survey_subquestion';
        else if (level == 3)
            var data = 'id=' + id + '&subkey=' + subkey + '&parentkey=' + parentkey + '&level=' + level + '&action=activate_survey_subquestion';

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
        level = $(this).parent().parent().data('level');
        id = $(this).data('id');
        $('[data-modal="delete_survey_question"]').addClass('view');
    });

    $('[data-modal="delete_survey_question"]').modal().onSuccess(function()
    {
        if (level == 1)
            var data = 'id=' + id + '&action=delete_survey_question';
        else if (level == 2)
            var data = 'id=' + id + '&subkey=' + subkey + '&level=' + level + '&action=delete_survey_subquestion';
        else if (level == 3)
            var data = 'id=' + id + '&subkey=' + subkey + '&parentkey=' + parentkey + '&level=' + level + '&action=delete_survey_subquestion';

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
        level = $(this).parent().parent().data('level');
        id = $(this).data('id');
        subkey = $(this).data('subkey');
        $('[data-modal="new_survey_question"]').find('[name="type"][value="check"]').parent().addClass('hidden');
        $('[data-modal="new_survey_question"]').addClass('view');
    });

    $(document).on('click', '[data-action="edit_survey_subquestion"]', function()
    {
        level = $(this).parent().parent().data('level');
        id = $(this).data('id');
        subkey = $(this).data('subkey');
        parentkey = $(this).data('parentkey');
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

                    if (level == 2)
                    {
                        $('[data-modal="new_survey_question"]').find('[name="name_es"]').val(response.data.subquestions[subkey].name.es);
                        $('[data-modal="new_survey_question"]').find('[name="name_en"]').val(response.data.subquestions[subkey].name.en);
                        $('[data-modal="new_survey_question"]').find('[name="type"][value="' + response.data.subquestions[subkey].type + '"]').prop('checked', true);
                    }
                    else if (level == 3)
                    {
                        $('[data-modal="new_survey_question"]').find('[name="name_es"]').val(response.data.subquestions[subkey].subquestions[parentkey].name.es);
                        $('[data-modal="new_survey_question"]').find('[name="name_en"]').val(response.data.subquestions[subkey].subquestions[parentkey].name.en);
                        $('[data-modal="new_survey_question"]').find('[name="type"][value="' + response.data.subquestions[subkey].subquestions[parentkey].type + '"]').prop('checked', true);
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

    $(document).on('click', '[data-action="deactivate_survey_subquestion"]', function()
    {
        level = $(this).parent().parent().data('level');
        id = $(this).data('id');
        subkey = $(this).data('subkey');
        parentkey = $(this).data('parentkey');
        $('[data-modal="deactivate_survey_question"]').addClass('view');
    });

    $(document).on('click', '[data-action="activate_survey_subquestion"]', function()
    {
        level = $(this).parent().parent().data('level');
        id = $(this).data('id');
        subkey = $(this).data('subkey');
        parentkey = $(this).data('parentkey');
        $('[data-modal="activate_survey_question"]').addClass('view');
    });

    $(document).on('click', '[data-action="delete_survey_subquestion"]', function()
    {
        level = $(this).parent().parent().data('level');
        id = $(this).data('id');
        subkey = $(this).data('subkey');
        parentkey = $(this).data('parentkey');
        $('[data-modal="delete_survey_question"]').addClass('view');
    });
});
