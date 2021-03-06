<?php
$pagename = 'Create a new account';
include('header.php');

$error = false;
$errors = array();

if(isset($_POST['submit']))
{
	if(existsWithLength('username') && strlen($_POST['username'])<50) {
		$username = $_POST['username'];
	} else {
		$error = true;
		array_push($errors, "Enter a username between 3 and 50 characters");
	}

	if(existsWithLength('password', 2)) {
		$password = $_POST['password'];
	} else {
		$error = true;
		array_push($errors, "Enter a password of at least 3 characters");
	}

	if(existsWithLength('firstname')) {
		$firstname = $_POST['firstname'];
	} else {
		$error = true;
		array_push($errors, "Enter a first name");
	}

	if(existsWithLength('lastname')) {
		$lastname = $_POST['lastname'];
	} else {
		$error = true;
		array_push($errors, "Enter a last name");
	}

	if(existsWithLength('email')) {
		$email = $_POST['email'];
	} else {
		$error = true;
		array_push($errors, "Enter an email address");
	}

	if(existsWithLength('age') && $_POST['age'] > 0) {
		$age = $_POST['age'];
	} else {
		$error = true;
		array_push($errors, "Enter an age");
	}

	if(existsWithLength('interests')) {
		$interests = $_POST['interests'];
	} else {
		$error = true;
		array_push($errors, "Enter some interests");
	}

	if(existsWithLength('expertise')) {
		$expertise = $_POST['expertise'];
	} else {
		$error = true;
		array_push($errors, "Enter an expertise");
	}

	if(existsWithLength('location')) {
		$location = $_POST['location'];
	} else {
		$error = true;
		array_push($errors, "Enter your location");
	}

	if (!$error) {
		//lookup location:
		$geolookup = json_decode(file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($_POST['location']).'&sensor=false'));
		$latitude = $geolookup->results[0]->geometry->location->lat;
		$longitude = $geolookup->results[0]->geometry->location->lng;

		$salt = hash('sha256', mcrypt_create_iv(20));
		$passwordHash = hash('sha256', $salt.$password);
		if ($result = $mysqli->query("INSERT INTO " . $mysql_prefix . "Users(Username, Password, Salt, FirstName, SecondName, Email, Age, Interests, Expertise, Location, Latitude, Longitude) VALUES (
			'".$mysqli->real_escape_string($username)."',
			'".$passwordHash."',
			'".$salt."',
			'".$mysqli->real_escape_string($firstname)."',
			'".$mysqli->real_escape_string($lastname)."',
			'".$mysqli->real_escape_string($email)."',
			'".$mysqli->real_escape_string($age)."',
			'".$mysqli->real_escape_string($interests)."',
			'".$mysqli->real_escape_string($expertise)."',
			'".$mysqli->real_escape_string($location)."',
			'".$mysqli->real_escape_string($latitude)."',
			'".$mysqli->real_escape_string($longitude)."')")) {
?>
		<p>Congratulations, you are now registered, you may now login</p>
<?php

		} else {
			$error = true;
			array_push($errors, $mysqli->error);
		}
	}
}

if (!isset($_POST['submit']) || $error) {

	if ($error) {
		echo '<p class="error">Please correct the following errors:</p><ul class="error"><li class="error">'.implode('</li><li class="error">', $errors).'</li></ul>';
	}
?>
<form id="newaccountform" action="" method="post">
<table>
	Username:<input type="text" name="username" value="<?php echo (isset($username) ? htmlspecialchars($username) : '') ?>" /><br>
	Password: <input type="password" name="password" value="" /><br>
	First name: <input type="text" name="firstname" value="<?php echo (isset($firstname) ? htmlspecialchars($firstname) : '') ?>" /><br>
	Last name: <input type="text" name="lastname" value="<?php echo (isset($lastname) ? htmlspecialchars($lastname) : '') ?>" /><br>
	Email: <input type="text" name="email" value="<?php echo (isset($email) ? htmlspecialchars($email) : '') ?>" /><br>
	Age: <input type="number" name="age" value="<?php echo (isset($age) ? htmlspecialchars($age) : '') ?>" /><br>
	Interests: <input type="text" name="interests" value="<?php echo (isset($interests) ? htmlspecialchars($interests) : '') ?>" /><br>
	Expertise: <input type="text" name="expertise" value="<?php echo (isset($expertise) ? htmlspecialchars($expertise) : '') ?>" /><br>
	Location: <input type="text" name="location" value="<?php echo (isset($location) ? htmlspecialchars($location) : '') ?>" /><br>

	<input type="submit" value="Create" name="submit" />
</table>
</form>
<?
}
include('footer.php');
