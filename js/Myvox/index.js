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
            data: 'action=get_opt_opportunity_types',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    $('[name="opportunity_type"]').html(response.html);
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
            $('[data-modal="new_vox"]').find('[name="description"]').parent().parent().parent().addClass('hidden');
        }
        else if (type == 'incident')
        {
            $('[data-modal="new_vox"]').find('[name="observations"]').parent().parent().parent().addClass('hidden');
            $('[data-modal="new_vox"]').find('[name="description"]').parent().parent().parent().removeClass('hidden');
        }

        required_focus($('[data-modal="new_vox"]').find('form'), true);

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
                    $('[name="opportunity_type"]').attr('disabled', false);
                    $('[name="opportunity_type"]').html(response.html);
                }
            }
        });
    });

    $('[data-modal="new_vox"]').modal().onCancel(function()
    {
        $('[data-modal="new_vox"]').find('[name="observations"]').parent().parent().parent().addClass('hidden');
        $('[data-modal="new_vox"]').find('[name="description"]').parent().parent().parent().addClass('hidden');

        clean_form($('[data-modal="new_vox"]').find('form'));
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
                    show_modal_success(response.message, 8000);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('[data-action="minus_to_menu_cart"]').on('click', function()
    {
        var target = $(this).parent().find('[name="quantity"]');
        var quantity = parseInt(target.val());
        quantity = (quantity > 0) ? quantity - 1 : 0;
        target.val(quantity);
    });

    $('[data-action="plus_to_menu_cart"]').on('click', function()
    {
        var target = $(this).parent().find('[name="quantity"]');
        var quantity = parseInt(target.val());
        quantity = quantity + 1;
        target.val(quantity);
    });

    var id;

    $('[data-action="add_to_menu_cart"]').on('click', function()
    {
        var quantity = $(this).parent().find('[name="quantity"]').val();

        if (quantity > 0)
        {
            id = $(this).data('id');

            $(this).parents('form').submit();
        }
    });

    $('form[name="add_to_menu_cart"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&id=' + id + '&action=add_to_menu_cart',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    form.parents('main.menu_cart').find('[data-menu-cart]').html(response.html);
                    form.find('[name="quantity"]').val(0);
                }
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('[data-action="remove_to_menu_cart"]').on('click', function()
    {
        id = $(this).data('id');

        var target = $(this);

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=remove_to_menu_cart',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    target.parents('main.menu_cart').find('[data-menu-cart]').html(response.html);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('[data-action="send_menu_cart"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'action=send_menu_cart',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 4000);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    // $('[data-action="open_subquestion"]').on('change', function()
    // {
    //     var name = $(this).attr('name');
    //
    //     if ($(this).val() == '1' || $(this).val() == '2' || $(this).val() == '3' || $(this).val() == 'yes')
    //         $('#' + name).removeClass('hidden');
    //     else
    //     {
    //         $('#' + name).addClass('hidden');
    //         $('#' + name).find(':input').each(function() {
    //             if (this.type == 'text')
    //                 $(this).val('');
    //             else if (this.type == 'radio')
    //                 this.checked = false;
    //         });
    //     }
    // });
    //
    // $('[data-action="open_subquestion_sub"]').on('change', function()
    // {
    //     var name = $(this).attr('name');
    //
    //     if ($(this).val() == '1' || $(this).val() == '2' || $(this).val() == '3' || $(this).val() == 'yes')
    //         $('#' + name).removeClass('hidden');
    //     else
    //     {
    //         $('#' + name).addClass('hidden');
    //         $('#' + name).find(':input').each(function() {
    //             if (this.type == 'text')
    //                 $(this).val('');
    //             else if (this.type == 'radio')
    //                 this.checked = false;
    //         });
    //     }
    // });
    //
    // $('[data-modal="new_survey_answer"]').modal().onCancel(function()
    // {
    //     $('[data-modal="new_survey_answer"]').find('form')[0].reset();
    //     $('[data-modal="new_survey_answer"]').find('label.error').removeClass('error');
    //     $('[data-modal="new_survey_answer"]').find('p.error').remove();
    // });
    //
    // $('form[name="new_survey_answer"]').on('submit', function(e)
    // {
    //     e.preventDefault();
    //
    //     var form = $(this);
    //
    //     $.ajax({
    //         type: 'POST',
    //         data: form.serialize() + '&action=new_survey_answer',
    //         processData: false,
    //         cache: false,
    //         dataType: 'json',
    //         success: function(response)
    //         {
    //             if (response.status == 'success')
    //             {
    //                 $('[data-modal="success"]').addClass('view');
    //                 $('[data-modal="success"]').find('main > p').html(response.message);
    //
    //                 if (response.data.widget == true)
    //                 {
    //                     setTimeout(function() {
    //                         $('[data-modal="success"]').removeClass('view');
    //                         $('[data-modal="new_survey_answer"]').removeClass('view');
    //                         $('[data-modal="new_survey_answer"]').find('form')[0].reset();
    //                         $('[data-modal="new_survey_answer"]').find('label.error').removeClass('error');
    //                         $('[data-modal="new_survey_answer"]').find('p.error').remove();
    //                         $('[data-modal="survey_widget"]').addClass('view');
    //                     }, 4000);
    //                 }
    //                 else
    //                     setTimeout(function() { location.reload(); }, 8000);
    //             }
    //             else if (response.status == 'error')
    //             {
    //                 if (response.labels)
    //                 {
    //                     form.find('label.error').removeClass('error');
    //                     form.find('p.error').remove();
    //
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
    //                     $('[data-modal="error"]').addClass('view');
    //                     $('[data-modal="error"]').find('main > p').html(response.message);
    //                 }
    //             }
    //         }
    //     });
    // });
});
