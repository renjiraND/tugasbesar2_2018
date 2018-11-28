<?php
	function get_client_ip_server() {
	$ipaddress = '';
	if (@$_SERVER['HTTP_CLIENT_IP'])
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if(@$_SERVER['HTTP_X_FORWARDED_FOR'])
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if(@$_SERVER['HTTP_X_FORWARDED'])
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if(@$_SERVER['HTTP_FORWARDED_FOR'])
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if(@$_SERVER['HTTP_FORWARDED'])
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if(@$_SERVER['REMOTE_ADDR'])
			$ipaddress = $_SERVER['REMOTE_ADDR'];
	else
			$ipaddress = 'UNKNOWN';

	return $ipaddress;
	}
	if (!isset($_COOKIE['login'])) {
		header("Location: login.php");
		die();
	} else {
		require '../php/connect.php';
		date_default_timezone_set("Asia/Jakarta");
		$timenow = date('Y-m-d H:i:s',time());
		$browser = $_SERVER['HTTP_USER_AGENT'];
		$ip = get_client_ip_server();

		$sql = "DELETE from probook.token where expiry_time < '" . $timenow . "'";
		$result = mysqli_query($conn, $sql);
		$sql = "SELECT expiry_time from probook.token where access_token = '". $_COOKIE['login'] . "' AND expiry_time > '". $timenow ."' AND browser = '". $browser ."' AND ip = '". $ip ."'";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result)>0) {
      $sql2 = "SELECT username from probook.user INNER JOIN probook.token ON username=granted where access_token='" . $_COOKIE['login']. "'" ;
			$result2 = mysqli_fetch_row(mysqli_query($conn, $sql2));
			$username = $result2[0];
    } else {
      header("Location: login.php");
			die();
    }
	}
?>

<head>
	<link rel="stylesheet" type="text/css" href="../css/home.css">
</head>


<div class="header flex row">
	<div class="bg-color-light-blue header-width full-height flex center-vertical space-beetween">
		<div class="text-bold">
			<span class="text-size-large text-color-dark-yellow margin-left-small font-title-2">Pro</span>
			<span class="text-size-large text-color-white font-title-2">-Book</span>
		</div>
		<span class="text-size-small text-color-white center-vertical margin-right-medium font-default"><u>Hi, <?php echo $username;?>!</u></span>
	</div>
	<div class="bg-color-orange logout-width full-height flex center">
		<a href="../php/logout.php">
			<img class="icon-shut-down" src="../res/misc/shut-down.png">
		</a>
	</div>
</div>
<div class="bg-color-dark-blue text-size-small flex row navigation-height">
	<div id="browse" class="one-third navigation">
		<a href="browse-search.php" class="text-color-white text-no-underline full-height full-width flex center font-default"><span class="text-size-medium text-bold">B</span><span>ROWSE</span></a>
	</div>
	<div id="history" class="one-third bordered navigation">
		<a href="history.php" class="text-color-white text-no-underline full-height full-width flex center font-default"><span class="text-size-medium text-bold">H</span><span>ISTORY</span></a>
	</div>
	<div id="profile" class="one-third navigation">
		<a href="profile.php" class="text-color-white text-no-underline full-height full-width flex center font-default"><span class="text-size-medium text-bold">P</span><span>ROFILE</span></a>
	</div>
</div>
<script type="text/javascript" src="../js/header.js"></script>
