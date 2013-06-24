<?php
$pagename = 'Campaigns';
include('header.php');
?>
<p>Welcome to the campaign collaboration webspace. Please browse campaigns to vote and have your say or create your own campaign suggestion.</p>
<p>Click <a href="new_account.php">here</a> to create a new account</p>
<?

$result = $mysqli->query('SELECT * FROM '.$mysql_prefix.'SfCs ORDER BY NumVotes DESC');

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}
?>
<h2>Popular campaigns</h2>
<table>
<tr><th>Votes</th><th>Name</th></tr>
<?
while ($row = $result->fetch_assoc()) {
?>
	<tr>
		<td class="votes">
			<?echo($row['NumVotes'])?>
		</td>
		<td class="campaign-name">
			<a href="sfc.php?id=<?echo($row['ID'])?>">
				<?echo(stripslashes($row['Name']))?>
			</a>
		</td>
	</tr>
<?
}
$result->free();
?>
</table>
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
if($result = $mysqli->query('SELECT NumVotes, Name, ID, lat_lng_distance('.$latitude.', '.$longitude.', Latitude, Longitude) AS Distance FROM '.$mysql_prefix.'SfCs ORDER BY Distance ASC'))
{
?>
<h2>Campaigns near <?echo($region)?></h2>
<table>
<tr><th>Votes</th><th>Distance</th><th>Name</th></tr>
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
		<td class="campaign-name">
			<a href="sfc.php?id=<?echo($row['ID'])?>">
				<?echo(stripslashes($row['Name']))?>
			</a>
		</td>
	</tr>
<?
	}
	$result->free();
?>
</table>
<?
} else {
	echo('something broke: '.$mysqli->error);
}
include('footer.php');
