<?php
include("common.php");
 
$orgID = $_POST['orgID'];

if(!isset($login['id'])) {
      header('HTTP/1.1 401 Unauthorized', true, 401);
} else {
       $mysqli->query("INSERT INTO " .$mysql_prefix. "UserOrgs(UserID, orgID) VALUES (
                '".$mysqli->real_escape_string($login['id'])."',
                '".$mysqli->real_escape_string($sfcID)."')");
}

?>       
