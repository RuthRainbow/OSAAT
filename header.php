<?php
include('common.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<title>OSAAT</title>
<link rel="StyleSheet" type="text/css" href="./style.css"/>
	</head>
	<body>
		<div id="header">
			<div id="title">
				<h1>OSAAT</h1><h2><?echo($pagename)?></h2>
			</div>
		<div id="links">
				<a href="faq.html">faq</a><a href="faq.html">about</a><a href="faq.html">contact us</a>
			</div>
		
		</div>
		<div id="wrapper">
			<div id="left-bar">
				<ul id="nav">
					<li><a href="index.php">Home</a></li>
<?if(isset($login['id'])){?>
					<li><a href="add_campaign.php">Add Campaign</a></li>
					<li><a href="mycampaigns.php">My Campaigns</a></li>
<?}?>
					<li><a href="sfc.php">Campaigns</a></li>
					<li><a href="sfc.php">Categories</a></li>
					<li><a href="sfc.php">Locations</a></li>
					<li><a href="sfc.php">People</a></li>
					<li><a href="sfc.php">Organisations</a></li>
				</ul>
			</div>
			<div id="content">
