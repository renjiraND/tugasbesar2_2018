<?php
	$q = strval($_REQUEST["q"]);
	require 'connect.php';
	$sql = "SELECT email FROM probook.user WHERE email = '$q'";
	$result = $conn->query($sql);
	if (mysqli_num_rows($result) > 0 ) {
		echo "0";
	} else {
		echo "1";
	}
?>