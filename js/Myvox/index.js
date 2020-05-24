'use strict';

$(document).ready(function()
{
    var type;

    $('[data-action="new_vox"]').on('click', function()
    {
        type = $(this).data('type');

        $.ajax({
            type: 'POST',
            data: 'type=' + type + '&action=get_opt_owners',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    $('[name="owner"]').html(response.html);
            }
        });

        $.ajax({
            type: 'POST',
            data: 'type=' + type + '&action=get_opt_opportunity_areas',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    $('[name="opportunity_area"]').html(response.html);
            }
        });

        $.ajax({
            type: 'POST',
            data: 'type=' + type + '&action=get_opt_locations',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    $('[name="location"]').html(response.html);
            }
        });

        if (type == 'request')
        {
            $('[data-modal="new_vox"]').find('[name="observations"]').parent().parent().parent().removeClass('hidden');
            $('[data-modal="new_vox"]').find('[name="subject"]').parent().parent().parent().addClass('hidden');
        }
        else if (type == 'incident')
        {
            $('[data-modal="new_vox"]').find('[name="observations"]').parent().parent().parent().addClass('hidden');
            $('[data-modal="new_vox"]').find('[name="subject"]').parent().parent().parent().removeClass('hidden');
        }

        $('[data-modal="new_vox"]').addClass('view');
    });

    $('[name="owner"]').on('change', function()
    {
        $.ajax({
            type: 'POST',
            data: 'owner=' + $(this).val() + '&action=get_owner',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response) { }
        });
    });

    $('[name="opportunity_area"]').on('change', function()
    {
        $.ajax({
            type: 'POST',
            data: 'opportunity_area=' + $(this).val() + '&type=' + type + '&action=get_opt_opportunity_types',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[name="opportunity_type"]').html(response.html);
                    $('[name="opportunity_type"]').attr('disabled', false);
                }
            }
        });
    });

    $('[data-modal="new_vox"]').modal().onCancel(function()
    {
        $('[data-modal="new_vox"]').find('form')[0].reset();
        $('[data-modal="new_vox"]').find('[name="observations"]').parent().parent().parent().addClass('hidden');
        $('[data-modal="new_vox"]').find('[name="subject"]').parent().parent().parent().addClass('hidden');
        $('[data-modal="new_vox"]').find('label.error').removeClass('error');
        $('[data-modal="new_vox"]').find('p.error').remove();
    });

    $('form[name="new_vox"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&type=' + type + '&action=new_vox',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="success"]').addClass('view');
                    $('[data-modal="success"]').find('main > p').html(response.message);
                    setTimeout(function() { location.reload(); }, 8000);
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

    $('[data-action="open_subquestion"]').on('change', function()
    {
        var name = $(this).attr('name');

        if ($(this).val() == '1' || $(this).val() == '2' || $(this).val() == '3' || $(this).val() == 'yes')
            $('#' + name).removeClass('hidden');
        else
        {
            $('#' + name).addClass('hidden');
            $('#' + name).find(':input').each(function() {
                if (this.type == 'text')
                    $(this).val('');
                else if (this.type == 'radio')
                    this.checked = false;
            });
        }
    });

    $('[data-action="open_subquestion_sub"]').on('change', function()
    {
        var name = $(this).attr('name');

        if ($(this).val() == '1' || $(this).val() == '2' || $(this).val() == '3' || $(this).val() == 'yes')
            $('#' + name).removeClass('hidden');
        else
        {
            $('#' + name).addClass('hidden');
            $('#' + name).find(':input').each(function() {
                if (this.type == 'text')
                    $(this).val('');
                else if (this.type == 'radio')
                    this.checked = false;
            });
        }
    });

    $('[data-modal="new_survey_answer"]').modal().onCancel(function()
    {
        $('[data-modal="new_survey_answer"]').find('form')[0].reset();
        $('[data-modal="new_survey_answer"]').find('label.error').removeClass('error');
        $('[data-modal="new_survey_answer"]').find('p.error').remove();
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
                if (response.status == 'success')
                {
                    $('[data-modal="success"]').addClass('view');
                    $('[data-modal="success"]').find('main > p').html(response.message);

                    if (response.data.widget == true)
                    {
                        setTimeout(function() {
                            $('[data-modal="success"]').removeClass('view');
                            $('[data-modal="new_survey_answer"]').removeClass('view');
                            $('[data-modal="new_survey_answer"]').find('form')[0].reset();
                            $('[data-modal="new_survey_answer"]').find('label.error').removeClass('error');
                            $('[data-modal="new_survey_answer"]').find('p.error').remove();
                            $('[data-modal="survey_widget"]').addClass('view');
                        }, 4000);
                    }
                    else
                        setTimeout(function() { location.reload(); }, 8000);
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
});
