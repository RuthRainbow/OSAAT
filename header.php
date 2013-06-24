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
				<span id="main-title">OSAAT</span>
				<span id="sub-title"><?echo($pagename)?></span>
			</div>
			<div id="headerlogin">
				<div id="login-box">
				      <?include('login.php')?>
				</div>
			</div>
			<div id="links">
				<a href="faq.php">faq</a><a href="about.php">about</a><a href="contact.php">contact us</a>
			</div>
		</div>
		<div id="wrapper">
			<div id="colmid">
				<div id="colleft">
					<div id="contentwrap">
						<div id="content">
