'use strict';

var values = [];
var values_action = 'new';
var values_key = '';

$(document).ready(function()
{
    $(document).on('click', '.tbl_stl_5, [data-button-modal="new_survey_question"]', function(e)
    {
        e.stopPropagation();
    });

    $('[name="type"]').on('change', function()
    {
        if ($(this).val() == 'check')
            $('[name="value_es"]').parents('.tbl_stl_6').parent().removeClass('hidden');
        else
        {
            values = [];
            values_action = 'new';
            values_key = '';

            $('[name="value_es"]').val('');
            $('[name="value_en"]').val('');
            $('[name="value_es"]').parents('.tbl_stl_6').parent().addClass('hidden');
            $('[name="value_es"]').parents('.tbl_stl_6').find('[data-list]').html('');
        }
    });

    $('[data-action="add_to_values_table"]').on('click', function()
    {
        if ($('[name="value_es"]').val().length > 0 && $('[name="value_en"]').val().length > 0)
        {
            if (values_action == 'new')
            {
                var string = 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789';
                var token  = '';

                for (var x = 0; x < 8; x++)
                {
                    var math = Math.floor(Math.random() * string.length);
                    token += string.substr(math, 1);
                }

                values.push({
                    'token': token,
                    'es': $('[name="value_es"]').val(),
                    'en': $('[name="value_en"]').val()
                });
            }
            else if (values_action == 'edit')
            {
                values[values_key].es = $('[name="value_es"]').val();
                values[values_key].en = $('[name="value_en"]').val();
            }

            load_values_table_list();
            load_values_table_actions();
        }
    });

    var id = null;
    var edit = false;

    $('[data-modal="new_survey_question"]').modal().onCancel(function()
    {
        values = [];
        values_action = 'new';
        values_key = '';
        id = null;
        edit = false;

        $('[name="value_es"]').val('');
        $('[name="value_en"]').val('');
        $('[name="value_es"]').parents('.tbl_stl_6').parent().addClass('hidden');
        $('[name="value_es"]').parents('.tbl_stl_6').find('[data-list]').html('');

        clean_form($('form[name="new_survey_question"]'));
    });

    $('form[name="new_survey_question"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        if (edit == false)
            var data = '&values=' + JSON.stringify(values) + '&action=new_survey_question';
        else if (edit == true)
            var data = '&values=' + JSON.stringify(values) + '&id=' + id + '&action=edit_survey_question';

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

    $('[data-action="edit_survey_question"]').on('click', function()
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
                    $('[name="parent"]').val(response.data.parent);
                    $('[name="name_es"]').val(response.data.name.es);
                    $('[name="name_en"]').val(response.data.name.en);
                    $('[name="type"]').val(response.data.type);

                    if (response.data.type == 'check')
                    {
                        $('[name="value_es"]').parents('.tbl_stl_6').parent().removeClass('hidden');

                        values = response.data.values;

                        load_values_table_list();
                        load_values_table_actions();
                    }

                    required_focus('form', $('form[name="new_survey_question"]'), null);

                    $('[data-modal="new_survey_question"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="deactivate_survey_question"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="deactivate_survey_question"]').addClass('view');
    });

    $('[data-modal="deactivate_survey_question"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=deactivate_survey_question',
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

    $('[data-action="activate_survey_question"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="activate_survey_question"]').addClass('view');
    });

    $('[data-modal="activate_survey_question"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=activate_survey_question',
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

    $('[data-action="delete_survey_question"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="delete_survey_question"]').addClass('view');
    });

    $('[data-modal="delete_survey_question"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_survey_question',
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

function load_values_table_list()
{
    $('[name="value_es"]').parents('.tbl_stl_6').find('[data-list]').html('');

    $.each(values, function(key, value)
    {
        $('[name="value_es"]').parents('.tbl_stl_6').find('[data-list]').append(
            '<div>'
                + '<span>' + value.es + '</span>'
                + '<a data-action="up_in_values_table" data-key="' + key + '"><i class="fas fa-arrow-up"></i></a>'
                + '<a data-action="down_in_values_table" data-key="' + key + '"><i class="fas fa-arrow-down"></i></a>'
                + '<a class="edit" data-action="edit_to_values_table" data-key="' + key + '"><i class="fas fa-pen"></i></a>'
                + '<a class="delete" data-action="remove_to_values_table" data-key="' + key + '"><i class="fas fa-trash"></i></a>'
            + '</div>'
        );
    });

    values_action = 'new';
    values_key = '';

    $('[name="value_es"]').val('');
    $('[name="value_es"]').focus();
    $('[name="value_en"]').val('');
}

function load_values_table_actions()
{
    $('[data-action="remove_to_values_table"]').on('click', function()
    {
        values.splice($(this).data('key'), 1);

        load_values_table_list();
        load_values_table_actions();
    });

    $('[data-action="edit_to_values_table"]').on('click', function()
    {
        values_action = 'edit';
        values_key = $(this).data('key');

        $('[name="value_es"]').val(values[values_key].es);
        $('[name="value_en"]').val(values[values_key].en);
    });

    $('[data-action="up_in_values_table"]').on('click', function()
    {
        values_key = $(this).data('key');

        if (values_key > 0)
        {
            var values_data = values[values_key];
            var values_key_up = (values_key - 1);
            var values_data_up = values[values_key_up];
            values.splice(values_key_up, 1, values_data);
            values.splice(values_key, 1, values_data_up);

            load_values_table_list();
            load_values_table_actions();
        }
    });

    $('[data-action="down_in_values_table"]').on('click', function()
    {
        values_key = $(this).data('key');

        if (values_key < (values.length - 1))
        {
            var values_data = values[values_key];
            var values_key_down = (values_key + 1);
            var values_data_down = values[values_key_down];
            values.splice(values_key_down, 1, values_data);
            values.splice(values_key, 1, values_data_down);

            load_values_table_list();
            load_values_table_actions();
        }
    });
}
