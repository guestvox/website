"use strict";

$('#screenshots').owlCarousel({
    autoplay: true,
    autoplayTimeout: 2000,
    stagePadding: 100,
    loop: false,
    margin: 10,
    rewind: true,
    autoplayHoverPause: true,
    responsive:{
        0:{
            items: 1,
            stagePadding: 50,
        },
        600:{
            items: 2,
            stagePadding: 50,
        },
        1000:{
            items: 3
        }
    }
});

var modal_contact = $('#modal_contact').modal();
var modal_contact_success = $('#modal_contact_success').modal();

modal_contact.onSuccess(function ()
{
    $('form[name="contact"]').submit();
});

$('form[name="contact"]').on('submit', function ( event )
{
    event.preventDefault();

    var data = new FormData(this);

    $.ajax({
        type: 'POST',
        data: data,
        contentType: false,
        processData: false,
        cache: false,
        dataType: 'json',
        success: function ( response )
        {
            modal_contact.close();
            modal_contact_success.open();
        }
    });
});
