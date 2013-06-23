<?php
$pagename = 'Campaigns';
include('header.php');

$link = mysql_connect('localhost', 'ruth', 'password');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully';
mysql_select_db("ruth") or die(mysql_error())
?>







<p>Welcome to the campaign collaboration webspace. Please browse campaigns to vote and have your say or create your own campaign suggestion.</p>
<p>Click <a href="login.html">here</a> to create a new account</p>

<?php
$query = sprintf("SELECT * FROM OS_SfCs");

// Perform Query
$result = mysql_query($query);

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
while ($row = mysql_fetch_assoc($result)) {
    $name = $row['Name'];
    $ID = $row['ID'];

echo "<tr><td style='width: 200px;'><a href='sfc.php?id=".$ID."'>".$name."</a></td></tr>";
}

echo"</table>";
    
// Free the resources associated with the result set
// This is done automatically at the end of the script
mysql_free_result($result);
mysql_close($link);
?>

<?include('footer.php');
