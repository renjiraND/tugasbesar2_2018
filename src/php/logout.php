<?php
	require 'connect.php';
	$login = $_COOKIE['login'];
	$sql = "DELETE FROM probook.token WHERE access_token = '$login'";
	$conn->query($sql);
	setcookie("login", "", time()-3600, "/");
	header("Location: ../pages/login.php");
	die();
?>
