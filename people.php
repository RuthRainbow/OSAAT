<?php
$pagename = 'Campaigns';
include('header.php');
?>
<?php

// Perform Query
$result = $mysqli->query('SELECT * FROM '.$mysql_prefix.'Users');

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
        echo "<tr><td style='width: 200px;'><a href='user.php?id=".$row['ID']."'>".stripslashes($row['FirstName'])." ".stripslashes($row['SecondName'])."</a></td></tr>";
}

 echo"</table>";

// Free the resources associated with the result set
// This is done automatically at the end of the script
$result->free_result();
include('footer.php');

