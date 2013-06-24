<?php
$pagename = 'View campaign';
include('header.php');
if(isset($_GET['id'])) {
$ID = $_GET["id"];
$query = 'SELECT * FROM '.$mysql_prefix.'SfCs WHERE ID = '.$mysqli->real_escape_string($ID);

$result = $mysqli->query($query);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}

$row = $result->fetch_assoc();
?>
<h1><?echo(stripslashes($row['Name']))?></h1>
<div class="area">
	<span class="fieldname">Supporters</span><span class="data supporters-num"><?echo(stripslashes($row['NumVotes']))?></span>
</div>
<div class="area">
	<span class="fieldname">Details</span><span class="data"><?echo(stripslashes($row['Details']))?></span>
</div>
<div class="area">
	<span class="fieldname">tags</span><span class="data"><?echo(stripslashes($row['Tags']))?></span>
</div>
<div class="area">
	<span class="fieldname">Location</span>
	<span class="data">
		<?echo(stripslashes($row['Location']))?>
		<div id="map-canvas"></div>
	</span>
</div>
<?
$result->free_result();
$result = $mysqli->query('SELECT * FROM '.$mysql_prefix.'UsersVotes WHERE UserID='.$login['id'].' AND SfCID='.$mysqli->real_escape_string($ID));
?>
<div id="button-container">
	<form name="input" action="" method="post">
<?
if($result->num_rows){
?>
		<input class="button support-button supported" type="submit" value="I support this campaign!" id="submit" disabled="disabled"/>
<?
} else {
?>
		<input class="button support-button" type="submit" value="Support this campaign!" id="submit" />
<?
}
?>
	</form>
</div>

<?
$result = $mysqli->query('SELECT * FROM '.$mysql_prefix.'SfCMods WHERE UserID='.$login['id'].' AND SfCID='.$mysqli->real_escape_string($ID));
?>

<div id="mod-container">
      <form name="mod" action="" method="post">
<?
if($result->num_rows) {
?>
         <input class="button support-button supported" type="submit" value="I'm a moderator" id="mod" disabled="disabled"/>
 <?      
 } else {
 ?>
         <input class="button support-button" type="submit" value="Become a moderator" id="mod"/>
 <?      
 }
 ?>
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
				$("#submit").attr("value","I support this campaign!");
				$("#submit").addClass("supported");
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

$(function() {
        $("#mod").click(function() {
                var dataString = 'sfcID=' + "<?php echo $ID; ?>";
                $.ajax({
                        type:"POST",
                        url:"process_mod.php",
                        data: dataString,
                        success: function() {
                                $("#mod").attr("disabled","disabled");
                                $("#mod").attr("value","I'm a moderator");
                                $("#mod").addClass("supported");
                                alert("Thanks for volunteering to become a moderator");
                        },      
                        error: function(jqXHR, textStatus, errorThrown) {
                                if(errorThrown == 'Unauthorized'){
                                        alert("You must be logged in to become a moderator");
                                }
                                else if(errorThrown == 'Conflict'){
                                        alert("You are already a moderator");
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
<?
} else {
$result = $mysqli->query('SELECT * FROM '.$mysql_prefix.'SfCs ORDER BY NumVotes DESC');

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}
?>
<div id="popular">
	<h2>Popular campaigns</h2>
	<table>
<?
while ($row = $result->fetch_assoc()) {
?>
		<tr>
			<td class="votes">
				<?echo($row['NumVotes'])?>
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
<?
}
include('footer.php');
