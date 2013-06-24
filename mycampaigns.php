<?php
$pagename = 'My Campaigns';
include('header.php');
require_login();
?>
<p>Click <a href="add_campaign.php">here</a> to add a new campaign.<br />
<div id="created" class="content-div">
	<h2>Campaigns I created</h2>
	<table id="created">
<?
$result = $mysqli->query('SELECT * FROM '.$mysql_prefix.'SfCs WHERE Creator='.$login['id']);
while($row = $result->fetch_assoc())
{
?>
		<tr>
			<td class="votes">
				<?echo($row['NumVotes'])?>
			</td>
			<td>
				<div class="campaign-name">
					<a class="campaign-name" href="sfc.php?id=<?echo($row['ID'])?>">
						<?echo(stripslashes($row['Name']))?>
					</a>
				</div>
				<div class="campaign-desc">
					<?$string=stripslashes($row['Details']);echo((strlen($string)>25)?substr($string,0,22).'...':$string)?>
				</div>
			</td>
		</tr>
<?
}
?>
	</table>
</div>
<div id="voted" class="content-div">
	<h2>Campaigns I voted for</h2>
	<table id="voted">
<?
$result = $mysqli->query('SELECT * FROM '.$mysql_prefix.'UsersVotes WHERE UserID='.$login['id']);
while($row = $result->fetch_assoc())
{
	$result2 = $mysqli->query('SELECT * FROM '.$mysql_prefix.'SfCs WHERE ID='.$row['SfCID']);
	$row2 = $result2->fetch_assoc()
?>
		<tr>
			<td class="votes">
				<?echo($row2['NumVotes'])?>
			</td>
			<td>
				<div class="campaign-name">
					<a class="campaign-name" href="sfc.php?id=<?echo($row2['ID'])?>">
						<?echo(stripslashes($row2['Name']))?>
					</a>
				</div>
				<div class="campaign-desc">
					<?$string=stripslashes($row2['Details']);echo((strlen($string)>25)?substr($string,0,22).'...':$string)?>
				</div>
			</td>
		</tr>
<?
}
?>
	</table>
</div>
<?
include('footer.php');
