<?php
$pagename = 'Create a new account';
include('header.php');

$error = false;
$errors = array();

function existsWithLength($field, $length=0) {
	return isset($_POST[$field]) && strlen($_POST[$field]) > $length;
}

if(isset($_POST['submit']))
{
	if(existsWithLength('username') && strlen($_POST['username'])<50) {
		$username = $_POST['username'];
	} else {
		$error = true;
		array_push($errors, "Enter a username between 3 and 50 characters");
	}

	if(exists('password', 2)) {
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

	if(existsWithLength('lastname')) {}
		$lastname = $_POST['lastname'];
	} else {
		$error = true;
		array_push($errors, "Enter a last name");
	}

	if(existsWithLength('email') {
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

	if (!$error) {
		$salt = hash('sha256', mcrypt_create_iv(20));
		$passwordHash = hash('sha256', $salt.$password);
		if ($result = $mysqli->query("INSERT INTO " . $mysql_prefix . "Users(Username, Password, Salt, FirstName, SecondName, Email, Age, Interests, Expertise) VALUES (
			'".$mysqli->real_escape_string($username)."',
			'".$passwordHash."',
			'".$salt."',
			'".$mysqli->real_escape_string($firstname)."',
			'".$mysqli->real_escape_string($lastname)."',
			'".$mysqli->real_escape_string($email)."',
			'".$mysqli->real_escape_string($age)."',
			'".$mysqli->real_escape_string($interests)."',
			'".$mysqli->real_escape_string($expertise)."')")) {
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
		echo '<p class="error">Please correct the following errors:</p><ul class="error"><li>'.implode('</li><li>', $errors).'</li></ul>';
	}
?>
<form action="" method="post">
	Username: <input type="text" name="username" value="<?php echo (isset($username) ? htmlspecialchars($username) : '') ?>" /><br>
	Password: <input type="password" name="password" value="" /><br>
	First name: <input type="text" name="firstname" value="<?php echo (isset($firstname) ? htmlspecialchars($firstname) : '') ?>" /><br>
	Last name: <input type="text" name="lastname" value="<?php echo (isset($lastname) ? htmlspecialchars($lastname) : '') ?>" /><br>
	Email: <input type="text" name="email" value="<?php echo (isset($email) ? htmlspecialchars($email) : '') ?>" /><br>
	Age: <input type="number" name="age" value="<?php echo (isset($age) ? htmlspecialchars($age) : '') ?>" /><br>
	Interests: <input type="text" name="interests" value="<?php echo (isset($interests) ? htmlspecialchars($interests) : '') ?>" /><br>
	Expertise: <input type="text" name="expertise" value="<?php echo (isset($expertise) ? htmlspecialchars($expertise) : '') ?>" /><br>

	<input type="submit" value="Create" name="submit" />
</form>
<?
}
include('footer.php');
