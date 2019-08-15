'use strict';

$(document).ready(function()
{
    // Open responsive menu
    $('[data-open-resoff]').on('click', function(e)
    {
        e.stopPropagation();

        $('header.landing-page nav.resoff').toggleClass('open');
    });

    // Sumit login form
    $('form[name="login"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=login',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    window.location.href = response.path;
                else if (response.status == 'error')
                {
                    if (response.labels)
                    {
                        $('label.error').removeClass('error');
                        $('p.error').remove();

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

    // Type email input value into username input
    $('[name="email"]').on('keyup', function()
    {
        $('[name="username"]').val($(this).val());
        $('[name="password"]').val('');
    });

    // Select time zone
    $('[data-select]').find('[data-preview] > input[data-typer]').on('keyup', function()
    {
        var input = $(this);
        var select = input.parents('[data-select]');
        var search = select.find('[data-search]');
        var values = select.find('[data-search] > a');

        $.each(values, function(key, value)
        {
            var string1 = value.innerHTML.toLowerCase();
            var string2 = input.val().toLowerCase();
            var indexof = string1.indexOf(string2);

            if (indexof >= 0)
                value.className = '';
            else
                value.className = 'hidden';
        });

        search.addClass('view');
    });

    $('[data-select]').find('[data-search] > a').on('click', function()
    {
        $(this).parents('[data-select]').find('[data-preview] > input[data-typer]').val($(this).find('[data-zone]').html());
        $(this).parents('[data-select]').find('[data-search]').removeClass('view');
    });

    $(document).on('click', function(e)
    {
        var target = $('[data-select]');

        if (!target.is(e.target) && target.has(e.target).length === 0)
            target.find('[data-search]').removeClass('view');
    });

    // Apply promotional discount
    $('[name="apply_promotional_code"]').on('change', function()
    {
        $('[name="promotional_code"]').val('');

        if ($(this).prop("checked"))
        {
            $('[name="promotional_code"]').attr('disabled', false);
            $('[name="promotional_code"]').focus();
        }
        else
            $('[name="promotional_code"]').attr('disabled', true);
    });

    // Cancel singup modal
    $('[data-modal="signup"]').modal().onCancel(function()
    {
        $('label.error').removeClass('error');
        $('p.error').remove();
        $('form[name="signup"]')[0].reset();
    });

    // Submit signup form
    $('form[name="signup"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=signup',
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

                    setTimeout(function() { window.location.href = response.path; }, 10000);
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
