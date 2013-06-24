<?php
$pagename='My Organisations';
include('header.php');
require_login();
?>
<p>Click <a href="add_org.php">here</a> to register a new organisation.
<div class="content-div">
	<h2>Organisations I lead</h2>
	<table id="leader">
<?
$result = $mysqli->query('SELECT * FROM '.$mysql_prefix.'Orgs WHERE Leader='.$login['id']);
while($row = $result->fetch_assoc()) {
?>
		<tr>
			<td>
				<div class="campaign-name">
					<a class="campaign-name" href="org.php?id=<?echo($row['ID'])?>">
						<?echo(stripslashes($row['Name']))?>
					</a>
				</div>
				<div class="campaign-desc">
					<?$string=stripslashes($row['Description']);echo((strlen($string)>50)?substr($string,0,47).'...':$string)?>
				</div>
			</td>
		</tr>
<?
}
?>
	</table>
</div>
<div class="content-div">
	<h2>Organisations I administrate</h2>
	<table id="admin">
<?
$result = $mysqli->query('SELECT * FROM '.$mysql_prefix.'Admins WHERE UserID='.$login['id']);
while($row = $result->fetch_assoc()) {
	$result2 = $mysqli->query('SELECT * FROM '.$mysql_prefix.'Orgs WHERE ID='.$row['OrgID']);
	while($row2 = $result2->fetch_assoc()) {
?>
		<tr>
			<td>
				<div class="campaign-name">
					<a class="campaign-name" href="org.php?id=<?echo($row['ID'])?>">
						<?echo(stripslashes($row['Name']))?>
					</a>
				</div>
				<div class="campaign-desc">
					<?$string=stripslashes($row['Description']);echo((strlen($string)>50)?substr($string,0,47).'...':$string)?>
				</div>
			</td>
		</tr>
<?
	}
}
?>
	</table>
</div>
<div class="content-div">
	<h2>Organisations I am a member of</h2>
	<table id="member">
<?
$result = $mysqli->query('SELECT * FROM '.$mysql_prefix.'UserOrgs WHERE UserID='.$login['id']);
while($row = $result->fetch_assoc()) {
	$result2 = $mysqli->query('SELECT * FROM '.$mysql_prefix.'Orgs WHERE ID='.$row['OrgID']);
	while($row2 = $result2->fetch_assoc()) {
?>
		<tr>
			<td>
				<div class="campaign-name">
					<a class="campaign-name" href="org.php?id=<?echo($row['ID'])?>">
						<?echo(stripslashes($row['Name']))?>
					</a>
				</div>
				<div class="campaign-desc">
					<?$string=stripslashes($row['Description']);echo((strlen($string)>50)?substr($string,0,47).'...':$string)?>
				</div>
			</td>
		</tr>
<?
	}
}
?>
	</table>
</div>
<?
include('footer.php');
