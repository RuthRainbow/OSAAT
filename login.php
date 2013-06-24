<?php
if(isset($login['id']))
{
?>
Logged in as <a href="people.php?id=<?echo(stripslashes($login['id']))?>"><?echo(stripslashes($login['username']))?></a><br />
<a href="logout.php">Logout</a>
<?
} else {
?>
<form action="" method="post">
	Username: <input type="text" name="username"><br />
	Password: <input type="password" name="password"><br />
	<input type="submit" value="Login" name="submit_login" />
</form>
<a href="new_account.php">Or create a new account</a>
<?
}
