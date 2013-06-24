<?php
$pagename = 'Campaigns';
include('header.php');
?>
<p>Welcome to the campaign collaboration webspace. Please browse campaigns to vote and have your say or create your own campaign suggestion.</p>
<p>Click <a href="new_account.php">here</a> to create a new account</p>
<?php

$result = $mysqli->query("SELECT * FROM OS_SfCs");

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}
?>
<table>
<tr><th>Votes</th><th>Name</th></tr>
<?
while ($row = $result->fetch_assoc()) {
?>
	<tr>
		<td class="votes">
			<?echo($row['NumVotes'])?>
		</td>
		<td class="campaign-name">
			<a href="sfc.php?id=<?echo($row['ID'])?>">
				<?echo(stripslashes($row['Name']))?>
			</a>
		</td>
	</tr>
<?
}
?>
</table>
<?
$result->free_result();
include('footer.php');
