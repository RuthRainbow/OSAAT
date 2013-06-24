<?php
$pagename = 'Register an Organisation';
include('header.php');

require_login();
$error = false;
$errors = array();

if (isset($_POST['submit'])) {
	if (isset($_POST['name']) && strlen($_POST['name'])>2 && strlen($_POST['name'])<50) {
		$name = $_POST['name'];
	} else {
		$error = true;
		array_push($errors, "Enter a name for the organisation");
	}
	if (isset($_POST['description']) && strlen($_POST['description']) > 0) {
		$description = $_POST['description'];
	} else {
		$error = true;
		array_push($errors, "Please enter a description");
	}
	if (isset($_POST['location']) && strlen($_POST['location']) > 0) {
		$location = $_POST['location'];
	} else {
		$error = true;
		array_push($errors, "Please enter a location");
	}
	if (isset($_POST['webpage'])) {
		$webpage = $_POST['webpage'];
	}

	if (!$error) {
		//lookup location:
		$geolookup = json_decode(file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($_POST['location']).'&sensor=false'));
		$latitude = $geolookup->results[0]->geometry->location->lat;
		$longitude = $geolookup->results[0]->geometry->location->lng;

		if ($result = $mysqli -> query("INSERT INTO ".$mysql_prefix."Orgs(Name, Description, Leader, Location, Website, Latitude, Longitude) VALUES (
			'".$mysqli->real_escape_string($name)."',
			'".$mysqli->real_escape_string($description)."',
			'".$mysqli->real_escape_string($login['id'])."',
			'".$mysqli->real_escape_string($location)."',
			'".$mysqli->real_escape_string($webpage)."',
			'".$mysqli->real_escape_string($latitude)."',
			'".$mysqli->real_escape_string($longitude)."')") 
			&&
			$result2 = $mysqli->query("INSERT INTO ".$mysql_prefix."Admins(UserID, OrgID) VALUES (
			'".$mysqli->real_escape_string($login['id'])."',
			'".$mysqli->real_escape_string($mysqli->insert_id)."')")) {
?>
			<p>Your new organisation has been created.</p>
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
		Description: <input type="text" name="description" value="<?php echo (isset($description) ? htmlspecialchars($description) : '') ?>" /><br/>
		Location: <input type="text" name="location" value="<?php echo (isset($location) ? htmlspecialchars($location) : '') ?>"/><br/>
		Website: <input type="text" name="webpage" value="<?php echo (isset($webpage) ? htmlspecialchars($webpage) : '') ?>"/><br/>
		
		<input type="submit" value="Create" name="submit"/>
	</form>
<?
}
include('footer.php');
