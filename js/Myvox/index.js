'use strict';

$(document).ready(function()
{
    $(document).on('change', '[important] [name]', function()
    {
        if ($(this).val() != '')
        {
            $(this).parents('label').addClass('success');
            $(this).parents('label.error').removeClass('error');
            $(this).parents('label').find('p.error').remove();
        }
        else
            $(this).parents('label').removeClass('success');
    });

    $('[name="opportunity_area"]').on('change', function()
    {
        $.ajax({
            type: 'POST',
            data: 'opportunity_area=' + $(this).val() + '&option=' + $(this).data('type') + '&action=get_opt_opportunity_types',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[name="opportunity_type"]').html(response.data);
                    $('[name="opportunity_type"]').attr('disabled', false);
                }
            }
        });
    });

    $('[data-modal="new_request"]').modal().onCancel(function()
    {
        $('label.error').removeClass('error');
        $('p.error').remove();
        $('form[name="new_request"]')[0].reset();
    });

    $('[data-modal="new_request"]').modal().onSuccess(function()
    {
        $('form[name="new_request"]').submit();
    });

    $('form[name="new_request"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=new_request',
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

                    setTimeout(function() { window.location.href = response.path; }, 3000);
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

    $('[data-modal="new_incident"]').modal().onCancel(function()
    {
        $('label.error').removeClass('error');
        $('p.error').remove();
        $('form[name="new_incident"]')[0].reset();
    });

    $('[data-modal="new_incident"]').modal().onSuccess(function()
    {
        $('form[name="new_incident"]').submit();
    });

    $('form[name="new_incident"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=new_incident',
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

                    setTimeout(function() { window.location.href = response.path; }, 3000);
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

    $('[data-action="open_subquestion"]').on('change', function()
    {
        var name = $(this).attr('name');

        console.log($(this).val());

        if ($(this).val() == '1' || $(this).val() == '2' || $(this).val() == '3' || $(this).val() == 'no')
            $('#' + name).removeClass('hidden');
        else
            $('#' + name).addClass('hidden');
    });

    $('[data-modal="new_survey_answer"]').modal().onCancel(function()
    {
        $('label.error').removeClass('error');
        $('p.error').remove();
        $('form[name="new_survey_answer"]')[0].reset();
    });

    $('[data-modal="new_survey_answer"]').modal().onSuccess(function()
    {
        $('form[name="new_survey_answer"]').submit();
    });

    $('form[name="new_survey_answer"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=new_survey_answer',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                $('label.error').removeClass('error');
                $('p.error').remove();

                if (response.status == 'success')
                {
                    $('[data-modal="new_survey_answer"]').removeClass('view');
                    $('[data-modal="tripadvisor"]').addClass('view');
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
});
