'use strict';

$(document).ready(function()
{
    var id;

    $('.multi-tabs').multiTabs();

    var tbl_questions = $('#questions').DataTable({
        ordering: false,
        autoWidth: false,
        pageLength: 25,
        info: false,
    });

    $('[data-action="new_question"]').on('click', function()
    {
        $('form[name="new_question"]').submit();
    });

    $('form[name="new_question"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=new_question',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                $('label.error').removeClass('error');
                $('p.error').remove();

                if (response.status == 'success')
                {
                    $('form[name="new_question"]')[0].reset();
                    $('label.error').removeClass('error');
                    $('p.error').remove();
                    $('#questions').find('tbody').html(response.data);
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    $('[data-modal="success"]').addClass('view');

                    // tbl_opportunity_areas.row.add([
                    //     "ABCD",
                    //     "1",
                    //     "1",
                    //     "1",
                    //     "1",
                    //     "1",3
                    // ]).draw();

                    setTimeout(function()
                    {
                        $('[data-modal="success"]').find('main > p').html('');
                        $('[data-modal="success"]').removeClass('view');

                    }, 1500);
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

    $(document).on('click','[data-action="edit_question"]', function()
    {
        id = $(this).data('id');

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=get_question',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('form[name="edit_question"]').find('[name="question_es"]').val(response.data.question.es);
                    $('form[name="edit_question"]').find('[name="question_en"]').val(response.data.question.en);

                    $('[data-modal="edit_question"]').addClass('view');
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').find('main > p').html(response.message);
                    $('[data-modal="error"]').addClass('view');
                }
            }
        });
    });

    $('[data-modal="edit_question"]').modal().onCancel(function()
    {
        $('label.error').removeClass('error');
        $('p.error').remove();
        $('form[name="edit_question"]')[0].reset();
    });

    $('[data-modal="edit_question"]').modal().onSuccess(function()
    {
        $('form[name="edit_question"]').submit();
    });

    $('form[name="edit_question"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&id=' + id + '&action=edit_question',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                $('label.error').removeClass('error');
                $('p.error').remove();

                if (response.status == 'success')
                {
                    $('form[name="edit_question"]')[0].reset();
                    $('#questions').find('tbody').html(response.data);
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    $('[data-modal="success"]').addClass('view');

                    setTimeout(function() {
                        $('[data-modal="success"]').find('main > p').html(response.message);
                        $('[data-modal="success"]').removeClass('view');
                        $('[data-modal="edit_question"]').removeClass('view');
                    }, 1500);
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

    $(document).on('click', '[data-action="delete_question"]', function()
    {
        id = $(this).data('id');

        $('[data-modal="delete_question"]').addClass('view');
    });

    $('[data-modal="delete_question"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=delete_question',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('#questions').find('tbody').html(response.data);
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    $('[data-modal="success"]').addClass('view');

                    setTimeout(function() {
                        $('[data-modal="success"]').find('main > p').html(response.message);
                        $('[data-modal="success"]').removeClass('view');
                        $('[data-modal="delete_question"]').removeClass('view');
                    }, 1500);
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
