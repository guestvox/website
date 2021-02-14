'use strict';

$(document).ready(function()
{
    var id = null;

    $('[data-modal="view_map_menu_order"]').modal().onCancel(function()
    {
        id = null;

        $('#view_map_menu_order').html('');
    });

    $('[data-action="view_map_menu_order"]').on('click', function()
    {
        id = $(this).data('id');

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=view_map_menu_order',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    var menu_order_map = new google.maps.Map(document.getElementById("menu_order_map"), {
                        zoom: 11,
                        center:new google.maps.LatLng(response.data.menu_order.lat,response.data.menu_order.lng)
                    });

                    var menu_order_map_marker = new google.maps.Marker({
                        map: menu_order_map,
                        title: "Orden",
                        draggable: true,
                        position: new google.maps.LatLng(response.data.menu_order.lat,response.data.menu_order.lng)
                    });

                    var account_map_marker = new google.maps.Marker({
                        map: menu_order_map,
                        title: "Tu",
                        draggable: true,
                        position: new google.maps.LatLng(response.data.account.lat,response.data.account.lng)
                    });

                    var account_map_radius = new google.maps.Circle({
                        strokeColor: "#fa7268",
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: "#fa7268",
                        fillOpacity: 0.2,
                        map: menu_order_map,
                        center: {
                            lat: parseFloat(response.data.account.lat),
                            lng: parseFloat(response.data.account.lng)
                        },
                        radius: parseInt(response.data.account.rad)
                    });

                    var dr = new google.maps.DirectionsRenderer;

                    dr.setMap(menu_order_map);

                    var ds = new google.maps.DirectionsService;

                    ds.route({
                       origin: {
                           lat: parseFloat(response.data.account.lat),
                           lng: parseFloat(response.data.account.lng)
                       },
                       destination: {
                           lat: parseFloat(response.data.menu_order.lat),
                           lng: parseFloat(response.data.menu_order.lng)
                       },
                       travelMode: google.maps.TravelMode.DRIVING
                    }, function (response, status) {
                       if (status === google.maps.DirectionsStatus.OK)
                           dr.setDirections(response);
                       else
                           window.alert('ERROR (' + status + ')');
                    });

                    $('[data-modal="view_map_menu_order"]').addClass('view');
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="accept_menu_order"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="accept_menu_order"]').addClass('view');
    });

    $('[data-modal="accept_menu_order"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=accept_menu_order',
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

    $('[data-action="deliver_menu_order"]').on('click', function()
    {
        id = $(this).data('id');

        $('[data-modal="deliver_menu_order"]').addClass('view');
    });

    $('[data-modal="deliver_menu_order"]').modal().onSuccess(function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=deliver_menu_order',
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
