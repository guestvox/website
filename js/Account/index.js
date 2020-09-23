'use strict';

$(document).ready(function()
{
    $('.chosen-select').chosen();

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
                    $('[data-modal="edit_account"]').find('[name="name"]').val(response.data.name);
                    $('[data-modal="edit_account"]').find('[name="country"]').val(response.data.country);
                    $('[data-modal="edit_account"]').find('[name="city"]').val(response.data.city);
                    $('[data-modal="edit_account"]').find('[name="zip_code"]').val(response.data.zip_code);
                    $('[data-modal="edit_account"]').find('[name="address"]').val(response.data.address);
                    $('[data-modal="edit_account"]').find('[name="time_zone"]').val(response.data.time_zone);
                    $('[data-modal="edit_account"]').find('[name="currency"]').val(response.data.currency);
                    $('[data-modal="edit_account"]').find('[name="language"]').val(response.data.language);

                    required_focus('form', $('form[name="edit_account"]'), null);

                    $('[data-modal="edit_account"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-modal="edit_account"]').modal().onCancel(function()
    {
        clean_form($('form[name="edit_account"]'));
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
                    show_modal_success(response.message, 600);
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
                    $('[data-modal="edit_billing"]').find('[name="fiscal_id"]').val(response.data.fiscal.id);
                    $('[data-modal="edit_billing"]').find('[name="fiscal_name"]').val(response.data.fiscal.name);
                    $('[data-modal="edit_billing"]').find('[name="fiscal_address"]').val(response.data.fiscal.address);
                    $('[data-modal="edit_billing"]').find('[name="contact_firstname"]').val(response.data.contact.firstname);
                    $('[data-modal="edit_billing"]').find('[name="contact_lastname"]').val(response.data.contact.lastname);
                    $('[data-modal="edit_billing"]').find('[name="contact_department"]').val(response.data.contact.department);
                    $('[data-modal="edit_billing"]').find('[name="contact_email"]').val(response.data.contact.email);
                    $('[data-modal="edit_billing"]').find('[name="contact_phone_lada"]').val(response.data.contact.phone.lada);
                    $('[data-modal="edit_billing"]').find('[name="contact_phone_number"]').val(response.data.contact.phone.number);

                    required_focus('form', $('form[name="edit_billing"]'), null);

                    $('[data-modal="edit_billing"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-modal="edit_billing"]').modal().onCancel(function()
    {
        clean_form($('form[name="edit_billing"]'));
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
                    show_modal_success(response.message, 600);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    var status = '';
    var edit = false;

    $('#rqsw').on('change', function()
    {
        if ($(this).is(':checked'))
            get_myvox_request_settings();
        else
        {
            $.ajax({
                type: 'POST',
                data: 'status=' + status + '&action=edit_myvox_request_settings',
                processData: false,
                cache: false,
                dataType: 'json',
                success: function(response)
                {
                    if (response.status == 'success')
                        location.reload();
                    else if (response.status == 'error')
                        show_modal_error(response.message);
                }
            });
        }
    });

    $('[data-action="edit_myvox_request_settings"]').on('click', function()
    {
        edit = true;

        get_myvox_request_settings();
    });

    function get_myvox_request_settings()
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

                    $('[data-modal="edit_myvox_request_settings"]').find('[name="title_es"]').val(response.data.settings.myvox.request.title.es);
                    $('[data-modal="edit_myvox_request_settings"]').find('[name="title_en"]').val(response.data.settings.myvox.request.title.en);

                    required_focus('form', $('form[name="edit_myvox_request_settings"]'), null);

                    $('[data-modal="edit_myvox_request_settings"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    }

    $('[data-modal="edit_myvox_request_settings"]').modal().onCancel(function()
    {
        if (edit == false)
        {
            $('#rqsw').prop('checked', false);
            $('#rqsw').parent().removeClass('checked');
        }

        status = '';
        edit = false;

        clean_form($('form[name="edit_myvox_request_settings"]'));
    });

    $('form[name="edit_myvox_request_settings"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&status=' + status + '&action=edit_myvox_request_settings',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 600);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('#insw').on('change', function()
    {
        if ($(this).is(':checked'))
            get_myvox_incident_settings();
        else
        {
            $.ajax({
                type: 'POST',
                data: 'status=' + status + '&action=edit_myvox_incident_settings',
                processData: false,
                cache: false,
                dataType: 'json',
                success: function(response)
                {
                    if (response.status == 'success')
                        location.reload();
                    else if (response.status == 'error')
                        show_modal_error(response.message);
                }
            });
        }
    });

    $('[data-action="edit_myvox_incident_settings"]').on('click', function()
    {
        edit = true;

        get_myvox_incident_settings();
    });

    function get_myvox_incident_settings()
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

                    $('[data-modal="edit_myvox_incident_settings"]').find('[name="title_es"]').val(response.data.settings.myvox.incident.title.es);
                    $('[data-modal="edit_myvox_incident_settings"]').find('[name="title_en"]').val(response.data.settings.myvox.incident.title.en);

                    required_focus('form', $('form[name="edit_myvox_incident_settings"]'), null);

                    $('[data-modal="edit_myvox_incident_settings"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    }

    $('[data-modal="edit_myvox_incident_settings"]').modal().onCancel(function()
    {
        if (edit == false)
        {
            $('#insw').prop('checked', false);
            $('#insw').parent().removeClass('checked');
        }

        status = '';
        edit = false;

        clean_form($('form[name="edit_myvox_incident_settings"]'));
    });

    $('form[name="edit_myvox_incident_settings"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&status=' + status + '&action=edit_myvox_incident_settings',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 600);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('#mnsw').on('change', function()
    {
        if ($(this).is(':checked'))
            get_myvox_menu_settings();
        else
        {
            $.ajax({
                type: 'POST',
                data: 'status=' + status + '&action=edit_myvox_menu_settings',
                processData: false,
                cache: false,
                dataType: 'json',
                success: function(response)
                {
                    if (response.status == 'success')
                        location.reload();
                    else if (response.status == 'error')
                        show_modal_error(response.message);
                }
            });
        }
    });

    $('[data-action="edit_myvox_menu_settings"]').on('click', function()
    {
        edit = true;

        get_myvox_menu_settings();
    });

    function get_myvox_menu_settings()
    {
        $.ajax({
            type: 'POST',
            data: 'action=get_account',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response1)
            {
                if (response1.status == 'success')
                {
                    status = true;

                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="title_es"]').val(response1.data.settings.myvox.menu.title.es);
                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="title_en"]').val(response1.data.settings.myvox.menu.title.en);
                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="currency"]').val(response1.data.settings.myvox.menu.currency);
                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="opportunity_area"]').val(response1.data.settings.myvox.menu.opportunity_area);

                    $.ajax({
                        type: 'POST',
                        data: 'opportunity_area=' + response1.data.settings.myvox.menu.opportunity_area + '&action=get_opt_opportunity_types',
                        processData: false,
                        cache: false,
                        dataType: 'json',
                        success: function(response2)
                        {
                            if (response2.status == 'success')
                            {
                                $('[data-modal="edit_myvox_menu_settings"]').find('[name="opportunity_type"]').html(response2.html);
                                $('[data-modal="edit_myvox_menu_settings"]').find('[name="opportunity_type"]').attr('disabled', ((response1.data.settings.myvox.menu.opportunity_type != '') ? false : true));
                                $('[data-modal="edit_myvox_menu_settings"]').find('[name="opportunity_type"]').val(response1.data.settings.myvox.menu.opportunity_type);

                                required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="opportunity_type"]'), null);
                            }
                            else if (response2.status == 'error')
                                show_modal_error(response2.message);
                        }
                    });

                    if (response1.data.type == 'restaurant')
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="delivery"]').prop('checked', ((response1.data.settings.myvox.menu.delivery == true) ? true : false));

                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="requests"]').prop('checked', ((response1.data.settings.myvox.menu.requests == true) ? true : false));

                    if (response1.data.settings.myvox.menu.schedule.monday.status == 'open')
                    {
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_opening"]').parent().attr('required', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_closing"]').parent().attr('required', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_opening"]').parent().removeAttr('unrequired');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_closing"]').parent().removeAttr('unrequired');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_opening"]').attr('disabled', false);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_closing"]').attr('disabled', false);
                    }
                    else
                    {
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_opening"]').parent().attr('unrequired', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_closing"]').parent().attr('unrequired', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_opening"]').parent().removeAttr('required');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_closing"]').parent().removeAttr('required');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_opening"]').attr('disabled', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_closing"]').attr('disabled', true);
                    }

                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_status"]').val(response1.data.settings.myvox.menu.schedule.monday.status);
                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_opening"]').val(response1.data.settings.myvox.menu.schedule.monday.opening);
                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_closing"]').val(response1.data.settings.myvox.menu.schedule.monday.closing);

                    if (response1.data.settings.myvox.menu.schedule.tuesday.status == 'open')
                    {
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]').parent().attr('required', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]').parent().attr('required', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]').parent().removeAttr('unrequired');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]').parent().removeAttr('unrequired');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]').attr('disabled', false);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]').attr('disabled', false);
                    }
                    else
                    {
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]').parent().attr('unrequired', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]').parent().attr('unrequired', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]').parent().removeAttr('required');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]').parent().removeAttr('required');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]').attr('disabled', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]').attr('disabled', true);
                    }

                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_status"]').val(response1.data.settings.myvox.menu.schedule.tuesday.status);
                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]').val(response1.data.settings.myvox.menu.schedule.tuesday.opening);
                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]').val(response1.data.settings.myvox.menu.schedule.tuesday.closing);

                    if (response1.data.settings.myvox.menu.schedule.wednesday.status == 'open')
                    {
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]').parent().attr('required', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]').parent().attr('required', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]').parent().removeAttr('unrequired');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]').parent().removeAttr('unrequired');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]').attr('disabled', false);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]').attr('disabled', false);
                    }
                    else
                    {
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]').parent().attr('unrequired', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]').parent().attr('unrequired', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]').parent().removeAttr('required');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]').parent().removeAttr('required');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]').attr('disabled', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]').attr('disabled', true);
                    }

                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_status"]').val(response1.data.settings.myvox.menu.schedule.wednesday.status);
                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]').val(response1.data.settings.myvox.menu.schedule.wednesday.opening);
                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]').val(response1.data.settings.myvox.menu.schedule.wednesday.closing);

                    if (response1.data.settings.myvox.menu.schedule.thursday.status == 'open')
                    {
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]').parent().attr('required', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]').parent().attr('required', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]').parent().removeAttr('unrequired');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]').parent().removeAttr('unrequired');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]').attr('disabled', false);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]').attr('disabled', false);
                    }
                    else
                    {
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]').parent().attr('unrequired', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]').parent().attr('unrequired', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]').parent().removeAttr('required');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]').parent().removeAttr('required');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]').attr('disabled', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]').attr('disabled', true);
                    }

                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_status"]').val(response1.data.settings.myvox.menu.schedule.thursday.status);
                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]').val(response1.data.settings.myvox.menu.schedule.thursday.opening);
                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]').val(response1.data.settings.myvox.menu.schedule.thursday.closing);

                    if (response1.data.settings.myvox.menu.schedule.friday.status == 'open')
                    {
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]').parent().attr('required', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]').parent().attr('required', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]').parent().removeAttr('unrequired');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]').parent().removeAttr('unrequired');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]').attr('disabled', false);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]').attr('disabled', false);
                    }
                    else
                    {
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]').parent().attr('unrequired', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]').parent().attr('unrequired', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]').parent().removeAttr('required');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]').parent().removeAttr('required');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]').attr('disabled', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]').attr('disabled', true);
                    }

                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_status"]').val(response1.data.settings.myvox.menu.schedule.friday.status);
                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]').val(response1.data.settings.myvox.menu.schedule.friday.opening);
                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]').val(response1.data.settings.myvox.menu.schedule.friday.closing);

                    if (response1.data.settings.myvox.menu.schedule.saturday.status == 'open')
                    {
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]').parent().attr('required', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]').parent().attr('required', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]').parent().removeAttr('unrequired');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]').parent().removeAttr('unrequired');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]').attr('disabled', false);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]').attr('disabled', false);
                    }
                    else
                    {
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]').parent().attr('unrequired', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]').parent().attr('unrequired', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]').parent().removeAttr('required');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]').parent().removeAttr('required');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]').attr('disabled', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]').attr('disabled', true);
                    }

                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_status"]').val(response1.data.settings.myvox.menu.schedule.saturday.status);
                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]').val(response1.data.settings.myvox.menu.schedule.saturday.opening);
                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]').val(response1.data.settings.myvox.menu.schedule.saturday.closing);

                    if (response1.data.settings.myvox.menu.schedule.sunday.status == 'open')
                    {
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]').parent().attr('required', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]').parent().attr('required', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]').parent().removeAttr('unrequired');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]').parent().removeAttr('unrequired');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]').attr('disabled', false);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]').attr('disabled', false);
                    }
                    else
                    {
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]').parent().attr('unrequired', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]').parent().attr('unrequired', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]').parent().removeAttr('required');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]').parent().removeAttr('required');
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]').attr('disabled', true);
                        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]').attr('disabled', true);
                    }

                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_status"]').val(response1.data.settings.myvox.menu.schedule.sunday.status);
                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]').val(response1.data.settings.myvox.menu.schedule.sunday.opening);
                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]').val(response1.data.settings.myvox.menu.schedule.sunday.closing);
                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="multi"]').prop('checked', ((response1.data.settings.myvox.menu.multi == true) ? true : false));

                    required_focus('form', $('form[name="edit_myvox_menu_settings"]'), null);

                    $('[data-modal="edit_myvox_menu_settings"]').addClass('view');
                }
                else if (response1.status == 'error')
                    show_modal_error(response1.message);
            }
        });
    }

    $('[data-modal="edit_myvox_menu_settings"]').find('[name="opportunity_area"]').on('change', function()
    {
        $.ajax({
            type: 'POST',
            data: 'opportunity_area=' + $(this).val() + '&action=get_opt_opportunity_types',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="opportunity_type"]').html(response.html);
                    $('[data-modal="edit_myvox_menu_settings"]').find('[name="opportunity_type"]').attr('disabled', false);

                    required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="opportunity_type"]'), null)
                }
            }
        });
    });

    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_status"]').on('change', function()
    {
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_status"]').val($(this).val());
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_status"]').val($(this).val());
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_status"]').val($(this).val());
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_status"]').val($(this).val());
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_status"]').val($(this).val());
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_status"]').val($(this).val());

        if ($(this).val() == 'open')
        {
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_opening"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_closing"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_opening"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_closing"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_opening"]').attr('disabled', false);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_closing"]').attr('disabled', false);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]').attr('disabled', false);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]').attr('disabled', false);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]').attr('disabled', false);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]').attr('disabled', false);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]').attr('disabled', false);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]').attr('disabled', false);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]').attr('disabled', false);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]').attr('disabled', false);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]').attr('disabled', false);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]').attr('disabled', false);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]').attr('disabled', false);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]').attr('disabled', false);
        }
        else
        {
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_opening"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_closing"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_opening"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_closing"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_opening"]').attr('disabled', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_closing"]').attr('disabled', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]').attr('disabled', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]').attr('disabled', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]').attr('disabled', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]').attr('disabled', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]').attr('disabled', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]').attr('disabled', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]').attr('disabled', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]').attr('disabled', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]').attr('disabled', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]').attr('disabled', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]').attr('disabled', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]').attr('disabled', true);
        }

        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_opening"]').val('');
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_closing"]').val('');
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]').val('');
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]').val('');
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]').val('');
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]').val('');
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]').val('');
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]').val('');
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]').val('');
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]').val('');
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]').val('');
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]').val('');
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]').val('');
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]').val('');

        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_opening"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_closing"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]'), null);
    });

    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_opening"]').on('change', function()
    {
        if ($('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_status"]').val() == 'open')
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]').val($(this).val());

        if ($('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_status"]').val() == 'open')
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]').val($(this).val());

        if ($('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_status"]').val() == 'open')
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]').val($(this).val());

        if ($('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_status"]').val() == 'open')
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]').val($(this).val());

        if ($('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_status"]').val() == 'open')
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]').val($(this).val());

        if ($('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_status"]').val() == 'open')
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]').val($(this).val());

        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]'), null);
    });

    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_monday_closing"]').on('change', function()
    {
        if ($('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_status"]').val() == 'open')
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]').val($(this).val());

        if ($('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_status"]').val() == 'open')
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]').val($(this).val());

        if ($('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_status"]').val() == 'open')
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]').val($(this).val());

        if ($('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_status"]').val() == 'open')
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]').val($(this).val());

        if ($('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_status"]').val() == 'open')
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]').val($(this).val());

        if ($('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_status"]').val() == 'open')
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]').val($(this).val());

        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]'), null);
    });

    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_status"]').on('change', function()
    {
        if ($(this).val() == 'open')
        {
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]').attr('disabled', false);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]').attr('disabled', false);
        }
        else
        {
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]').attr('disabled', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]').attr('disabled', true);
        }

        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]').val('');
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]').val('');

        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_opening"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_tuesday_closing"]'), null);
    });

    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_status"]').on('change', function()
    {
        if ($(this).val() == 'open')
        {
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]').attr('disabled', false);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]').attr('disabled', false);
        }
        else
        {
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]').attr('disabled', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]').attr('disabled', true);
        }

        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]').val('');
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]').val('');

        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_opening"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_wednesday_closing"]'), null);
    });

    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_status"]').on('change', function()
    {
        if ($(this).val() == 'open')
        {
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]').attr('disabled', false);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]').attr('disabled', false);
        }
        else
        {
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]').attr('disabled', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]').attr('disabled', true);
        }

        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]').val('');
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]').val('');

        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_opening"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_thursday_closing"]'), null);
    });

    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_status"]').on('change', function()
    {
        if ($(this).val() == 'open')
        {
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]').attr('disabled', false);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]').attr('disabled', false);
        }
        else
        {
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]').attr('disabled', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]').attr('disabled', true);
        }

        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]').val('');
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]').val('');

        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_opening"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_friday_closing"]'), null);
    });

    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_status"]').on('change', function()
    {
        if ($(this).val() == 'open')
        {
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]').attr('disabled', false);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]').attr('disabled', false);
        }
        else
        {
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]').attr('disabled', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]').attr('disabled', true);
        }

        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]').val('');
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]').val('');

        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_opening"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_saturday_closing"]'), null);
    });

    $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_status"]').on('change', function()
    {
        if ($(this).val() == 'open')
        {
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]').parent().attr('required', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]').parent().removeAttr('unrequired');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]').attr('disabled', false);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]').attr('disabled', false);
        }
        else
        {
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]').parent().attr('unrequired', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]').parent().removeAttr('required');
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]').attr('disabled', true);
            $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]').attr('disabled', true);
        }

        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]').val('');
        $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]').val('');

        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_opening"]'), null);
        required_focus('input', $('[data-modal="edit_myvox_menu_settings"]').find('[name="schedule_sunday_closing"]'), null);
    });

    $('[data-modal="edit_myvox_menu_settings"]').modal().onCancel(function()
    {
        if (edit == false)
        {
            $('#mnsw').prop('checked', false);
            $('#mnsw').parent().removeClass('checked');
        }

        status = '';
        edit = false;

        clean_form($('form[name="edit_myvox_menu_settings"]'));
    });

    $('form[name="edit_myvox_menu_settings"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&status=' + status + '&action=edit_myvox_menu_settings',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 600);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('#susw').on('change', function()
    {
        if ($(this).is(':checked'))
            get_myvox_survey_settings();
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
                        location.reload();
                    else if (response.status == 'error')
                        show_modal_error(response.message);
                }
            });
        }
    });

    $('[data-action="edit_myvox_survey_settings"]').on('click', function()
    {
        edit = true;

        get_myvox_survey_settings();
    });

    function get_myvox_survey_settings()
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

                    required_focus('form', $('form[name="edit_myvox_survey_settings"]'), null);

                    $('[data-modal="edit_myvox_survey_settings"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    }

    $('[data-modal="edit_myvox_survey_settings"]').modal().onCancel(function()
    {
        if (edit == false)
        {
            $('#susw').prop('checked', false);
            $('#susw').parent().removeClass('checked');
        }

        status = '';
        edit = false;

        clean_form($('form[name="edit_myvox_survey_settings"]'));
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
                    show_modal_success(response.message, 600);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('#rvsw').on('change', function()
    {
        if ($(this).is(':checked'))
            get_reviews_settings();
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
                        location.reload();
                    else if (response.status == 'error')
                        show_modal_error(response.message);
                }
            });
        }
    });

    $('[data-action="edit_reviews_settings"]').on('click', function()
    {
        edit = true;

        get_reviews_settings();
    });

    function get_reviews_settings()
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

                    required_focus('form', $('form[name="edit_reviews_settings"]'), null);

                    $('[data-modal="edit_reviews_settings"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    }

    $('[data-modal="edit_reviews_settings"]').modal().onCancel(function()
    {
        if (edit == false)
        {
            $('#rvsw').prop('checked', false);
            $('#rvsw').parent().removeClass('checked');
        }

        status = '';
        edit = false;

        clean_form($('form[name="edit_reviews_settings"]'));
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
                    show_modal_success(response.message, 600);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('[data-action="edit_voxes_attention_times_settings"]').on('click', function()
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
                    $('[data-modal="edit_voxes_attention_times_settings"]').find('[name="request_low"]').val(response.data.settings.voxes.attention_times.request.low);
                    $('[data-modal="edit_voxes_attention_times_settings"]').find('[name="request_medium"]').val(response.data.settings.voxes.attention_times.request.medium);
                    $('[data-modal="edit_voxes_attention_times_settings"]').find('[name="request_high"]').val(response.data.settings.voxes.attention_times.request.high);
                    $('[data-modal="edit_voxes_attention_times_settings"]').find('[name="incident_low"]').val(response.data.settings.voxes.attention_times.incident.low);
                    $('[data-modal="edit_voxes_attention_times_settings"]').find('[name="incident_medium"]').val(response.data.settings.voxes.attention_times.incident.medium);
                    $('[data-modal="edit_voxes_attention_times_settings"]').find('[name="incident_high"]').val(response.data.settings.voxes.attention_times.incident.high);

                    required_focus('form', $('form[name="edit_voxes_attention_times_settings"]'), null);

                    $('[data-modal="edit_voxes_attention_times_settings"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-modal="edit_voxes_attention_times_settings"]').modal().onCancel(function()
    {
        clean_form($('form[name="edit_voxes_attention_times_settings"]'));
    });

    $('form[name="edit_voxes_attention_times_settings"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=edit_voxes_attention_times_settings',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 600);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });
});
