<?php
include('header.php');
setcookie ($cookie_name, "", time() - 3600);
unset($login);
?>
		<p>Successfully logged out</p>
<?php
include 'footer.php';
