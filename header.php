<?php
include('common.php');
?>
<!DOCTYPE html>
<html>
	<head>
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
					<li><a href="myprojects.php">My Projects</a></li>
<?}?>
					<li><a href="sfc.php">Projects</a></li>
					<li><a href="sfc.php">categories</a></li>
					<li><a href="sfc.php">locations</a></li>
					<li><a href="sfc.php">people</a></li>
					<li><a href="sfc.php">organisations</a></li>
				</ul>
			</div>
			<div id="content">
