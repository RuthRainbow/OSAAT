<?php
$pagename = 'SFCs';
include('header.php');
$ID = $_GET["id"];
$query = sprintf("SELECT * FROM OS_SfCs WHERE ID = '$ID'");

// Perform Query
$result = $mysqli->query($query);
 
// Check result
// This shows the actual query sent to MySQL, and the error. Useful for debu    gging.
if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}


// Use result
// Attempting to print $result won't allow access to information in the reso    urce
// One of the mysql result functions must be used
// See also mysql_result(), mysql_fetch_array(), mysql_fetch_row(), etc.
$row = $result->fetch_assoc();
$name = $row['Name'];
$creator = $row['Creator'];
$details = $row['Details'];

?>

	<h2><?echo($name)?></h2>
	<p><?echo($details)?></p>
	<div id="map-canvas" style="height: 400px; width: 400px;"></div>
<?

// Free the resources associated with the result set
// This is done automatically at the end of the script
$result->free_result();
?>

<script>
function initialize() {
	var myLatlng = new google.maps.LatLng(<?echo($row['Latitude'])?>, <?echo($row['Longitude'])?>)
	var mapOptions = {
		zoom: 5,
		center: myLatlng,
		//mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
	var marker = new google.maps.Marker({
		position: myLatlng,
		map: map,
		title: "<?echo($name)?>"
	});
}

function loadScript() {
	var script = document.createElement("script");
	script.type = "text/javascript";
	script.src = "http://maps.googleapis.com/maps/api/js?key=<?echo($maps_api_key);?>&sensor=false&callback=initialize";
	document.body.appendChild(script);
}

window.onload = loadScript;
</script>
<?include('footer.php');
