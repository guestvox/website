'use strict';

$(document).ready(function()
{
    $('[data-modal="get_support"]').modal().onCancel(function()
    {
        $('[data-modal="get_support"]').find('form')[0].reset();
        $('[data-modal="get_support"]').find('label.error').removeClass('error');
        $('[data-modal="get_support"]').find('p.error').remove();
    });

    $('form[name="get_support"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=get_support',
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

    $('[data-action="edit_account"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'action=get_account',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="edit_account"]').addClass('view');

                    $('[data-modal="edit_account"]').find('[name="name"]').val(response.data.name);
                    $('[data-modal="edit_account"]').find('[name="country"]').val(response.data.country);
                    $('[data-modal="edit_account"]').find('[name="city"]').val(response.data.city);
                    $('[data-modal="edit_account"]').find('[name="zip_code"]').val(response.data.zip_code);
                    $('[data-modal="edit_account"]').find('[name="address"]').val(response.data.address);
                    $('[data-modal="edit_account"]').find('[name="time_zone"]').val(response.data.time_zone);
                    $('[data-modal="edit_account"]').find('[name="currency"]').val(response.data.currency);
                    $('[data-modal="edit_account"]').find('[name="language"]').val(response.data.language);

                    required_focus($('[data-modal="edit_account"]').find('form'), true);
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-modal="edit_account"]').modal().onCancel(function()
    {
        $('[data-modal="edit_account"]').find('form')[0].reset();
        $('[data-modal="edit_account"]').find('label.error').removeClass('error');
        $('[data-modal="edit_account"]').find('p.error').remove();
    });

    $('form[name="edit_account"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=edit_account',
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

    $('[data-action="edit_billing"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'action=get_account',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="edit_billing"]').addClass('view');

                    $('[data-modal="edit_billing"]').find('[name="fiscal_id"]').val(response.data.fiscal.id);
                    $('[data-modal="edit_billing"]').find('[name="fiscal_name"]').val(response.data.fiscal.name);
                    $('[data-modal="edit_billing"]').find('[name="fiscal_address"]').val(response.data.fiscal.address);
                    $('[data-modal="edit_billing"]').find('[name="contact_firstname"]').val(response.data.contact.firstname);
                    $('[data-modal="edit_billing"]').find('[name="contact_lastname"]').val(response.data.contact.lastname);
                    $('[data-modal="edit_billing"]').find('[name="contact_department"]').val(response.data.contact.department);
                    $('[data-modal="edit_billing"]').find('[name="contact_email"]').val(response.data.contact.email);
                    $('[data-modal="edit_billing"]').find('[name="contact_phone_lada"]').val(response.data.contact.phone.lada);
                    $('[data-modal="edit_billing"]').find('[name="contact_phone_number"]').val(response.data.contact.phone.number);

                    required_focus($('[data-modal="edit_billing"]').find('form'), true);
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-modal="edit_billing"]').modal().onCancel(function()
    {
        $('[data-modal="edit_billing"]').find('form')[0].reset();
        $('[data-modal="edit_billing"]').find('label.error').removeClass('error');
        $('[data-modal="edit_billing"]').find('p.error').remove();
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
                    show_modal_success(response.message, 1500);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    var status = '';

    $('#rqsw').on('change', function()
    {
        if ($(this).is(':checked'))
            status = true;

        $.ajax({
            type: 'POST',
            data: 'status=' + status + '&action=edit_myvox_request_settings',
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

    $('#insw').on('change', function()
    {
        if ($(this).is(':checked'))
            status = true;

        $.ajax({
            type: 'POST',
            data: 'status=' + status + '&action=edit_myvox_incident_settings',
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

    $('#susw').on('change', function()
    {
        if ($(this).is(':checked'))
        {
            $.ajax({
                type: 'POST',
                data: 'action=get_account',
                processData: false,
                cache: false,
                dataType: 'json',
                success: function(response)
                {
                    if (response.status == 'success')
                    {
                        status = true;

                        $('[data-modal="edit_myvox_survey_settings"]').addClass('view');

                        $('[data-modal="edit_myvox_survey_settings"]').find('[name="title_es"]').val(response.data.settings.myvox.survey.title.es);
                        $('[data-modal="edit_myvox_survey_settings"]').find('[name="title_en"]').val(response.data.settings.myvox.survey.title.en);
                        $('[data-modal="edit_myvox_survey_settings"]').find('[name="mail_subject_es"]').val(response.data.settings.myvox.survey.mail.subject.es);
                        $('[data-modal="edit_myvox_survey_settings"]').find('[name="mail_subject_en"]').val(response.data.settings.myvox.survey.mail.subject.en);
                        $('[data-modal="edit_myvox_survey_settings"]').find('[name="mail_description_es"]').val(response.data.settings.myvox.survey.mail.description.es);
                        $('[data-modal="edit_myvox_survey_settings"]').find('[name="mail_description_en"]').val(response.data.settings.myvox.survey.mail.description.en);
                        $('[data-modal="edit_myvox_survey_settings"]').find('[name="mail_image"]').parents('[data-uploader]').find('[data-preview] > img').attr('src', ((response.data.settings.myvox.survey.mail.image) ? '../uploads/' + response.data.settings.myvox.survey.mail.image : '../images/empty.png'));

                        var att = '../images/empty.png';

                        if (response.data.settings.myvox.survey.mail.attachment)
                        {
                            att = response.data.settings.myvox.survey.mail.attachment.split('.');
                            att = att[1].toUpperCase();

                            if (att == 'PNG' || att == 'JPG' || att == 'JPEG')
                                att = '../uploads/' + response.data.settings.myvox.survey.mail.attachment;
                            else if (att == 'PDF')
                                att = '../images/pdf.png';
                            else if (att == 'DOC' || att == 'DOCX')
                                att = '../images/word.png';
                            else if (att == 'XLS' || att == 'XLSX')
                                att = '../images/excel.png';
                        }

                        $('[data-modal="edit_myvox_survey_settings"]').find('[name="mail_attachment"]').parents('[data-uploader]').find('[data-preview] > img').attr('src', att);
                        $('[data-modal="edit_myvox_survey_settings"]').find('[name="widget"]').val(response.data.settings.myvox.survey.widget);

                        required_focus($('[data-modal="edit_myvox_survey_settings"]').find('form'), true);
                    }
                    else if (response.status == 'error')
                        show_modal_error(response.message);
                }
            });
        }
        else
        {
            $.ajax({
                type: 'POST',
                data: 'status=' + status + '&action=edit_myvox_survey_settings',
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
        }
    });

    $('[data-modal="edit_myvox_survey_settings"]').modal().onCancel(function()
    {
        $('#susw').prop('checked', false);
        $('#susw').parent().removeClass('checked');

        $('[data-modal="edit_myvox_survey_settings"]').find('[data-uploader]').find('[data-preview] > img').attr('src', '../images/empty.png');

        $('[data-modal="edit_myvox_survey_settings"]').find('form')[0].reset();
        $('[data-modal="edit_myvox_survey_settings"]').find('label.error').removeClass('error');
        $('[data-modal="edit_myvox_survey_settings"]').find('p.error').remove();
    });

    $('form[name="edit_myvox_survey_settings"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);
        var data = new FormData(form[0]);

        data.append('status', status);
        data.append('action', 'edit_myvox_survey_settings');

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
                    show_modal_success(response.message, 1500);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('#rvsw').on('change', function()
    {
        if ($(this).is(':checked'))
        {
            $.ajax({
                type: 'POST',
                data: 'action=get_account',
                processData: false,
                cache: false,
                dataType: 'json',
                success: function(response)
                {
                    if (response.status == 'success')
                    {
                        status = true;

                        $('[data-modal="edit_reviews_settings"]').addClass('view');

                        $('[data-modal="edit_reviews_settings"]').find('[name="email"]').val(response.data.settings.reviews.email);
                        $('[data-modal="edit_reviews_settings"]').find('[name="phone_lada"]').val(response.data.settings.reviews.phone.lada);
                        $('[data-modal="edit_reviews_settings"]').find('[name="phone_number"]').val(response.data.settings.reviews.phone.number);
                        $('[data-modal="edit_reviews_settings"]').find('[name="website"]').val(response.data.settings.reviews.website);
                        $('[data-modal="edit_reviews_settings"]').find('[name="description_es"]').val(response.data.settings.reviews.description.es);
                        $('[data-modal="edit_reviews_settings"]').find('[name="description_en"]').val(response.data.settings.reviews.description.en);
                        $('[data-modal="edit_reviews_settings"]').find('[name="seo_keywords_es"]').val(response.data.settings.reviews.seo.keywords.es);
                        $('[data-modal="edit_reviews_settings"]').find('[name="seo_keywords_en"]').val(response.data.settings.reviews.seo.keywords.en);
                        $('[data-modal="edit_reviews_settings"]').find('[name="seo_description_es"]').val(response.data.settings.reviews.seo.description.es);
                        $('[data-modal="edit_reviews_settings"]').find('[name="seo_description_en"]').val(response.data.settings.reviews.seo.description.en);
                        $('[data-modal="edit_reviews_settings"]').find('[name="social_media_facebook"]').val(response.data.settings.reviews.social_media.facebook);
                        $('[data-modal="edit_reviews_settings"]').find('[name="social_media_instagram"]').val(response.data.settings.reviews.social_media.instagram);
                        $('[data-modal="edit_reviews_settings"]').find('[name="social_media_twitter"]').val(response.data.settings.reviews.social_media.twitter);
                        $('[data-modal="edit_reviews_settings"]').find('[name="social_media_linkedin"]').val(response.data.settings.reviews.social_media.linkedin);
                        $('[data-modal="edit_reviews_settings"]').find('[name="social_media_youtube"]').val(response.data.settings.reviews.social_media.youtube);
                        $('[data-modal="edit_reviews_settings"]').find('[name="social_media_google"]').val(response.data.settings.reviews.social_media.google);
                        $('[data-modal="edit_reviews_settings"]').find('[name="social_media_tripadvisor"]').val(response.data.settings.reviews.social_media.tripadvisor);

                        required_focus($('[data-modal="edit_reviews_settings"]').find('form'), true);
                    }
                    else if (response.status == 'error')
                        show_modal_error(response.message);
                }
            });
        }
        else
        {
            $.ajax({
                type: 'POST',
                data: 'status=' + status + '&action=edit_reviews_settings',
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
        }
    });

    $('[data-modal="edit_reviews_settings"]').modal().onCancel(function()
    {
        $('#rvsw').prop('checked', false);
        $('#rvsw').parent().removeClass('checked');

        $('[data-modal="edit_reviews_settings"]').find('form')[0].reset();
        $('[data-modal="edit_reviews_settings"]').find('label.error').removeClass('error');
        $('[data-modal="edit_reviews_settings"]').find('p.error').remove();
    });

    $('form[name="edit_reviews_settings"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&status=' + status + '&action=edit_reviews_settings',
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
});
