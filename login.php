<?php
$pagename = 'Login';
include('header.php');
?>
<form>
Username: <input type="text" name="username"><br>
Password: <input type="text" name="password">
</form>
<button> Login </button>
<form action="new_account.html">
    <input type="submit" value="Create a new account">
</form>
</body>
<?include('footer.php');
