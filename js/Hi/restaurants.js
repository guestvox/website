'use strict';

$(document).ready(function()
{
    $('a[data-target]').on('click', function()
    {
        var target = $(this).data('target');

        $.ajax({
            type: 'POST',
            data: 'target=' + target + '&action=change_target',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('header').find('a[data-target]').removeClass('active');
                    $('header').find('a[data-target="' + target + '"]').addClass('active');

                    $('main').addClass('hidden');
                    $('main[data-target="' + target + '"]').removeClass('hidden');

                    $('body, html').animate({
            			scrollTop: '0px'
            		}, 800);
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('a[data-action="lpr_opn_mnu"]').on('click', function(event)
    {
        event.stopPropagation();

        $(this).parent().find('nav').toggleClass('open');
    });

    $('header.landing_page_restaurants').find('nav').on('click', function()
    {
        $(this).parent().find('nav').removeClass('open');
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

    $('form[name="go_to_next_step"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);
        var current_step = form.data('step');
        var next_step = (current_step + 1);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&current_step=' + current_step + '&next_step=' + next_step + '&action=go_to_next_step',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('form[data-step]').addClass('hidden');
                    $('form[data-step="' + next_step + '"]').removeClass('hidden');
                }
                else if (response.status == 'error')
                {
                    if (response.labels)
                    {
                        if (current_step == '1')
                        {
                            form.find('[name="name"]').addClass('error');
                            form.find('[name="name"]').focus();
                        }
                        else if (current_step == '2')
                            form.find('[name="logotype"]').parent().addClass('error');
                    }
                    else if (response.message)
                        show_modal_error(response.message);
                }
            }
        });
    });

    $('a[data-action="return_to_back_step"]').on('click', function()
    {
        var current_step = $(this).parents('form').data('step');
        var back_step = (current_step - 1);

        $.ajax({
            type: 'POST',
            data: 'current_step=' + current_step + '&back_step=' + back_step + '&action=return_to_back_step',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('form[data-step]').addClass('hidden');
                    $('form[data-step="' + back_step + '"]').removeClass('hidden');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });
});
