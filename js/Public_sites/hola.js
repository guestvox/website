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
modal_contact.onCancel(function () {});

modal_contact.onSuccess(function ()
{
    $('form[name="contact"]').submit();
    // modal_contact.close();
});

$('form[name="contact"]').on('submit', function ( event )
{
    event.preventDefault();
    console.log('enviado');

    var data = new FormData(this);

    $.ajax({
        type: 'POST',
        data: data,
        contentType: false,
        processData: false,
        cache: false,
        dataType: 'json',
        success: function(response)
        {
            // TODO
        }
    });
});
