'use strict';

$(document).ready(function()
{
    // ---

    $('[data-open-resoff]').on('click', function(e)
    {
        e.stopPropagation();
        $('header.landing-page nav.resoff').toggleClass('open');
    });

    // ---

    $('[name="rooms_number"]').on('change', function()
    {
        get_packages();
    });

    $('[name="users_number"]').on('change', function()
    {
        get_packages();
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

    var step;

    $('[data-action="go_to_step"]').on('click', function()
    {
        step = $(this).parent().data('step');
        $('form[name="signup"]').submit();
    });

    $('[data-modal="signup"]').modal().onCancel(function()
    {
        $('fieldset.error').removeClass('error');
        $('[data-step]').removeClass('view');
        $('[data-step="1"]').addClass('view');
        $('[data-image-preview]').attr('src', '../images/empty.png');
        $('#room_package').parent().addClass('hidden');
        $('#user_package').parent().addClass('hidden');
        $('.package').find('h4 > strong').html('');
        $('form[name="signup"]')[0].reset();
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
                $('fieldset.error').removeClass('error');

                if (response.status == 'success')
                {
                    $('[data-step]').removeClass('view');
                    $('[data-step="' + (step + 1) + '"]').addClass('view');
                }
                else if (response.status == 'error')
                {
                    if (response.labels)
                    {
                        $.each(response.labels, function(i, label)
                        {
                            form.find('[name="' + label[0] + '"]').parents('fieldset').addClass('error');
                        });

                        form.find('fieldset.error [name]')[0].focus();
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

    $('[data-modal="login"]').modal().onCancel(function()
    {
        $('fieldset.error').removeClass('error');
        $('form[name="login"]')[0].reset();
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
                    window.location.href = response.path;
                else if (response.status == 'error')
                {
                    if (response.labels)
                    {
                        $('fieldset.error').removeClass('error');

                        $.each(response.labels, function(i, label)
                        {
                            form.find('[name="' + label[0] + '"]').parents('fieldset').addClass('error');
                        });

                        form.find('fieldset.error [name]')[0].focus();
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

function get_packages()
{
    if ($('[name="rooms_number"]').val().length > 0)
        var rooms_number = $('[name="rooms_number"]').val();
    else
        var rooms_number = 0;

    if ($('[name="users_number"]').val().length > 0)
        var users_number = $('[name="users_number"]').val();
    else
        var users_number = 0;

    $.ajax({
        type: 'POST',
        data: 'rooms_number=' + rooms_number + '&users_number=' + users_number + '&action=get_packages',
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
                    $('#room_package').find('h3 > strong').html(response.data.room_package.quantity);
                    $('#room_package').find('h4 > strong').html(response.data.room_package.price);
                }

                if (users_number > 0)
                {
                    $('#user_package').parent().removeClass('hidden');
                    $('#user_package').find('h3 > strong').html(response.data.user_package.quantity);
                    $('#user_package').find('h4 > strong').html(response.data.user_package.price);
                }

                if (rooms_number > 0 || users_number > 0)
                    $('#total_package').find('h4 > strong').html(response.data.total);
            }
            else if (response.status == 'error')
            {
                $('[data-modal="error"]').find('main > p').html(response.message);
                $('[data-modal="error"]').addClass('view');
            }
        }
    });
}
