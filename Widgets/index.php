<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDciZm7zomBLUwx6_Ez44OegZNMiC7tX3o"></script>
        <script src="jquery-google-reviews.js" defer></script>
        <link href="jquery-google-reviews.css" rel="stylesheet"></script>
        <title></title>
    </head>
    <body>
        <!-- Widget del clima Cancun -->
        <div id="cont_562e1d81003724dd4e4f5cdc1bc720bb"><script type="text/javascript" async src="https://www.meteored.mx/wid_loader/562e1d81003724dd4e4f5cdc1bc720bb"></script></div>
        <div id="google-reviews"></div>
    </body>

    <script>
    //Ejemplo con reviews de Kasa Hotel Tulum
    var id = 'ChIJ9-tnGbPWT48RF5aCN7DN2k4';

    jQuery(document).ready(function($) {
      if ($("#google-reviews").length == 0) {
        return
      }
      $("#google-reviews").googlePlaces({
        placeId: id,
        // the following params are optional (default values)
        header: "<h3>Google Reviews</h3>", // html/text over Reviews
        footer: '', // html/text under Reviews block
        maxRows: 1, // max 5 rows of reviews to be displayed
        minRating: 4, // minimum rating of reviews to be displayed
        months: ["Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez"],
        textBreakLength: "40", // length before a review box is set to max width
        shortenNames: false, // example: "Max Mustermann" -> "Max M."",
        moreReviewsButtonUrl: '', // url to Google Place reviews popup
        moreReviewsButtonLabel: 'Show More Reviews',
        writeReviewButtonUrl: 'https://search.google.com/local/writereview?placeid='+id, // url to Google Place write review popup
        writeReviewButtonLabel: 'Escribir un comentario'
      });
    });
    </script>
</html>
