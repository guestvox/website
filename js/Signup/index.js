'use strict';

$(document).ready(function()
{
    $('[name="path"]').on('keyup', function()
    {
        var filter = 'abcdefghijklmnñopqrstuvwxyz';
        var string = $(this).val();
        var out = '';

        for (var i = 0; i < string.length; i++)
        {
            if (filter.indexOf(string.charAt(i)) != -1)
                out += string.charAt(i);
        }

        $(this).val(out);

        if (out.length > 0)
            $(this).parent().find('span').find('strong').html(out);
        else
            $(this).parent().find('span').find('strong').html('micuenta');
    });

    $('[name="type"]').on('change', function()
    {
        $(this).parent().parent().removeClass('span6');
        $(this).parent().parent().addClass('span3');

        $('[name="owners_number"]').val('');
        $('[name="owners_number"]').parent().parent().removeClass('hidden');

        if ($(this).val() == 'hotel')
            $('[name="owners_number"]').attr('placeholder', 'N. de habitaciones');
        else if ($(this).val() == 'restaurant')
            $('[name="owners_number"]').attr('placeholder', 'N. de mesas');
        else if ($(this).val() == 'hospital')
            $('[name="owners_number"]').attr('placeholder', 'N. de camas');
        else if ($(this).val() == 'others')
            $('[name="owners_number"]').attr('placeholder', 'N. de clientes');

        get_total();
    });

    $('[name="owners_number"]').on('change', function()
    {
        get_total();
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

    $('[name="operation"]').on('change', function()
    {
        get_total();
    });

    $('[name="reputation"]').on('change', function()
    {
        get_total();
    });

    $('[name="logotype"]').parents('.uploader').find('a').on('click', function()
    {
        $('[name="logotype"]').click();
    });

    $('[name="logotype"]').on('change', function()
    {
        var preview = $(this).parents('.uploader').find('img');

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
                        $('#success').html(response.message);
                        setTimeout(function() { window.location.href = '/'; }, 8000);
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
});

function get_total()
{
    var data = new FormData($('form[name="signup"]')[0]);

    data.append('action', 'get_total');

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
                $('#operation').find('h4 > span').html(response.data.price.operation);
                $('#reputation').find('h4 > span').html(response.data.price.reputation);
                $('#total').find('h4 > span').html(response.data.total);
            }
            else if (response.status == 'error')
            {
                $('[data-modal="error"]').addClass('view');
                $('[data-modal="error"]').find('main > p').html(response.message);
            }
        }
    });
}
