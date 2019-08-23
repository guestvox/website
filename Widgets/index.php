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
        <div id="cont_cf579d37bb4314d5ed2463619c1c0de4"><script type="text/javascript" async src="https://www.meteored.mx/wid_loader/cf579d37bb4314d5ed2463619c1c0de4"></script></div><br>
        <div id="TA_cdswritereviewlg4" class="TA_cdswritereviewlg">
            <ul id="I7hJOKLd" class="TA_links FJfwMuzhhq">
                <li id="SnaJrr" class="KBMX9k">
                <a target="_blank" href="https://www.tripadvisor.com.mx/"><img src="https://www.tripadvisor.com.mx/img/cdsi/img2/branding/medium-logo-12097-2.png" alt="TripAdvisor"/></a>
                </li>
            </ul>
        </div>
        <script async src="https://www.jscache.com/wejs?wtype=cdswritereviewlg&amp;uniq=4&amp;locationId=154652&amp;lang=es_MX&amp;lang=es_MX&amp;display_version=2" data-loadtrk onload="this.loadtrk=true">
        </script>
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
