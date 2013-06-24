<?php
$pagename='My Organisations';
include('header.php');
require_login();
?>
<p>Click <a href="add_org.php">here</a> to register a new organisation.
<h2>Organisations I lead</h2>
<table id="leader">
	<tr><th>Name</th></tr>
<?
$result = $mysqli->query('SELECT * FROM '.$mysql_prefix.'Orgs WHERE Leader='.$login['id']);
while($row = $result->fetch_assoc()) {
	echo('<tr><td><a href="org.php?id='.$row['ID'].'">'.stripslashes($row['Name']).'</a></td></tr>');
}
?>
</table>

<h2>Organisations I administrate</h2>
<table id="admin">
	<tr><th>Name</th></tr>
<?
$result = $mysqli->query('SELECT * FROM '.$mysql_prefix.'Admins WHERE UserID='.$login['id']);
while($row = $result->fetch_assoc()) {
	$result2 = $mysqli->query('SELECT * FROM '.$mysql_prefix.'Orgs WHERE ID='.$row['OrgID']);
	while($row2 = $result2 -> fetch_assoc()) {
		echo('<tr><td><a href="org.php?id='.$row2['ID'].'">'.stripslashes($row2['Name']).'</a></td></tr>');
	}
}
?>
</table>

<h2>Organisations I am a member of</h2>
<table id="member">
	<tr><th>Name</th></tr>
<?
$result = $mysqli->query('SELECT * FROM '.$mysql_prefix.'UserOrgs WHERE UserID='.$login['id']);
while($row = $result->fetch_assoc()) {
        $result2 = $mysqli->query('SELECT * FROM '.$mysql_prefix.'Orgs WHERE ID='.$row['OrgID']);
        while($row2 = $result2 -> fetch_assoc()) {
                echo('<tr><td><a href="org.php?id='.$row['ID'].'">'.stripslashes($row2['Name']).'</a></td></tr>');
        }
}
?>
</table>
<?
include('footer.php');
