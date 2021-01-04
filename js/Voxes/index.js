'use strict';

$(document).ready(function()
{
    var pusher = new Pusher('1907b80d942422da0b8e', {
        cluster: 'us2'
      });
    
      var channel = pusher.subscribe('menu-orders');
      channel.bind('new-order', function(data) {
        $.ajax({
            type: 'POST',
            data: 'data=' + data + '&action=notification',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    console.log('Correcto'); 
                elses (response.status == 'error')
                    console.log('Error');
            }
        });
        // alert(JSON.stringify(data));
      });

    var token = null;
    var id = null;
      
    $('[name="type"]').on('change', function()
    {
        $.ajax({
            type: 'POST',
            data: 'type=' + $(this).val() + '&action=get_opt_owners',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[name="owner"]').html(response.html);

                    required_focus('input', $('[name="owner"]'), null);
                }
            }
        });

        $.ajax({
            type: 'POST',
            data: 'type=' + $(this).val() + '&action=get_opt_opportunity_areas',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[name="opportunity_area"]').html(response.html);

                    required_focus('input', $('[name="opportunity_area"]'), null);
                }
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
                {
                    $('[name="opportunity_type"]').html(response.html);

                    required_focus('input', $('[name="opportunity_type"]'), null);
                }
            }
        });

        $.ajax({
            type: 'POST',
            data: 'type=' + $(this).val() + '&action=get_opt_locations',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[name="location"]').html(response.html);

                    required_focus('input', $('[name="location"]'), null);
                }
            }
        });
    });

    $('[name="opportunity_area"]').on('change', function()
    {
        $.ajax({
            type: 'POST',
            data: 'opportunity_area=' + $(this).val() + '&type=' + $('[name="type"]').val() + '&action=get_opt_opportunity_types',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[name="opportunity_type"]').html(response.html);

                    required_focus('input', $('[name="opportunity_type"]'), null);
                }
            }
        });
    });

    $('form[name="filter_voxes"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=filter_voxes',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    location.reload();
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('[data-action="preview_vox"]').on('click', function()
    {
        token = $(this).data('token');

        $.ajax({
            type: 'POST',
            data: 'token=' + token + '&action=preview_vox',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="preview_vox"]').addClass('view');
                    $('[data-modal="preview_vox"]').find('main > .stl_11').html(response.html)
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-button-modal="start_vox_now"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'action=start_vox',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 600);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="complete_vox"]').on('click', function()
    {
        id = $(this).data('id');
        token = $(this).data('token');

        $('[data-modal="complete_vox"]').addClass('view');
              
    });

    $('[data-modal="complete_vox"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&token=' + token + '&action=complete_vox',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 600);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });
});
