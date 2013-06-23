<?php
$pagename = 'Create a new campaign';
include('header.php');

require_login();
$error = false;
$errors = array();
if(isset($_POST['submit']))
{
	if (isset($_POST['name']) && strlen($_POST['name'])>2 && strlen($_POST['name'])<50) {
		$name = $_POST['name'];
	} else {
		$error = true;
		array_push($errors, "Enter a name for the campaign between 3 and 50 characters");
	}
	if (isset($_POST['details']) && strlen($_POST['details']) > 0) {
		$details = $_POST['details'];
	} else {
		$error = true;
		array_push($errors, "Enter some details about the campaign");
	}
	if (isset($_POST['location']) && strlen($_POST['location']) > 0) {
		$location = $_POST['location'];
	} else {
		$error = true;
		array_push($errors, "Enter a location");
	}
	/*
	if (isset($_POST['latitude']) && strlen($_POST['latitude']) > 0) {
		$latitude = $_POST['latitude'];
	} else {
		$error = true;
		array_push($errors, "Enter a latitude");
	}
	if (isset($_POST['longitude']) && strlen($_POST['longitude']) > 0) {
		$longitude = $_POST['longitude'];
	} else {
		$error = true;
		array_push($errors, "Enter a longitude");
	}
	*/

	if (!$error) {
		//lookup location:
		$geolookup = json_decode(file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($_POST['location']).'&sensor=false'));
		$latitude = $geolookup->results[0]->geometry->location->lat;
		$longitude = $geolookup->results[0]->geometry->location->lng;
		if ($result = $mysqli->query("INSERT INTO " . $mysql_prefix . "SfCs(Name, Creator, Details, Location, Latitude, Longitude) VALUES (
			'".$mysqli->real_escape_string($name)."',
			'".$mysqli->real_escape_string($login['id'])."',
			'".$mysqli->real_escape_string($details)."',
			'".$mysqli->real_escape_string($location)."',
			'".$mysqli->real_escape_string($latitude)."',
			'".$mysqli->real_escape_string($longitude)."')")
		&&
		$result2 = $mysqli->query("INSERT INTO " . $mysql_prefix . "SfCMods(UserID, SfCID) VALUES (
			'".$mysqli->real_escape_string($login['id'])."',
			'".$mysqli->real_escape_string($mysqli->insert_id)."')"))
		{
?>
		<p>Your new campaign has been created.</p>
<?php		
		} else {
			$error = true;
			array_push($errors, $mysqli->error);
		}
	}
}
if (!isset($_POST['submit']) || $error) {

	if ($error) {
		echo '<p class="error">Please correct the following errors:</p><ul class="error"><li>'.implode('</li><li>', $errors).'</li></ul>';
	}
?>

	<form action="" method="post">
		Name: <input type="text" name="name" value="<?php echo (isset($name) ? htmlspecialchars($name) : '') ?>" /><br />
		Details: <input type="text" name="details" value="<?php echo (isset($details) ? htmlspecialchars($details) : '') ?>" /><br />
		Location: <input type="text" name="location" value="<?php echo(isset($location) ? htmlspecialchars($location) : '') ?>" /><br />
		<!--Latitude: <input type="text" name="latitude" value="<?php echo(isset($latitude) ? htmlspecialchars($latitude) : '') ?>" /><br />
		Longitude: <input type="text" name="longitude" value="<?php echo(isset($longitude) ? htmlspecialchars($longitude) : '') ?>" /><br />
--!>

		<input type="submit" value="Create" name="submit" />
	</form>
<?
}
include('footer.php');
