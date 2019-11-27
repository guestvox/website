'use strict';

$(document).ready(function()
{
    $('[data-action="open-land-menu"]').on('click', function(e)
    {
        e.stopPropagation();
        $('header.landing-page nav > ul').toggleClass('open');
    });

    $('[name="rooms_number"]').on('change', function()
    {
        if ($(this).val().length > 0)
            var rooms_number = $('[name="rooms_number"]').val();
        else
            var rooms_number = 0;

        $.ajax({
            type: 'POST',
            data: 'rooms_number=' + rooms_number + '&action=get_room_package',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    if (rooms_number > 0)
                    {
                        $('#room_package').parent().removeClass('hidden');
                        $('#room_package').find('h3 > strong').html(response.data.quantity_end);
                        $('#room_package').find('h4 > strong').html(response.data.price);
                        $('#total_package').find('h4 > strong').html(response.data.price);
                    }
                }
                else if (response.status == 'error')
                {
                    $('[data-modal="error"]').addClass('view');
                    $('[data-modal="error"]').find('main > p').html(response.message);
                }
            }
        });
    });

    // $('[name="cp"]').on('change', function()
    // {
    //     var self = $(this);
    //
    //     $.ajax({
    //         type: 'POST',
    //         data: 'cp=' + self.val() + '&action=get_cp',
    //         processData: false,
    //         cache: false,
    //         dataType: 'json',
    //         success: function(response)
    //         {
    //             if (response.status == 'success')
    //             {
    //                 var geocoder = new google.maps.Geocoder().geocode({
    //
    //                     address: self.val()
    //
    //                 }, function (results, status) {
    //
    //                     if (results.length > 0)
    //                     {
    //                         var map = new google.maps.Map(document.getElementById('map'), {
    //                             center: {
    //                                 lat: results[0].geometry.location.lat(),
    //                                 lng: results[0].geometry.location.lng()
    //                             },
    //                             zoom: 12,
    //                         });
    //
    //                         var circle = new google.maps.Circle({
    //                             strokeColor: '#fa7268',
    //                             strokeOpacity: 0.8,
    //                             strokeWeight: 2,
    //                             fillColor: '#fa7268',
    //                             fillOpacity: 0.2,
    //                             map: map,
    //                             center: {
    //                                 lat: results[0].geometry.location.lat(),
    //                                 lng: results[0].geometry.location.lng(),
    //                             },
    //                             radius: 1000,
    //                         });
    //
    //                         var marker = new google.maps.Marker({
    //                             position: {
    //                                 lat: results[0].geometry.location.lat(),
    //                                 lng: results[0].geometry.location.lng()
    //                             },
    //                             map: map,
    //                         });
    //
    //                         $('#map').parent().parent().parent().removeClass('hidden');
    //                     }
    //                     else
    //                     {
    //                         $('[data-modal="error"]').find('main > p').html('');
    //                         $('[data-modal="error"]').addClass('view');
    //                     }
    //                 });
    //             }
    //             else if (response.status == 'error')
    //             {
    //                 if (response.labels)
    //                 {
    //                     $('label.error').removeClass('error');
    //                     $('p.error').remove();
    //
    //                     $.each(response.labels, function(i, label)
    //                     {
    //                         if (label[1].length > 0)
    //                             $('[name="cp"]').parents('label').addClass('error').append('<p class="error">' + label[1] + '</p>');
    //                         else
    //                             $('[name="cp"]').parents('label').addClass('error');
    //                     });
    //
    //                     $('[name="cp"]')[0].focus();
    //                 }
    //                 else if (response.message)
    //                 {
    //                     $('[data-modal="error"]').find('main > p').html(response.message);
    //                     $('[data-modal="error"]').addClass('view');
    //                 }
    //             }
    //         }
    //     });
    // });

    $('[data-image-select]').on('click', function()
    {
        $(this).parent().find('[data-image-upload]').click();
    });

    $('[data-image-upload]').on('change', function()
    {
        var preview = $(this).parent().find('[data-image-preview]');

        if ($(this)[0].files[0].type.match($(this).attr('accept')))
        {
            var reader = new FileReader();

            reader.onload = function(e)
            {
                preview.attr('src', e.target.result);
            }

            reader.readAsDataURL($(this)[0].files[0]);
        }
        else
        {
            $('[data-modal="error"]').addClass('view');
            $('[data-modal="error"]').find('main > p').html('ERROR FILE NOT PERMIT');
        }
    });

    var step;

    $('[data-action="go_to_step"]').on('click', function()
    {
        step = $(this).parent().data('step');
        $('form[name="signup"]').submit();
    });

    $('[data-modal="signup"]').modal().onCancel(function()
    {
        $('form[name="signup"]')[0].reset();
        $('fieldset.error').removeClass('error');
        $('[data-step]').removeClass('view');
        $('[data-step="1"]').addClass('view');
        $('[data-image-preview]').attr('src', '../images/empty.png');
        $('#room_package').parent().addClass('hidden');
        $('.package').find('h4 > strong').html('');
    });

    $('form[name="signup"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);
        var data = new FormData(form[0]);

        data.append('step', step);
        data.append('action', 'go_to_step');

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
                    step = step + 1;

                    $('[data-step]').removeClass('view');
                    $('[data-step="' + step + '"]').addClass('view');

                    if (step == 6)
                    {
                        $('#success_step_message').html(response.message);
                        setTimeout(function() { location.reload(); }, 8000);
                    }
                }
                else if (response.status == 'error')
                {
                    if (response.labels)
                    {
                        form.find('fieldset.error').removeClass('error');

                        $.each(response.labels, function(i, label)
                        {
                            form.find('[name="' + label[0] + '"]').parents('fieldset').addClass('error');
                        });

                        form.find('fieldset.error [name]')[0].focus();
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

    $('[data-action="login"]').on('click', function()
    {
        $('form[name="login"]').submit();
    });

    $('[data-modal="login"]').modal().onCancel(function()
    {
        $('form[name="login"]')[0].reset();
        $('fieldset.error').removeClass('error');
    });

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
                    window.location.href = '/dashboard';
                else if (response.status == 'error')
                {
                    if (response.labels)
                    {
                        form.find('fieldset.error').removeClass('error');

                        $.each(response.labels, function(i, label)
                        {
                            form.find('[name="' + label[0] + '"]').parents('fieldset').addClass('error');
                        });

                        form.find('fieldset.error [name]')[0].focus();
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
