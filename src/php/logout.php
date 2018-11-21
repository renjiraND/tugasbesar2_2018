<?php
	setcookie("login", "", time()-3600, "/");
	header("Location: ../pages/login.php");
	die();
?>