'use strict';

$(document).ready(function()
{
    var id;
    var key;

    $('.multi-tabs').multiTabs();

    // var tbl_survey_answers = $('#tbl_survey_answers').DataTable({
    //     ordering: false,
    //     autoWidth: false,
    //     pageLength: 25,
    //     info: false,
    // });
    //
    // var tbl_survey_subanswers = $('#tbl_survey_subanswers').DataTable({
    //     ordering: false,
    //     autoWidth: false,
    //     pageLength: 25,
    //     info: false,
    // });
    //
    // var tbl_survey_comments = $('#tbl_survey_comments').DataTable({
    //     ordering: false,
    //     autoWidth: false,
    //     pageLength: 25,
    //     info: false,
    // });

    var tbl_survey_questions = $('#tbl_survey_questions').DataTable({
        ordering: false,
        autoWidth: false,
        pageLength: 25,
        info: false,
    });

    // $(document).on('click', '#tbl_survey_comments > tbody > tr', function()
    // {
    //     var id = $(this).attr('name');
    //
    //     $('[data-modal="show_survey"]').addClass('view');
    //     id = $(this).data('id');
    //
    //        $.ajax({
    //            type: 'POST',
    //            data: 'id=' + id + '&action=get_survey',
    //            processData: false,
    //            cache: false,
    //            dataType: 'json',
    //            success: function(response)
    //            {
    //                if (response.status == 'success')
    //                {
    //
    //                }
    //                else if (response.status == 'error')
    //                {
    //                    $('[data-modal="error"]').find('main > p').html(response.message);
    //                    $('[data-modal="error"]').addClass('view');
    //                }
    //            }
    //        });
    // });

    $('[data-action="new_survey_question"]').on('click', function()
    {
        $('form[name="new_survey_question"]').submit();
    });

    $('form[name="new_survey_question"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=new_survey_question',
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

    $(document).on('click','[data-action="edit_survey_question"]', function()
    {
        id = $(this).data('id');

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
                    $('form[name="edit_survey_question"]').find('[name="survey_question_es"]').val(response.data.question.es);
                    $('form[name="edit_survey_question"]').find('[name="survey_question_en"]').val(response.data.question.en);
                    $('[data-modal="edit_survey_question"]').addClass('view');
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').find('main > p').html(response.message);
                    $('[data-modal="error"]').addClass('view');
                }
            }
        });
    });

    $('[data-modal="edit_survey_question"]').modal().onSuccess(function()
    {
        $('form[name="edit_survey_question"]').submit();
    });

    $('form[name="edit_survey_question"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&id=' + id + '&action=edit_survey_question',
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

    $(document).on('click', '[data-action="deactivate_survey_question"]', function()
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

    $(document).on('click', '[data-action="activate_survey_question"]', function()
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

    $(document).on('click','[data-action="new_survey_subquestion"]', function()
    {
        id = $(this).data('id');

        $('[data-modal="new_survey_subquestion"]').addClass('view');
    });

    $('[data-modal="new_survey_subquestion"]').modal().onSuccess(function()
    {
        $('form[name="new_survey_subquestion"]').submit();
    });

    $('form[name="new_survey_subquestion"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&id=' + id + '&action=new_survey_subquestion',
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

    $(document).on('click','[data-action="edit_survey_subquestion"]', function()
    {
        id = $(this).data('id');
        key = $(this).data('key');

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&key=' + key + '&action=get_survey_subquestion',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('form[name="edit_survey_subquestion"]').find('[name="survey_subquestion_es"]').val(response.data.subquestion.es);
                    $('form[name="edit_survey_subquestion"]').find('[name="survey_subquestion_en"]').val(response.data.subquestion.en);
                    $('form[name="edit_survey_subquestion"]').find('[name="type"][value="' + response.data.type + '"]').attr('checked', true);
                    $('[data-modal="edit_survey_subquestion"]').addClass('view');
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').find('main > p').html(response.message);
                    $('[data-modal="error"]').addClass('view');
                }
            }
        });
    });

    $('[data-modal="edit_survey_subquestion"]').modal().onSuccess(function()
    {
        $('form[name="edit_survey_subquestion"]').submit();
    });

    $('form[name="edit_survey_subquestion"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&id=' + id + '&key=' + key + '&action=edit_survey_subquestion',
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

    $(document).on('click', '[data-action="deactivate_survey_subquestion"]', function()
    {
        id = $(this).data('id');
        key = $(this).data('key');

        $('[data-modal="deactivate_survey_subquestion"]').addClass('view');
    });

    $('[data-modal="deactivate_survey_subquestion"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&key=' + key + '&action=deactivate_survey_subquestion',
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

    $(document).on('click', '[data-action="activate_survey_subquestion"]', function()
    {
        id = $(this).data('id');
        key = $(this).data('key');

        $('[data-modal="activate_survey_subquestion"]').addClass('view');
    });

    $('[data-modal="activate_survey_subquestion"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&key=' + key + '&action=activate_survey_subquestion',
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

    // $(document).on('click', '[data-action="delete_survey_subquestion"]', function()
    // {
    //     id = $(this).data('id');
    //     $('[data-modal="delete_survey_subquestion"]').addClass('view');
    // });
    //
    // $('[data-modal="delete_survey_subquestion"]').modal().onSuccess(function()
    // {
    //     $.ajax({
    //         type: 'POST',
    //         data: 'id=' + id + '&action=delete_survey_subquestion',
    //         processData: false,
    //         cache: false,
    //         dataType: 'json',
    //         success: function(response)
    //         {
    //             if (response.status == 'success')
    //             {
    //                 $('[data-modal="success"]').find('main > p').html(response.message);
    //                 $('[data-modal="success"]').addClass('view');
    //                 $('[data-modal="delete_survey_subquestion"]').removeClass('view');
    //                 $('#tbl_survey_questions').find('tbody').html(response.data);
    //
    //                 setTimeout(function() {
    //
    //                     $('[data-modal="success"]').find('main > p').html(response.message);
    //                     $('[data-modal="success"]').removeClass('view');
    //
    //                 }, 1500);
    //             }
    //             else if (response.status == 'error')
    //             {
    //                 $('[data-modal="error"]').find('main > p').html(response.message);
    //                 $('[data-modal="error"]').addClass('view');
    //             }
    //         }
    //     });
    // });
    //
    //
    // // $(document).on('click', '#tbl_survey_questions > tbody > tr > td', function()
    // // {
    // //     id = $(this).data('id');
    // //
    // //     $.ajax({
    // //         type: 'POST',
    // //         data: 'id=' + id + '&action=get_survey_subquestion',
    // //         processData: false,
    // //         cache: false,
    // //         dataType: 'json',
    // //         success: function(response)
    // //         {
    // //             console.log(id);
    // //
    // //             if (response.status == 'success')
    // //             {
    // //
    // //             }
    // //             else if (response.status == 'error')
    // //             {
    // //                 $('[data-modal="error"]').find('main > p').html(response.message);
    // //                 $('[data-modal="error"]').addClass('view');
    // //             }
    // //         }
    // //     });
    // // });
    //
    // $('[data-action="edit_survey_title"]').on('click', function()
    // {
    //     $('form[name="edit_survey_title"]').submit();
    // });
    //
    // $('form[name="edit_survey_title"]').on('submit', function(e)
    // {
    //     e.preventDefault();
    //
    //     var form = $(this);
    //
    //     $.ajax({
    //         type: 'POST',
    //         data: form.serialize() + '&action=edit_survey_title',
    //         processData: false,
    //         cache: false,
    //         dataType: 'json',
    //         success: function(response)
    //         {
    //             $('label.error').removeClass('error');
    //             $('p.error').remove();
    //
    //             if (response.status == 'success')
    //             {
    //                 $('[data-modal="success"]').find('main > p').html(response.message);
    //                 $('[data-modal="success"]').addClass('view');
    //                 $('[name="survey_title_es"]').val(response.title.es);
    //                 $('[name="survey_title_en"]').val(response.title.en);
    //
    //                 setTimeout(function() {
    //
    //                     $('[data-modal="success"]').find('main > p').html('');
    //                     $('[data-modal="success"]').removeClass('view');
    //
    //                 }, 1500);
    //             }
    //             else if (response.status == 'error')
    //             {
    //                 if (response.labels)
    //                 {
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
    //                     $('[data-modal="error"]').find('main > p').html(response.message);
    //                     $('[data-modal="error"]').addClass('view');
    //                 }
    //             }
    //         }
    //     });
    // });
});
