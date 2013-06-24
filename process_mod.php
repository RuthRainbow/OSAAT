<?php 
include("common.php");
 
$sfcID = $_POST['sfcID'];
  
if(!isset($login['id'])) {
        header('HTTP/1.1 401 Unauthorized', true, 401);
} else {
        if(!$mysqli->query('INSERT INTO ' .$mysql_prefix. 'SfCMods(UserID, SfCID) VALUES (
                "'.$mysqli->real_escape_string($login['id']).'",
                "'.$mysqli->real_escape_string($sfcID).'")'))        
	{
		header('HTTP/1.1 409 Conflict', true, 409);
        }
}
?>

