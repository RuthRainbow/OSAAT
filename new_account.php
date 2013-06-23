<?php
$pagename = 'Create a new account';
include('header.php');
?>
<form action="javascript:alert('you suck!');return false;">
First name: <input type="text" name="firstname"><br>
Last name: <input type="text" name="lastname"><br>
Email: <input type="text" name="email"><br>
Age: <input type="number" name="age"><br>
Interests: <input type="text" name="interests"><br>
Hobbies: <input type="text" name="hobbies"><br>

<input type="submit" value="Create" />
</form>
<?include('footer.php');
