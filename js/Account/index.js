'use strict';

$(document).ready(function()
{
    $('[data-image-select]').on('click', function()
    {
        $(this).parent().find('[data-image-upload]').click();
    });

    $('[data-image-upload]').on('change', function()
    {
        if ($(this)[0].files[0].type.match($(this).attr('accept')))
        {
            var data = new FormData();

            data.append('logotype', $(this)[0].files[0]);
            data.append('action', 'edit_logotype');

            $.ajax({
                type: 'POST',
                data: data,
                contentType: false,
                processData: false,
                cache: false,
                dataType: 'json',
                success: function(response)
                {
                    if (response.status == 'success')
                    {
                        $('[data-modal="success"]').addClass('view');
                        $('[data-modal="success"] main > p').html(response.message);
                        setTimeout(function() { location.reload(); }, 1500);
                    }
                    else if (response.status == 'error')
                    {
                        $('[data-modal="alert"]').addClass('view');
                        $('[data-modal="alert"] main > p').html(response.message);
                    }
                }
            });
        }
        else
        {
            $('[data-modal="error"]').addClass('view');
            $('[data-modal="error"]').find('main > p').html('Error de operación');
        }
    });

    $('[data-modal="edit_profile"]').modal().onSuccess(function()
    {
        $('[data-modal="edit_profile"]').find('form').submit();
    });

    $('form[name="edit_profile"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=edit_profile',
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

    $('[data-modal="edit_billing"]').modal().onSuccess(function()
    {
        $('[data-modal="edit_billing"]').find('form').submit();
    });

    $('form[name="edit_billing"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=edit_billing',
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

    $('#st-mv-survey').on('change', function()
    {
        if ($(this).is(':checked'))
        {
            $('[name="myvox_settings_survey_title_es"]').parent().parent().parent().removeClass('hidden');
            $('[name="myvox_settings_survey_title_en"]').parent().parent().parent().removeClass('hidden');
            $('[name="myvox_settings_survey_widget"]').parent().parent().parent().removeClass('hidden');
        }
        else
        {
            $('[name="myvox_settings_survey_title_es"]').parent().parent().parent().addClass('hidden');
            $('[name="myvox_settings_survey_title_en"]').parent().parent().parent().addClass('hidden');
            $('[name="myvox_settings_survey_widget"]').parent().parent().parent().addClass('hidden');
        }
    });

    $('[data-modal="edit_myvox_settings"]').modal().onSuccess(function()
    {
        $('[data-modal="edit_myvox_settings"]').find('form').submit();
    });

    $('form[name="edit_myvox_settings"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=edit_myvox_settings',
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

    $('#st-rv-online').on('change', function()
    {
        if ($(this).is(':checked'))
        {
            $('[name="review_settings_email"]').parent().parent().parent().removeClass('hidden');
            $('[name="review_settings_phone_lada"]').parent().parent().parent().removeClass('hidden');
            $('[name="review_settings_phone_number"]').parent().parent().parent().removeClass('hidden');
            $('[name="review_settings_description_es"]').parent().parent().parent().removeClass('hidden');
            $('[name="review_settings_description_en"]').parent().parent().parent().removeClass('hidden');
            $('[name="review_settings_seo_keywords_es"]').parent().parent().parent().removeClass('hidden');
            $('[name="review_settings_seo_keywords_en"]').parent().parent().parent().removeClass('hidden');
            $('[name="review_settings_seo_meta_description_es"]').parent().parent().parent().removeClass('hidden');
            $('[name="review_settings_seo_meta_description_en"]').parent().parent().parent().removeClass('hidden');
            $('[name="review_settings_website"]').parent().parent().parent().removeClass('hidden');
            $('[name="review_settings_social_media_facebook"]').parent().parent().parent().removeClass('hidden');
            $('[name="review_settings_social_media_instagram"]').parent().parent().parent().removeClass('hidden');
            $('[name="review_settings_social_media_twitter"]').parent().parent().parent().removeClass('hidden');
            $('[name="review_settings_social_media_linkedin"]').parent().parent().parent().removeClass('hidden');
            $('[name="review_settings_social_media_youtube"]').parent().parent().parent().removeClass('hidden');
            $('[name="review_settings_social_media_google"]').parent().parent().parent().removeClass('hidden');
            $('[name="review_settings_social_media_tripadvisor"]').parent().parent().parent().removeClass('hidden');
        }
        else
        {
            $('[name="review_settings_email"]').parent().parent().parent().addClass('hidden');
            $('[name="review_settings_phone_lada"]').parent().parent().parent().addClass('hidden');
            $('[name="review_settings_phone_number"]').parent().parent().parent().addClass('hidden');
            $('[name="review_settings_description_es"]').parent().parent().parent().addClass('hidden');
            $('[name="review_settings_description_en"]').parent().parent().parent().addClass('hidden');
            $('[name="review_settings_seo_keywords_es"]').parent().parent().parent().addClass('hidden');
            $('[name="review_settings_seo_keywords_en"]').parent().parent().parent().addClass('hidden');
            $('[name="review_settings_seo_meta_description_es"]').parent().parent().parent().addClass('hidden');
            $('[name="review_settings_seo_meta_description_en"]').parent().parent().parent().addClass('hidden');
            $('[name="review_settings_website"]').parent().parent().parent().addClass('hidden');
            $('[name="review_settings_social_media_facebook"]').parent().parent().parent().addClass('hidden');
            $('[name="review_settings_social_media_instagram"]').parent().parent().parent().addClass('hidden');
            $('[name="review_settings_social_media_twitter"]').parent().parent().parent().addClass('hidden');
            $('[name="review_settings_social_media_linkedin"]').parent().parent().parent().addClass('hidden');
            $('[name="review_settings_social_media_youtube"]').parent().parent().parent().addClass('hidden');
            $('[name="review_settings_social_media_google"]').parent().parent().parent().addClass('hidden');
            $('[name="review_settings_social_media_tripadvisor"]').parent().parent().parent().addClass('hidden');
        }
    });

    $('[data-modal="edit_review_settings"]').modal().onSuccess(function()
    {
        $('[data-modal="edit_review_settings"]').find('form').submit();
    });

    $('form[name="edit_review_settings"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=edit_review_settings',
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
});
