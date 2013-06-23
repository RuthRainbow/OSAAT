<?php
// Db stuff
include("config.php");

$mysqli = new mysqli("localhost", $mysql_user, $mysql_password, $mysql_db);

$login_error = false;
$login_errors = array();
if (isset($_POST['submit_login'])) {
	if (existsWithLength('username')) {
		$logindetails = $_POST['username'];
	} else {
		$login_error = true;
		array_push($login_errors, "Enter your username");
	}

	if (existsWithLength('username')) {
		$password = $_POST['password'];
	} else {
		$login_error = true;
		array_push($login_errors, "Enter your password");
	}

	if (!$login_error) {
		if ($result = $mysqli->query("SELECT ID, Salt, Password FROM " . $mysql_prefix . "Users WHERE Username='".$mysqli->real_escape_string($logindetails)."' LIMIT 0,1")) {
			$login_error = true;
			array_push($login_errors, "Invalid login");
			while ($row = $result->fetch_assoc()) {
				if (hash('sha256',$row['Salt'].$password) == $row['Password']) {
					$login_error = false;
					setcookie($cookie_name, base64_encode($logindetails).":".hash('sha256',$logindetails.$row['Password']));
					$login['username'] = $logindetails;
					$login['id'] = $row['ID'];
				} else {
					$login_error = true;
					$login_errors = array("Invalid login");
				}
			}
		} else {
			printf("Error logging in: %s\n", $mysqli->error);
		}
	}
}

// Login stuff
if(isset($_COOKIE[$cookie_name])) {
	$login = $_COOKIE[$cookie_name];
	$login = explode(":", $login);
	$login['username'] = base64_decode($login[0]);
	$loginfail = true;
	
	if($result = $mysqli->query("SELECT ID, Password FROM " . $mysql_prefix . "Users WHERE Username='".$mysqli->real_escape_string($login['username'])."' LIMIT 0,1")) {
		while ($row = $result->fetch_assoc()) {
			if ($login[1] == hash('sha256', $login['username'].$row['Password'])) {
				$loginfail = false;
				$login['id'] = $row['ID'];
			}
		}
	}
	if($loginfail) {
		unset($login);
		setcookie ($cookie_name, "", time() - 3600);
	}
}

function require_login() {
	global $login;
	if (!isset($login['id'])) {
		echo '<h2>Error</h2><p>Please log in to access this page.</p>';
		include 'footer.php';
		exit();
	}
}

function existsWithLength($field, $length=0) {
	return isset($_POST[$field]) && strlen($_POST[$field]) > $length;
}
