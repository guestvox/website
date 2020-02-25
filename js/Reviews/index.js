'use strict';

$(document).ready(function()
{
    var tbl_reviews_comments = $('#tbl_reviews_comments').DataTable({
        ordering: false,
        pageLength: 25,
        info: false
    });

    var geocoder = new google.maps.Geocoder().geocode({

       address: self.val()

   }, function (results, status) {

       if (results.length > 0)
       {
           var map = new google.maps.Map(document.getElementById('map'), {
               center: {
                   lat: results[0].geometry.location.lat(),
                   lng: results[0].geometry.location.lng()
               },
               zoom: 12,
           });

           var circle = new google.maps.Circle({
               strokeColor: '#fa7268',
               strokeOpacity: 0.8,
               strokeWeight: 2,
               fillColor: '#fa7268',
               fillOpacity: 0.2,
               map: map,
               center: {
                   lat: results[0].geometry.location.lat(),
                   lng: results[0].geometry.location.lng(),
               },
               radius: 1000,
           });

           var marker = new google.maps.Marker({
               position: {
                   lat: results[0].geometry.location.lat(),
                   lng: results[0].geometry.location.lng()
               },
               map: map,
           });

           $('#map').parent().parent().parent().removeClass('hidden');
       }
       else
       {
           $('[data-modal="error"]').find('main > p').html('');
           $('[data-modal="error"]').addClass('view');
       }
   });

});
