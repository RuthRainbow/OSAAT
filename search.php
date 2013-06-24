<?php
$pagename = 'search results';
include('header.php');
if(isset($_GET['query'])) {
$tags = $_GET["query"];
$result = $mysqli->query("SELECT * FROM OS_SfCs WHERE Tags LIKE '%$tags%' ORDER BY NumVotes DESC");

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}
?>
<div id="popular">
	<h2>Campaigns that match your search</h2>
	<table>
<?
while ($row = $result->fetch_assoc()) {
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
					<?$string=stripslashes($row['Details']);echo((strlen($string)>50)?substr($string,0,47).'...':$string)?>
				</div>
			</td>
		</tr>
<?
}	
$result->free();
?>
</table>
</div>
<?
}
include('footer.php');