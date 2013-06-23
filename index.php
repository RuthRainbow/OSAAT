<?php
$pagename = 'Campaigns';
include('header.php');
?>
<p>Welcome to the campaign collaboration webspace. Please browse campaigns to vote and have your say or create your own campaign suggestion.</p>
<p>Click <a href="new_account.php">here</a> to create a new account</p>
<?php

// Perform Query
$result = $mysqli->query("SELECT * FROM OS_SfCs");

// Check result
// This shows the actual query sent to MySQL, and the error. Useful for debugging.
if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}

 echo "<table>";
  echo "<tr><th>Name</th></tr>";

// Use result
// Attempting to print $result won't allow access to information in the resource
// One of the mysql result functions must be used
// See also mysql_result(), mysql_fetch_array(), mysql_fetch_row(), etc.
while ($row = $result->fetch_assoc()) {
	echo "<tr><td style='width: 200px;'><a href='sfc.php?id=".$row['ID']."'>".stripslashes($row['Name'])."</a></td></tr>";
}

echo"</table>";
    
// Free the resources associated with the result set
// This is done automatically at the end of the script
$result->free_result();
include('footer.php');
