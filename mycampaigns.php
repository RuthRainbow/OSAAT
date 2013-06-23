<?php
$pagename = 'My Campaigns';
include('header.php');
require_login();
?>
<h2>Campaigns I created</h2>
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

<h2>Campaigns I voted for</h2>
<?
include('footer.php');
