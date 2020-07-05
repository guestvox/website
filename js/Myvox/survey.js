'use strict';

$(document).ready(function()
{
    $('body').on('click', function(e)
    {
        e.stopPropagation();
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

    $('.tbl_stl_5').find('[data-level]').find('input[type="radio"]').on('change', function()
    {
        var label = $(this).parent();
        var level = $(this).parents('[data-level]');
        var content = level.parent();
        var type = level.find('> div');

        if (type.attr('class') == 'rate' || type.attr('class') == 'twin')
        {
            if ($(this).val() <= 3 || $(this).val() == 'not')
                content.find('[data-parent="' + $(this).attr('name') + '"]').parents('[data-level]').addClass('open');
            else
            {
                if (level.data('level') == '1')
                {
                    content.find('[data-level="2"]').find('input[type="radio"]').prop('checked', false);
                    content.find('[data-level="2"]').find('label').removeClass('focus');
                    content.find('[data-level="2"]').removeClass('open');
                    content.find('[data-level="3"]').find('input[type="radio"]').prop('checked', false);
                    content.find('[data-level="3"]').find('label').removeClass('focus');
                    content.find('[data-level="3"]').removeClass('open');
                }
                else if (level.data('level') == '2')
                {
                    content.find('[data-parent="' + $(this).attr('name') + '"]').prop('checked', false);
                    content.find('[data-parent="' + $(this).attr('name') + '"]').parents('label').removeClass('focus');
                    content.find('[data-parent="' + $(this).attr('name') + '"]').parents('[data-level]').removeClass('open');
                }
            }
        }

        type.find('label').removeClass('focus');
        label.addClass('focus');
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
                    if (response.widget == true)
                    {
                        show_modal_success(response.message, 2000, 'fast');
                        $('[data-modal="widget"]').addClass('view');
                    }
                    else if (response.widget == false)
                        show_modal_success(response.message, 8000, response.path);
                }
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });
});
