<?php
$pagename = 'People';
include('header.php');

if(isset($_GET['id'])) {
	$ID = $_GET["id"];
	$query = "SELECT * FROM OS_Users WHERE ID = '".$mysqli->real_escape_string($ID)."'";

	$result = $mysqli->query($query);

	if (!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $query;
		die($message);
	}

	$row = $result->fetch_assoc();
?>
<h1><?echo(stripslashes($row['FirstName']).' '.stripslashes($row['SecondName']))?></h1>
<div class="area">
	<span class="fieldname">Expertise</span><span class="data"><?echo(stripslashes($row['Expertise']))?></span>
</div>
<div class="area">
	<span class="fieldname">Interests</span><span class="data"><?echo(stripslashes($row['Interests']))?></span>
</div>
<div class="area">
	<span class="fieldname">Location</span>
	<span class="data">
		<?echo(stripslashes($row['Location']))?>
		<div id="map-canvas"></div>
	</span>
</div>

<script type="text/javascript">
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
<?
} else {
$result = $mysqli->query('SELECT * FROM '.$mysql_prefix.'Users ORDER BY SecondName');

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}
?>
<div id="popular">
	<h2>People</h2>
	<table>
<?
while ($row = $result->fetch_assoc()) {
?>
		<tr>
			<td>
				<div class="campaign-name">
					<a class="campaign-name" href="people.php?id=<?echo($row['ID'])?>">
						<?echo(stripslashes($row['FirstName']).' '.stripslashes($row['SecondName']))?>
					</a>
				</div>
				<div class="campaign-desc">
					Expert on: <?$string=stripslashes($row['Expertise']);echo((strlen($string)>50)?substr($string,0,47).'...':$string)?>
				</div>
			</td>
		</tr>
<?
}
$result->free();
?>
	</table>
</div>
<?
}
include('footer.php');
