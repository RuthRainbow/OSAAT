<?php

include("common.php");

$sfcID = $_POST['sfcID'];

if(!isset($login['id'])) {
      header('HTTP/1.1 401 Unauthorized', true, 401);
} else {
       $mysqli->query("INSERT INTO " .$mysql_prefix. "UsersVotes(UserID, SfCID) VALUES (
		'".$mysqli->real_escape_string($login['id'])."',
		'".$mysqli->real_escape_string($sfcID)."')");
}

?>