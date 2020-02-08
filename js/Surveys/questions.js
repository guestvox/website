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
        $('[data-modal="new_survey_question"]').find('input[type="radio"]').attr('disabled', false);
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

        if (edit == false)
        {
            if (level == 1)
                var data = '&id=' + id + '&level=' + level + '&action=new_survey_subquestion';
            else if (level == 2)
                var data = '&id=' + id + '&subkey=' + subkey + '&level=' + level + '&action=new_survey_subquestion';
            else
                var data = '&action=new_survey_question';
        }
        else if (edit == true)
        {
            if (level == 1)
                var data = '&id=' + id + '&action=edit_survey_question';
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
                    $('[data-modal="new_survey_question"]').find('[name="type"][value="' + response.data.type + '"]').prop('checked', true);

                    // if (response.data.type == 'check')
                    // {
                    //     if (response.data.name.values.length != 0)
                    //     {
                    //         $('[data-modal="new_survey_question"]').find('input[value="rate"]').attr('disabled', true);
                    //         $('[data-modal="new_survey_question"]').find('input[value="twin"]').attr('disabled', true);
                    //         $('[data-modal="new_survey_question"]').find('input[value="open"]').attr('disabled', true);
                    //     }
                    // }
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
        {
            if (type == 'check')
                var data = 'id=' + id + '&subkey=' + subkey + '&level=' + level + '&action=deactivate_survey_check';
            else
                var data = 'id=' + id + '&subkey=' + subkey + '&level=' + level + '&action=deactivate_survey_subquestion';
        }
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
        {
            if (type == 'check')
                var data = 'id=' + id + '&subkey=' + subkey + '&level=' + level + '&action=activate_survey_check';
            else
                var data = 'id=' + id + '&subkey=' + subkey + '&level=' + level + '&action=activate_survey_subquestion';
        }
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
        {
            if (type == 'check')
                var data = 'id=' + id + '&subkey=' + subkey + '&level=' + level + '&action=delete_survey_check';
            else
                var data = 'id=' + id + '&subkey=' + subkey + '&level=' + level + '&action=delete_survey_subquestion';
        }
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
        $('[data-modal="new_survey_question"]').addClass('view');
    });

    // $(document).on('click', '[data-action="new_survey_check"]', function()
    // {
    //     level = $(this).parent().parent().data('level');
    //     id = $(this).data('id');
    //     subkey = $(this).data('subkey');
    //     $('[data-modal="new_survey_check"]').addClass('view');
    // });
    //
    // $('[data-modal="new_survey_check"]').modal().onCancel(function()
    // {
    //     level = null;
    //     id = null;
    //     subkey = null;
    //     parentkey = null;
    //     edit = false;
    //     $('[data-modal="new_survey_check"]').removeClass('edit');
    //     $('[data-modal="new_survey_check"]').addClass('new');
    //     $('[data-modal="new_survey_check"]').find('header > h3').html('Nuevo');
    //     $('[data-modal="new_survey_check"]').find('form')[0].reset();
    //     $('[data-modal="new_survey_check"]').find('label.error').removeClass('error');
    //     $('[data-modal="new_survey_check"]').find('p.error').remove();
    // });
    //
    // $('[data-modal="new_survey_check"]').modal().onSuccess(function()
    // {
    //     $('[data-modal="new_survey_check"]').find('form').submit();
    // });
    //
    // $('form[name="new_survey_check"]').on('submit', function(e)
    // {
    //     e.preventDefault();
    //
    //     var form = $(this);
    //
    //     if (edit == false)
    //     {
    //         if (level == 1)
    //             var data = '&id=' + id + '&level=' + level + '&action=new_survey_check';
    //         // else if (level == 2)
    //         //     var data = '&id=' + id + '&subkey=' + subkey + '&level=' + level + '&action=new_survey_subquestion';
    //         // else
    //         //     var data = '&action=new_survey_question';
    //     }
    //     else if (edit == true)
    //     {
    //         var data = '&id=' + id + '&subkey=' + subkey + '&level=' + level + '&action=edit_survey_check';
    //     }
    //
    //     $.ajax({
    //         type: 'POST',
    //         data: form.serialize() + data,
    //         processData: false,
    //         cache: false,
    //         dataType: 'json',
    //         success: function(response)
    //         {
    //             if (response.status == 'success')
    //             {
    //                 $('[data-modal="success"]').addClass('view');
    //                 $('[data-modal="success"]').find('main > p').html(response.message);
    //                 setTimeout(function() { location.reload(); }, 1500);
    //             }
    //             else if (response.status == 'error')
    //             {
    //                 if (response.labels)
    //                 {
    //                     form.find('label.error').removeClass('error');
    //                     form.find('p.error').remove();
    //
    //                     $.each(response.labels, function(i, label)
    //                     {
    //                         if (label[1].length > 0)
    //                             form.find('[name="' + label[0] + '"]').parents('label').addClass('error').append('<p class="error">' + label[1] + '</p>');
    //                         else
    //                             form.find('[name="' + label[0] + '"]').parents('label').addClass('error');
    //                     });
    //
    //                     form.find('label.error [name]')[0].focus();
    //                 }
    //                 else if (response.message)
    //                 {
    //                     $('[data-modal="error"]').addClass('view');
    //                     $('[data-modal="error"]').find('main > p').html(response.message);
    //                 }
    //             }
    //         }
    //     });
    // });
    //
    // $(document).on('click', '[data-action="edit_survey_check"]', function()
    // {
    //     level = $(this).parent().parent().data('level');
    //     id = $(this).data('id');
    //     subkey = $(this).data('subkey');
    //     parentkey = $(this).data('parentkey');
    //     edit = true;
    //
    //     $.ajax({
    //         type: 'POST',
    //         data: 'id=' + id + '&action=get_survey_question',
    //         processData: false,
    //         cache: false,
    //         dataType: 'json',
    //         success: function(response)
    //         {
    //             if (response.status == 'success')
    //             {
    //                 $('[data-modal="new_survey_check"]').removeClass('new');
    //                 $('[data-modal="new_survey_check"]').addClass('edit');
    //                 $('[data-modal="new_survey_check"]').addClass('view');
    //                 $('[data-modal="new_survey_check"]').find('header > h3').html('Editar');
    //
    //                 if (level == 2)
    //                 {
    //                     $('[data-modal="new_survey_check"]').find('[name="name_es"]').val(response.data.name.values[subkey].name.es);
    //                     $('[data-modal="new_survey_check"]').find('[name="name_en"]').val(response.data.name.values[subkey].name.en);
    //                 }
    //             }
    //             else if (response.status == 'error')
    //             {
    //                 $('[data-modal="error"]').addClass('view');
    //                 $('[data-modal="error"]').find('main > p').html(response.message);
    //             }
    //         }
    //     });
    // });
    //
    // $(document).on('click', '[data-action="deactivate_survey_check"]', function()
    // {
    //     level = $(this).parent().parent().data('level');
    //     id = $(this).data('id');
    //     subkey = $(this).data('subkey');
    //     parentkey = $(this).data('parentkey');
    //     type = 'check';
    //     $('[data-modal="deactivate_survey_question"]').addClass('view');
    // });
    //
    // $(document).on('click', '[data-action="activate_survey_check"]', function()
    // {
    //     level = $(this).parent().parent().data('level');
    //     id = $(this).data('id');
    //     subkey = $(this).data('subkey');
    //     parentkey = $(this).data('parentkey');
    //     type = 'check';
    //     $('[data-modal="activate_survey_question"]').addClass('view');
    // });
    //
    // $(document).on('click', '[data-action="delete_survey_check"]', function()
    // {
    //     level = $(this).parent().parent().data('level');
    //     id = $(this).data('id');
    //     subkey = $(this).data('subkey');
    //     parentkey = $(this).data('parentkey');
    //     type = 'check';
    //     $('[data-modal="delete_survey_question"]').addClass('view');
    // });

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
