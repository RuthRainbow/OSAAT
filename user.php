<?php
$pagename = 'Organisations';
include('header.php');
$ID = $_GET["id"];
$query = 'SELECT * FROM '.$mysql_prefix.'Users WHERE ID = '.$mysqli->real_escape_string($ID);

$result = $mysqli->query($query);

if(!$result) {
        $message = 'Invalid query: '.mysql_error()."\n";
        $message .= 'Whole query: '.$query;
        die($message);
}

$row = $result->fetch_assoc();
?>
<h1><?echo(stripslashes($row['FirstName'])." ".stripslashes($row['SecondName']));?></h1>
<p><?echo(stripslashes($row['Age']))?></p>
<div class="area">
        <span class="fieldname">Expertise</span><span class="data"><?echo(stripslashes($row['Expertise']))?></span>
</div>
<div class="area">
        <span class="fieldname">Interests</span><span class="data"><?echo(stripslashes($row['Interests']))?></span>
</div>
<?include('footer.php');

