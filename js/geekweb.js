/**
created by Pnkkito shiZheni erodriguez.androide@gmail.com
*/

/**
JQUERY 
*/
$('#myTab a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
});


/*

  OPCION UNO 

*/

  console.log( 'ESTAS USANDO EL MAPA COMPLEMENTARIO.' );
  var image = 'img/human.png';
  var desde = "-12.064384" ;
  var hasta = "-77.036986" ;

  function initialize() {
    var myLatlng = new google.maps.LatLng( desde , hasta );
    var mapOptions = {
      zoom: 15,
      center: myLatlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    var map = new google.maps.Map(document.getElementById('mapcanvas'), mapOptions);

    var marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        icon: image,
        title: 'GeekWeb!'
    });
  }

  google.maps.event.addDomListener(window, 'load', initialize);




/*

OPCION # DOS

function success(position) { 
  var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
  var myOptions = {
        zoom: 15,
        center: latlng,
        mapTypeControl: false,
        navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
        mapTypeId: google.maps.MapTypeId.ROADMAP
      };
  var map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions);
      
  var marker = new google.maps.Marker({
          position: latlng, 
          map: map, 
          title:"You are here! (at least within a "+position.coords.accuracy+" meter radius)"
      });
}

function error(msg) {
  var s = document.querySelector('#status');
  s.innerHTML = typeof msg == 'string' ? msg : "failed";
  s.className = 'fail';
      
  secondMapOptions(); 

}

if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(success, error);
} else {
  error('not supported');

  
}

*/

