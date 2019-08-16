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



    // ---

    // $('[data-select-select]').find('[data-select-preview] > [data-select-typer]').on('keyup', function()
    // {
    //     var input = $(this);
    //     var select = input.parents('[data-select-select]');
    //     var search = select.find('[data-select-search]');
    //     var values = select.find('[data-select-search] > [data-select-opt]');
    //
    //     $.each(values, function(key, value)
    //     {
    //         var string1 = value.innerHTML.toLowerCase();
    //         var string2 = input.val().toLowerCase();
    //         var indexof = string1.indexOf(string2);
    //
    //         if (indexof >= 0)
    //             value.className = '';
    //         else
    //             value.className = 'hidden';
    //     });
    //
    //     search.addClass('view');
    // });
    //
    // $('[data-select-select]').find('[data-select-search] > [data-select-opt]').on('click', function()
    // {
    //     $(this).parents('[data-select-select]').find('[data-select-preview] > [data-select-value]').val($(this).find('[data-select-value-1]').html());
    //     $(this).parents('[data-select-select]').find('[data-select-preview] > [data-select-typer]').val($(this).find('[data-select-value-2]').html());
    //     $(this).parents('[data-select-select]').find('[data-select-search]').removeClass('view');
    // });
    //
    // $('[data-select-close]').on('click', function(e)
    // {
    //     $(this).parents('[data-select-select]').find('[data-select-preview] > [data-select-value]').val('');
    //     $(this).parents('[data-select-select]').find('[data-select-preview] > [data-select-typer]').val('');
    //     $(this).parents('[data-select-select]').find('[data-select-search]').removeClass('view');
    // });
    //
    // $('[data-select-typer]').on('keyup', function(e)
    // {
    //     if ($(this).val().length <= 0)
    //     {
    //         $(this).parents('[data-select-select]').find('[data-select-preview] > [data-select-value]').val('');
    //         $(this).parents('[data-select-select]').find('[data-select-preview] > [data-select-typer]').val('');
    //         $(this).parents('[data-select-select]').find('[data-select-search]').removeClass('view');
    //     }
    // });

    // ---

    $('[name="currency"]').on('change', function()
    {
        if ($('[name="rooms_number"]').val().length > 0)
        {
            $.ajax({
                type: 'POST',
                data: 'rooms_number=' + $('[name="rooms_number"]').val() + '&currency=' + $(this).val() + '&action=get_room_package',
                processData: false,
                cache: false,
                dataType: 'json',
                success: function(response)
                {
                    if (response.status == 'success')
                    {
                        $('#room_package').parent().removeClass('hidden');
                        $('#room_package').find('h3 > strong').html(response.data.quantity);
                        $('#room_package').find('h4 > strong').html(response.data.price);
                    }
                    else if (response.status == 'error')
                    {
                        $('[data-modal="error"]').find('main > p').html(response.message);
                        $('[data-modal="error"]').addClass('view');
                    }
                }
            });
        }

        if ($('[name="users_number"]').val().length > 0)
        {
            $.ajax({
                type: 'POST',
                data: 'users_number=' + $('[name="users_number"]').val() + '&currency=' + $(this).val() + '&action=get_user_package',
                processData: false,
                cache: false,
                dataType: 'json',
                success: function(response)
                {
                    if (response.status == 'success')
                    {
                        $('#user_package').parent().removeClass('hidden');
                        $('#user_package').find('h3 > strong').html(response.data.quantity);
                        $('#user_package').find('h4 > strong').html(response.data.price);
                    }
                    else if (response.status == 'error')
                    {
                        $('[data-modal="error"]').find('main > p').html(response.message);
                        $('[data-modal="error"]').addClass('view');
                    }
                }
            });
        }
    });

    $('[name="rooms_number"]').on('change', function()
    {
        if ($('[name="currency"]').val().length > 0)
        {
            $.ajax({
                type: 'POST',
                data: 'rooms_number=' + $(this).val() + '&currency=' + $('[name="currency"]').val() + '&action=get_room_package',
                processData: false,
                cache: false,
                dataType: 'json',
                success: function(response)
                {
                    if (response.status == 'success')
                    {
                        $('#room_package').parent().removeClass('hidden');
                        $('#room_package').find('h3 > strong').html(response.data.quantity);
                        $('#room_package').find('h4 > strong').html(response.data.price);
                    }
                    else if (response.status == 'error')
                    {
                        $('[data-modal="error"]').find('main > p').html(response.message);
                        $('[data-modal="error"]').addClass('view');
                    }
                }
            });
        }
    });

    $('[name="users_number"]').on('change', function()
    {
        if ($('[name="currency"]').val().length > 0)
        {
            $.ajax({
                type: 'POST',
                data: 'users_number=' + $(this).val() + '&currency=' + $('[name="currency"]').val() + '&action=get_user_package',
                processData: false,
                cache: false,
                dataType: 'json',
                success: function(response)
                {
                    if (response.status == 'success')
                    {
                        $('#user_package').parent().removeClass('hidden');
                        $('#user_package').find('h3 > strong').html(response.data.quantity);
                        $('#user_package').find('h4 > strong').html(response.data.price);
                    }
                    else if (response.status == 'error')
                    {
                        $('[data-modal="error"]').find('main > p').html(response.message);
                        $('[data-modal="error"]').addClass('view');
                    }
                }
            });
        }
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

    // $('[name="address"]').on('keyup', function()
    // {
    //     $('[name="fiscal_address"]').val($(this).val());
    // });

    // $('[name="email"]').on('keyup', function()
    // {
    //     $('[name="username"]').val($(this).val());
    // });

    // $('[name="apply_promotional_code"]').on('change', function()
    // {
    //     $('[name="promotional_code"]').val('');
    //
    //     if ($(this).prop("checked"))
    //     {
    //         $('[name="promotional_code"]').attr('disabled', false);
    //         $('[name="promotional_code"]').focus();
    //     }
    //     else
    //         $('[name="promotional_code"]').attr('disabled', true);
    // });

    // $('[data-modal="signup"]').modal().onCancel(function()
    // {
    //     $('label.error').removeClass('error');
    //     $('p.error').remove();
    //     $('form[name="signup"]')[0].reset();
    // });
    //
    // $('form[name="signup"]').on('submit', function(e)
    // {
    //     e.preventDefault();
    //
    //     var form = $(this);
    //
    //     $.ajax({
    //         type: 'POST',
    //         data: form.serialize() + '&action=signup',
    //         processData: false,
    //         cache: false,
    //         dataType: 'json',
    //         success: function(response)
    //         {
    //             $('label.error').removeClass('error');
    //             $('p.error').remove();
    //
    //             if (response.status == 'success')
    //             {
    //                 $('[data-modal="success"]').find('main > p').html(response.message);
    //                 $('[data-modal="success"]').addClass('view');
    //
    //                 setTimeout(function() { window.location.href = response.path; }, 10000);
    //             }
    //             else if (response.status == 'error')
    //             {
    //                 if (response.labels)
    //                 {
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
    //                     $('[data-modal="error"]').find('main > p').html(response.message);
    //                     $('[data-modal="error"]').addClass('view');
    //                 }
    //             }
    //         }
    //     });
    // });

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
});
