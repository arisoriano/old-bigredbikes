<?php
$PAGE_TITLE='Bikes';
?>

<!DOCTYPE html>
<head>
    <link type='text/css' rel='stylesheet' href='../css/style.css'/>
    <link type='text/css' rel='stylesheet' href='../css/bikes.css'/>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDviIwALDA5QNlmDENDFaRHphmN6S8T7vU&amp;sensor=false"></script>
    <?php include 'head.php'; 
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $result = $mysqli->query("SELECT * FROM Stations");

        //Pulls list of bikes from database and prints to page
        //If logged in user is admin add admin functionalities 
        //Load stations data from database to array
        //Includes Google map javascript API to locate and pin stations with available bikes
        //To ensure compatibility with disabled javascript, allow option to display static list of stations info
        function debug( $data ) {

            if ( is_array( $data ) )
                $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
            else
                $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

            echo $output;
        }
    ?>
    
<!-- When the user clicks the marker, an info window opens.
The maximum width of the info window is set to 200 pixels. -->

<?php
echo
"<script>
function getLocations(){

  console.log('In getLocations');

  $.ajax({
    url: 'stations.php',
    type:'get',
    dataType:'json',
    success:function(res){
      console.log(res);
    }
  });


}


function initialize() {
  var mapOptions = {
    zoom: 14,
    center: new google.maps.LatLng(42.449844, -76.480765)
  };
  
  var geocoder= new google.maps.Geocoder();
  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  
  if (navigator.geolocation) {
         navigator.geolocation.getCurrentPosition(function (position) {
             initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
             map.setCenter(initialLocation);
             
             var image_here = '../images/marker_here.png'; 
             var marker_here = new google.maps.Marker({
                animation: google.maps.Animation.BOUNCE,
                position: initialLocation,
                map: map,
                icon: image_here,
             }); 
         });
        
     }
";
  $k=0;
  while( $arr = $result->fetch_assoc() ){
    $statName = $arr['name'];
    $statAddress = $arr['address'];
    $countRes= $mysqli->query("SELECT COUNT(*) FROM Bikes WHERE current_station='$statName';");
    $countArr= $countRes->fetch_row();
    $statBikes = $countArr[0];

    $k++;
    
    echo
  "
  var address_$k='$statAddress';
  var latitude_$k= '';
  var longitude_$k= '';
  geocoder.geocode({'address': '$statAddress'}, function(results, status) {
      if(status==google.maps.GeocoderStatus.OK){
          
          latitude_$k = results[0].geometry.location.lat().toString();
          longitude_$k = results[0].geometry.location.lng();
          var location_$k = new google.maps.LatLng(latitude_$k, longitude_$k);
          var string_$k = '<div id=content>' +
                      '<p><b>$statName</b><p>'+
                      '<p>Bikes Available: <b>$statBikes</b><p>'+
                      '</div>';
          var image_$k = '../images/yellow_mapmarkers/marker$k.png';
    
          var window_$k = new google.maps.InfoWindow({
            content: string_$k,
            maxWidth: 200
          });
  
          var marker_$k = new google.maps.Marker({
            animation: google.maps.Animation.DROP,
            position: location_$k,
            map: map,
            icon: image_$k
          });
    
        google.maps.event.addListener(marker_$k, 'click', function() {
            window_$k.open(map,marker_$k);
        });  
       }
  });";
    

  }
  $result->data_seek(0);
  
  echo '}';
  ?>


<?php
echo
"console.log('SCRIPT');
getLocations();
google.maps.event.addDomListener(window, 'load', initialize);

</script>";
?>

  </head>


<body>
    <?php include 'nav.php'; ?>
    <div id='photo'>
        <img src='../images/bikes.png' class='banner_pic' alt='bikes'>
    </div><!--photo-->

    <div id='page_layout'>
        <!-- <div id="map-canvas"></div> -->
        <br/><br/>
      <?php
        function printBikes($result){
            echo "<div id='table_contain'>
                      <div id='table_cell_1'>
                          <table>
                              <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>Station</th>
                                    <th>Bikes</th>
                                    <th>&nbsp;&nbsp;Status</th>
                                </tr>
                              </thead>
                              <tbody>";
                              
             global $mysqli;
             $res= $mysqli->query("SELECT open FROM Status WHERE name='all';");
             $ar= $res->fetch_row();
             $stat= $ar[0];
             $i= 0;

              while ( $array = $result->fetch_assoc() ) {

                $name = $array['name'];
                $address = $array['address'];
                $num_helmets = $array['num_helmets'];
                $num_bikelocks = $array['num_bikelocks'];
                $flagged= $array['flagged'];
                
                $countRes= $mysqli->query("SELECT COUNT(*) FROM Bikes WHERE current_station='$name';");
                $countArr= $countRes->fetch_row();
                $num_bikes= $countArr[0];
                
                $i++;
                
                $displayStat='';
                
                if ($flagged==0&&$stat==1){
                    $displayStat="<img src='../images/open.png' alt='open'>";
                } else{
                    $displayStat="<img src='../images/closed.png' alt='close'>";
                }

                echo "<tr>
                        <td class='center'>$i&nbsp;&nbsp;</td>
                        <td class='left'>$name</td>
                        <td class='center'>$num_bikes</td>
                        <td class='center'>$displayStat</td>
                    </tr>";
            }
        echo"</tbody></table></div><!--table_cell_1--><div id='map-canvas'></div><!--map-canvas--></div><!--table_contain-->";

        debug("PHP");

        }


      if ($mysqli->errno) {
          print($mysqli->error);
          exit();
      }
        
        // Print out all the photos (use printPhotos)
        printBikes($result);

        // Closing connection
        $mysqli->close();
      ?>

    </div><!--page_layout-->
    <div id='footer'>
        <?php include 'footer.php'; ?>
    </div><!--footer-->
</body>
</html>