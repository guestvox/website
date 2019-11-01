"use strict";

var modal_contact = $('#modal_contact').modal();
modal_contact.onCancel(function () {});

modal_contact.onSuccess(function ()
{
    modal_contact.close();
});


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
