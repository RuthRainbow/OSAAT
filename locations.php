<?php
$pagename = 'Locations';
include('header.php');
?>
<?
if(isset($login['id']))
{
	$result = $mysqli->query('SELECT * FROM '.$mysql_prefix.'Users WHERE ID='.$login['id']);
	$row = $result->fetch_assoc();
	$latitude = $row['Latitude'];
	$longitude = $row['Longitude'];
	$region = $row['Location'];
	$result->free();
} else {
	//if user isn't logged on then get their location from their IP:
	$geoip = json_decode(file_get_contents('http://freegeoip.net/json/'.$_SERVER['REMOTE_ADDR']));
	$latitude = $mysqli->real_escape_string($geoip->latitude);
	$longitude = $mysqli->real_escape_string($geoip->longitude);
	$region = $mysqli->real_escape_string($geoip->region_name);
}
$mysqli->query('
	CREATE FUNCTION `lat_lng_distance` (lat1 FLOAT, lng1 FLOAT, lat2 FLOAT, lng2 FLOAT)
	RETURNS FLOAT
	DETERMINISTIC
	BEGIN
	RETURN 6371 * 2 * ASIN(SQRT(
		POWER(SIN((lat1 - abs(lat2)) * pi()/180 / 2),
		2) + COS(lat1 * pi()/180 ) * COS(abs(lat2) *
		pi()/180) * POWER(SIN((lng1 - lng2) *
		pi()/180 / 2), 2) ));
	END
');
if($result = $mysqli->query('SELECT NumVotes, Name, ID, Details, lat_lng_distance('.$latitude.', '.$longitude.', Latitude, Longitude) AS Distance FROM '.$mysql_prefix.'SfCs ORDER BY Distance ASC LIMIT 8'))
{
?>
<div id="geographic" class="content-div">
	<h2>Campaigns near <?echo($region)?></h2>
	<table>
<?
	while ($row = $result->fetch_assoc()) {
?>
		<tr>
			<td class="votes">
				<?echo($row['NumVotes'])?>
			</td>
			<td class="distance">
				<?echo(round($row['Distance']).'km')?>
			</td>
			<td>
				<div class="campaign-name">
					<a class="campaign-name" href="sfc.php?id=<?echo($row['ID'])?>">
						<?echo(stripslashes($row['Name']))?>
					</a>
				</div>
				<div class="campaign-desc">
					<?$string=stripslashes($row['Details']);echo((strlen($string)>50)?substr($string,0,47).'...':$string)?>
				</div>
			</td>
		</tr>
<?
	}
	$result->free();
?>
	</table>
</div>
<div class="content-div" id="map-canvas"></div>
<script type="text/javascript">
function initialize() {
	var myLatlng = new google.maps.LatLng(<?echo($latitude)?>, <?echo($longitude)?>)
	var mapOptions = {
		zoom: 5,
		center: myLatlng,
		//mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
	var sfc_marks = new Array();
	var org_marks = new Array();
<?
if($result = $mysqli->query('SELECT * FROM '.$mysql_prefix.'SfCs'))
{
	while ($row = $result->fetch_assoc()) {
		echo('sfc_marks.push(["'.$row['Name'].'",'.$row['Latitude'].','.$row['Longitude'].','.$row['ID'].']);');
	}
	$result->free();
}
if($result = $mysqli->query('SELECT * FROM '.$mysql_prefix.'Orgs'))
{
	while ($row = $result->fetch_assoc()) {
		echo('org_marks.push(["'.$row['Name'].'",'.$row['Latitude'].','.$row['Longitude'].','.$row['ID'].']);');
	}
	$result->free();
}
?>
	var sfc_mark_array = new Array();
	var org_mark_array = new Array();
	var pinColor = "7777AA";
	var orgImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
		new google.maps.Size(21, 34),
		new google.maps.Point(0,0),
		new google.maps.Point(10, 34)
	);
	var pinColor = "77AA77";
	var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
		new google.maps.Size(21, 34),
		new google.maps.Point(0,0),
		new google.maps.Point(10, 34)
	);
	var pinShadow = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_shadow",
		new google.maps.Size(40, 37),
		new google.maps.Point(0, 0),
		new google.maps.Point(12, 35)
	);
	for(var i=0; i<sfc_marks.length; i++)
	{
		var markLatlng = new google.maps.LatLng(sfc_marks[i][1],sfc_marks[i][2]);
		sfc_mark_array.push(new google.maps.Marker({
			position: markLatlng,
			icon: pinImage,
			shadow: pinShadow,
			map: map,
			title: sfc_marks[i][0],
			url: 'sfc.php?id='+sfc_marks[i][3]
		}));
		google.maps.event.addListener(sfc_mark_array[i], "click", function(i){
			window.location = this.url;
		});
	}
	for(var i=0; i<org_marks.length; i++)
	{
		var markLatlng = new google.maps.LatLng(org_marks[i][1],org_marks[i][2]);
		org_mark_array.push(new google.maps.Marker({
			position: markLatlng,
			icon: orgImage,
			shadow: pinShadow,
			map: map,
			title: org_marks[i][0],
			url: 'org.php?id='+org_marks[i][3]
		}));
		google.maps.event.addListener(org_mark_array[i], "click", function(){
			console.log(this);
			window.location = this.url;
		});
	}
	var marker = new google.maps.Marker({
		position: myLatlng,
		map: map,
		title: "You are here!"
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
	echo('something broke: '.$mysqli->error);
?>
</div>
<?
}
include('footer.php');
