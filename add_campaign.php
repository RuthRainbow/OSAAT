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
		$details = $_POST['location'];
	} else {
		$error = true;
		array_push($errors, "Enter some details about the campaign");
	}

	if (!$error) {
		if ($result = $mysqli->query("INSERT INTO " . $mysql_prefix . "SfCs(Name, Creator, Details) VALUES (
			'".$mysqli->real_escape_string($name)."',
			'".$mysqli->real_escape_string($login['id'])."',
			'".$mysqli->real_escape_string($details)."')")
		&&
		$result2 = $mysqli->query("INSERT INTO " . $mysql_prefix . "SfCMods(UserID, SfCID) VALUES (
			'".$mysqli->real_escape_string($login['id'])."',
			'".$mysqli->real_escape_string($mysqli->insert_id)))
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

		<input type="submit" value="Create" name="submit" />
	</form>
<?
}
include('footer.php');
