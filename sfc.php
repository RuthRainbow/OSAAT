<?php
$pagename = 'SFCs';
include('header.php');
$ID = $_GET["id"];
$query = sprintf("SELECT * FROM OS_SfCs WHERE ID = '$ID'");

// Perform Query
$result = $mysqli->query($query);
 
// Check result
// This shows the actual query sent to MySQL, and the error. Useful for debu    gging.
if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}


// Use result
// Attempting to print $result won't allow access to information in the reso    urce
// One of the mysql result functions must be used
// See also mysql_result(), mysql_fetch_array(), mysql_fetch_row(), etc.
$row = $result->fetch_assoc();
$name = $row['Name'];
$creator = $row['Creator'];
$details = $row['Details'];

echo "<h2>".$name."</h2>";
echo "<p>".$details."</p>";

// Free the resources associated with the result set
// This is done automatically at the end of the script
$result->free_result();
?>
<div id="input_form">
<form name="input" action="" method="get">
<input type="submit" value="Up vote!" id="submit">
</form>
</div>

<script type="text/javascript"> 
$(function() {  
  $("#submit").click(function() {  

	var dataString = 'sfcID=' + "<?php echo $ID; ?>";
	$.ajax({
		type:"POST",
		url:"processVote.php",
		data: dataString,
		success: function() {
			alert("Thanks for your vote");
		},	
		error: function() {
			alert("You must be logged in to vote");
		}
	});
	return false;   
  });  
}); 
</script>
<?include('footer.php');
