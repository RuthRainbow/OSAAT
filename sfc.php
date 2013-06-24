<?php
$pagename = 'View campaign';
include('header.php');
$ID = $_GET["id"];
$query = "SELECT * FROM OS_SfCs WHERE ID = '".$mysqli->real_escape_string($ID)."'";

$result = $mysqli->query($query);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}

$row = $result->fetch_assoc();
?>
	<h2><?echo(stripslashes($row['Name']))?></h2>
	<p><?echo(stripslashes($row['Location']))?></p>
	<p><?echo(stripslashes($row['Details']))?></p>
	<p><?echo($row['NumVotes'])?></p>
	<div id="map-canvas" style="height: 400px; width: 400px;"></div>
<?
$result->free_result();
$result = $mysqli->query('SELECT * FROM '.$mysql_prefix.'UsersVotes WHERE UserID='.$login['id'].' AND SfCID='.$mysqli->real_escape_string($ID));
?>
<div id="input_form">
	<form name="input" action="" method="post">
		<input type="submit" value="Up vote!" id="submit" <?if($result->num_rows){echo('disabled="disabled"');}?> />
	</form>
</div>

<script type="text/javascript">
$(function() {
	$("#submit").click(function() {
		var dataString = 'sfcID=' + "<?php echo $ID; ?>";
		$.ajax({
			type:"POST",
			url:"process_vote.php",
			data: dataString,
			success: function() {
				$("#submit").attr("disabled","disabled");
				alert("Thanks for your vote");
			},	
			error: function(jqXHR, textStatus, errorThrown) {
				if(errorThrown == 'Unauthorized'){
					alert("You must be logged in to vote");
				}
				else if(errorThrown == 'Conflict'){
					alert("You have already voted on this");
				}
				else{
					alert("Unknown error");
				}
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
