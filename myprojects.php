<?php
$pagename = 'My Projects';
include('header.php');
require_login();
?>
<h2>Projects I created</h2>
<table id="created">
	<tr><th>Name</th></tr>
<?
$result = $mysqli->query('SELECT * FROM OS_SfCs WHERE Creator='.$login['id']);
while($row = $result->fetch_assoc())
{
	echo('<tr><td><a href="sfc.php?id='.$row['ID'].'">'.$row['Name'].'</a></td></tr>');
}
?>
</table>

<h2>Projects I voted for</h2>
<?
include('footer.php');
