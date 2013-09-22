<?php
$id_rutas = $_GET['id_ruta'];
$rutas = explode("-", $id_rutas);
$ruta1= $rutas[0];
$ruta2= $rutas[1];
$ruta3= $rutas[2];
// Get conection

ini_set('display_errors', 1);

$data = array();

if(  is_readable(  $db_cnn = 'db-cnn.php' ) )
{
  require_once $db_cnn ;

  if( !$error )
  {

    $query_base = $db->query( "SELECT * FROM  museos WHERE ID=$ruta1 OR ID=$ruta2 OR ID=$ruta3" );

    $rows = $query_base->fetchAll( PDO::FETCH_ASSOC );

    if( count( $rows ) ) $data = $rows ;  
  }
 
}
$reemplazar = array( '/\(/','/\)/');
$location1 = preg_replace( $reemplazar , '' ,$data[0]['LOCALIZACION'] );
$location2 = preg_replace( $reemplazar , '' ,$data[1]['LOCALIZACION'] );
$location3 = preg_replace( $reemplazar , '' ,$data[2]['LOCALIZACION'] );
?>


<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Directions service</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"> 
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/geekweb.css">
    <link href="css/mapita.css" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script>
    var directionsDisplay;
    var directionsService = new google.maps.DirectionsService();
    var map;

    function initialize() {
      directionsDisplay = new google.maps.DirectionsRenderer();
      var chicago = new google.maps.LatLng(-12.064384,-77.036986);
      var mapOptions = {
        zoom:14,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        center: chicago
      }
      map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
      directionsDisplay.setMap(map);
    }

    function calcRoute() {
      var start = '-12.064384,-77.036986';
      var end = '<?php echo $location3; ?>';
      var request = {
          origin:start,
          destination:end,
          waypoints:[{location: '<?php echo $location1; ?>'}, {location: '<?php echo $location2; ?>'}],
          optimizeWaypoints: true,
          travelMode: google.maps.DirectionsTravelMode.DRIVING
      };
      directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
          directionsDisplay.setDirections(response);
        }
      });
    }

    google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body onload="calcRoute();">
    
    <?php

    if(  is_readable(  $menu = 'menu.php' ) )
    {
      require_once $menu ;

    }

    ?>
    
    <!--<div id="map-canvas"></div>-->
    <div class="container first-map first-map preload" id="map-canvas">
        <i class="icon-spinner icon-spin icon-large"></i>Cargando
    </div>


    <div class="container">
      <p id="back-top" style="display: block;">
        <a href="#top" class="btn btn-primary">
          <i class="icon-home"></i>
          <em>Ir al cielo</em> 
        </a>
      </p>
    </div>

    <!-- SCRIPT -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){

    // hide #back-top first
    $("#back-top").hide();
    
    // fade in #back-top
    $(function () {
      $(window).scroll(function () {
        if ($(this).scrollTop() > 10) {
          $('#back-top').fadeIn();
        } else {
          $('#back-top').fadeOut();
        }
      });

      // scroll body to 0px on click
      $('#back-top a').click(function () {
        $('body,html').animate({
          scrollTop: 0
        }, 300);
        return false;
      });
    });

  });
    </script>

  </body>
</html>