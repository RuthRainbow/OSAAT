<?php
$pagename = 'My Campaigns';
include('header.php');
require_login();
?>
<h2>Campaigns I created</h2>
<table id="created">
	<tr><th>Name</th></tr>
<?
$result = $mysqli->query('SELECT * FROM '.$mysql_prefix.'SfCs WHERE Creator='.$login['id']);
while($row = $result->fetch_assoc())
{
	echo('<tr><td><a href="sfc.php?id='.$row['ID'].'">'.$row['Name'].'</a></td></tr>');
}
?>
</table>

<h2>Campaigns I voted for</h2>
<table id="voted">
	<tr><th>Name</th></tr>
<?
$result = $mysqli->query('SELECT * FROM '.$mysql_prefix.'UsersVotes WHERE UserID='.$login['id']);
while($row = $result->fetch_assoc())
{
	$result2 = $mysqli->query('SELECT * FROM '.$mysql_prefix.'SfCs WHERE ID='.$row['SfCID']);
	while($row2 = $result2->fetch_assoc())
	{
		echo('<tr><td><a href="sfc.php?id='.$row['SfCID'].'">'.$row2['Name'].'</a></td></tr>');
	}
}
?>
</table>
<?
include('footer.php');
