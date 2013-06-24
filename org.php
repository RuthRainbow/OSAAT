<?php 
$pagename = 'Organisations';
include('header.php');
$ID = $_GET["id"];
$query = 'SELECT * FROM '.$mysql_prefix.'Orgs WHERE ID = '.$mysqli->real_escape_string($ID);

$result = $mysqli->query($query);

if(!$result) {
	$message = 'Invalid query: '.mysql_error()."\n";
	$message .= 'Whole query: '.$query;
	die($message);
}

$row = $result->fetch_assoc();
?>
<h1><?echo(stripslashes($row['Name']))?></h1>
<div class="area">
	<span class="fieldname">Description</span><span class="data"><?echo(stripslashes($row['Description']))?></span>
</div>
<div class="area">
	<span class="fieldname">Website</span><span class="data">
<?
if($row['Website'] == '') {
	echo('None');
} else {
?>
		<a href="<?echo(stripslashes($row['Website']))?>"><?echo(stripslashes($row['Website']))?></a>
<?
}
?>
	</span>
</div>
<div class="area">
	<span class="fieldname">Location</span>
	<span class="data">
		<?echo(stripslashes($row['Location']))?>
		<div id="map-canvas"></div>
	</span>
</div>
	<div id="map-canvas" style="height: 400px; width: 400px;"></div>
<?
$result->free_result();
?>

<div id="input_form">
<form name="input" action="" method="get">
<input type="submit" value="Join" id="submit">
</form>
</div>

<script type="text/javascript">
$(function() {  
  $("#submit").click(function() {  
        var dataString = 'orgID=' + "<?php echo $ID; ?>";
        $.ajax({
                type:"POST",
                url:"join_org.php",
                data: dataString,
                success: function() {
                        alert("You have joined this organisation");
                },      
                error: function() {
                        alert("You must be logged in to join organisations");
                }
        });
        return false;   
  });  
}); 

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
