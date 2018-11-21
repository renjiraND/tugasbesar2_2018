<?php
	function generateToken($length)
  {
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $nchars = strlen($chars)-1;
    $token = '';
    for ($i = 0; $i < $length; $i++) {
        $token .= $chars[rand(0, $nchars)];
    }
    return $token;
  }
  function tokenAlreadyUsed($token)
  {
    require '../php/connect.php';
    $sql = "SELECT `access_token` FROM `probook`.`token` WHERE access_token='$token'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result)>0) {
      return true;
    } else {
      return false;
    }
  }
  function addTokenToDB($token,$user)
  {
    require '../php/connect.php';
    $exptime = date('Y-m-d H:i:s',(time()+43200));
    $sql = "INSERT INTO probook.token(access_token, granted, expiry_time) VALUES ('$token','$user','$exptime')";
    if ($conn->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
      header("Location: ../pages/login.php");
      die;
    }
    $conn->close();
  }

	$name = $_POST["input-name"];
	$user = $_POST["input-username"];
	$email = $_POST["input-email"];
	$pass = $_POST["input-password"];
	$address = $_POST["input-address"];
	$phone = $_POST["input-phone-number"];

	require 'connect.php';

	$sql = "INSERT INTO probook.user(username, name, email, password, address, phone, picture) VALUES ('$user','$name','$email','$pass','$address','$phone','../res/profile_picture/default.jpg')";

	if ($conn->query($sql) === TRUE) {
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
		header("Location: ../pages/login.php");
		die;
	}
	$conn->close();

	$token = generateToken(10);
  while (tokenAlreadyUsed($token)) {
    $token = generateToken(10);
  }
  addTokenToDB($token,$user);
  setcookie("login",$token,time()+86400, "/");
  header("Location: ../pages/browse-search.php");
  die;
?>
