'use strict';

var id;
var action;

$(document).ready(function()
{
    $('[data-action="filter_menu_products_by_categories"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'id=' + $(this).data('id') + '&action=filter_menu_products_by_categories',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    location.reload();
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="preview_menu_product"]').on('click', function()
    {
        id = $(this).data('id');

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&action=preview_menu_product',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    $('[data-modal="preview_menu_product"]').find('main').html(response.html);
                    $('[data-modal="preview_menu_product"]').addClass('view');

                    load_preview_menu_product_actions();
                }
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[data-action="remove_to_menu_order"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'key=' + $(this).data('key') + '&subkey=' + $(this).data('subkey') + '&action=remove_to_menu_order',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message);
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('form[name="search"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=search',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    window.location.href = response.path;
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });

    $('[data-action="clear_search"]').on('click', function()
    {
        $.ajax({
            type: 'POST',
            data: 'action=clear_search',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    location.reload();
                else if (response.status == 'error')
                    show_modal_error(response.message);
            }
        });
    });

    $('[name="delivery"]').on('change', function()
    {
        if ($(this).val() == 'bring')
            $('[name="address"]').parent().parent().parent().removeClass('hidden');
        else if ($(this).val() == 'collect')
            $('[name="address"]').parent().parent().parent().addClass('hidden');
    });

    $('form[name="new_menu_order"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&action=new_menu_order',
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                    show_modal_success(response.message, 2000, response.path);
                else if (response.status == 'error')
                    show_form_errors(form, response);
            }
        });
    });
});

function load_preview_menu_product_actions()
{
    $('[data-action="update_menu_product_price"]').on('change', function()
    {
        id = $(this).data('id');
        action = 'update_menu_product_price';

        $('form[name="add_to_menu_order"]').submit();
    });

    var quantity_start;
    var quantity_end;

    $('[data-action="minus_to_menu_order"]').on('click', function()
    {
        id = $(this).data('id');
        action = 'update_menu_product_price';
        quantity_start = parseInt($(this).parent().find('[name="quantity"]').val());
        quantity_end = (quantity_start > 1) ? (quantity_start - 1) : 1;

        $(this).parent().find('[name="quantity"]').val(quantity_end);

        $('form[name="add_to_menu_order"]').submit();
    });

    $('[data-action="plus_to_menu_order"]').on('click', function()
    {
        id = $(this).data('id');
        action = 'update_menu_product_price';
        quantity_start = parseInt($(this).parent().find('[name="quantity"]').val());
        quantity_end = (quantity_start + 1);

        $(this).parent().find('[name="quantity"]').val(quantity_end);

        $('form[name="add_to_menu_order"]').submit();
    });

    $('[data-action="add_to_menu_order"]').on('click', function()
    {
        id = $(this).data('id');
        action = 'add_to_menu_order';

        $('form[name="add_to_menu_order"]').submit();
    });

    $('form[name="add_to_menu_order"]').on('submit', function(e)
    {
        e.preventDefault();

        var form = $(this);

        $.ajax({
            type: 'POST',
            data: form.serialize() + '&id=' + id + '&action=' + action,
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                if (response.status == 'success')
                {
                    if (action == 'update_menu_product_price')
                        $('[data-modal="preview_menu_product"]').find('main > span').html(response.total);
                    else if (action == 'add_to_menu_order')
                        show_modal_success(response.message);
                }
                else if (response.status == 'error')
                {
                    if (action == 'update_menu_product_price')
                        $('[data-modal="preview_menu_product"]').find('main > span').html(quantity_start);
                    else if (action == 'add_to_menu_order')
                        show_form_errors(form, response);
                }
            }
        });
    });

    $('[data-modal="preview_menu_product"]').modal().onCancel(function()
    {
        id = null;
        action = null;

        $('[data-modal="preview_menu_product"]').find('main').html('');
    });
}

// var delivery_map_coords = {};
// var delivery_map_marker;

function map()
{
    // delivery_map_coords =  {
    //     lat: 21.1213285,
    //     lng: -86.9192739
    // };

    // var delivery_map = new google.maps.Map(document.getElementById("delivery_map"),
    // {
    //     zoom: 13,
    //     center: {
    //         lat: 21.1213285,
    //         lng: -86.9192739
    //     }
    // });

    if (navigator.geolocation)
    {
        navigator.geolocation.getCurrentPosition(function(position) {

            console.log('Succcess');

        }, function(errors) {

            console.log('Error');

        });
    }

    // set_map(delivery_map_coords);
    //
    // document.getElementById("location_lat").value = delivery_map_coords["lat"];
    // document.getElementById("location_lng").value = delivery_map_coords["lng"];
}

// function set_map(delivery_map_coords)
// {
//     var delivery_map = new google.maps.Map(document.getElementById("delivery_map"),
//     {
//         zoom: 13,
//         center:new google.maps.LatLng(delivery_map_coords.lat,delivery_map_coords.lng)
//     });
//
//     delivery_map_marker = new google.maps.Marker({
//         map: delivery_map,
//         title: "Tú",
//         draggable: true,
//         animation: google.maps.Animation.DROP,
//         position: new google.maps.LatLng(delivery_map_coords.lat,delivery_map_coords.lng)
//     });
//
//     delivery_map_marker.addListener("click", delivery_map_toggle_bounce);
//     delivery_map_marker.addListener("dragend", function (event)
//     {
//         document.getElementById("location_lat").value = this.getPosition().lat();
//         document.getElementById("location_lng").value = this.getPosition().lng();
//     });
// }
//
// function delivery_map_toggle_bounce()
// {
//     if (delivery_map_marker.getAnimation() !== null)
//         delivery_map_marker.setAnimation(null);
//     else
//         delivery_map_marker.setAnimation(google.maps.Animation.BOUNCE);
// }
