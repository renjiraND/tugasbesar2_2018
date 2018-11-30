<!DOCTYPE html>
<html>
<head>
  <title>Login Form</title>
	<link rel="stylesheet" type="text/css" href="../css/app.css">
  <link rel="stylesheet" type="text/css" href="../css/login.css">
  <script type="text/javascript" src="../js/validate.js"></script>
</head>
<body>
  <?php
    if (isset($_COOKIE['login'])) {
  		header("Location: search.php");
  		die();
  	}
   ?>
  <div class="flex center">
    <div class="login-box login-bg">
      <div class="flex center-horizontal text-size-very-large font-title text-bold">L O G I N</div>
      <div class="flex center">
        <form class="margin-top-medium margin-bot-medium center-horizontal" onsubmit="return validateLogin()" action="login.php" method="POST" id="credentials" name="login-form">
          <div class="flex row center space-beetween">
            <div class="margin-right-small font-default"> Username </div>
            <input class="input-username flex align-right border-radius font-field" type="text" name="input-username">
          </div>
          <div class="flex row center margin-top-small space-beetween">
            <div class="margin-right-small font-default"> Password </div>
            <input class="input-password flex align-right border-radius font-field" type="password" name="input-password">
          </div>
        </form>
      </div>
      <div class="margin-left-small">
        <a href="register.php" class="text-color-black text-size-very-very-small font-default">Don't have an account?</a>
      </div>
      <div class="flex center margin-top-medium">
          <button class="btn-login text-color-orange bg-color-white text-bold font-default" type="submit" form="credentials">L O G I N</button>
      </div>
    </div>
  </div>
</body>
</html>
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
  function get_client_ip_server() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
  }
  function addTokenToDB($token,$user)
  {
    require '../php/connect.php';
    date_default_timezone_set("Asia/Jakarta");
    $exptime = date('Y-m-d H:i:s',(time()+3600));
    $browser = $_SERVER['HTTP_USER_AGENT'];
    $ip = get_client_ip_server();
    $sql = "INSERT INTO probook.token(access_token, granted, expiry_time, browser, ip) VALUES ('$token','$user','$exptime', '$browser', '$ip')";
    if ($conn->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
      header("Location: ../pages/login.php");
      die;
    }
    $conn->close();
  }
  function userAndPassMatch($user,$pass)
  {
    require '../php/connect.php';
    $sql = "SELECT username FROM `probook`.`user` WHERE username='$user' AND password='$pass'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result)>0) {
      return true;
    } else {
      return false;
    }
  }

  if (isset($_POST["input-username"]) && isset($_POST["input-password"])){
    $user = $_POST["input-username"];
    $pass = $_POST["input-password"];
    if (userAndPassMatch($user,$pass)) {
      $token = generateToken(10);
      while (tokenAlreadyUsed($token)) {
        $token = generateToken(10);
      }
      addTokenToDB($token,$user);
      setcookie("login",$token,time()+86400, "/");
      header("Location: ../pages/search.php");
      die;
    }
    else {
      echo "<script type='text/javascript'>alert('Invalid username and/or password.');</script>";
    }
  }
?>
