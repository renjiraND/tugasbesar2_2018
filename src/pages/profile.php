<!DOCTYPE html>
<html>
<head>
	<title>Pro Book</title>
	<link rel="stylesheet" type="text/css" href="../css/app.css">
	<link rel="stylesheet" type="text/css" href="../css/home.css">
	<link rel="stylesheet" type="text/css" href="../css/profile.css">
</head>
<body>
	<?php
		require 'header.php';
    require '../php/connect.php';
    $sql2 = "SELECT username from probook.user INNER JOIN probook.token ON username=granted where access_token='" . $_COOKIE['login']. "'" ;
    $result2 = mysqli_fetch_row(mysqli_query($conn, $sql2));
    $username = $result2[0];
		$sql = "SELECT name, email, address, phone, picture  from probook.user where username='" . $username. "'" ;
		$result = mysqli_fetch_row(mysqli_query($conn, $sql));
		$name = $result[0];
		$email = $result[1];
		$address = $result[2];
		$phone = $result[3];
		$picture = $result[4];
	?>

  <div class="bg-color-navy-blue">
    <div class="flex row">
      <div class="one-third"></div>
      <div class="one-third flex center-horizontal">
        <img class="profile-picture margin-top-medium" src="<?php echo $picture?>">
      </div>
      <div class="one-third flex align-right">
				<a href="edit-profile.php" class="edit-button margin-top-medium margin-right-medium">
					<img class="edit-button" src="../res/misc/pencil.png">
				</a>
      </div>
    </div>
    <div class="flex center-horizontal text-color-white text-size-large margin-top-medium">
      <div class="margin-bot-medium font-default">
        <?php echo $name?>
      </div>
    </div>
  </div>

  <div class="margin-top-large margin-left-large margin-right-large">
    <div class="text-size-large wrap-text text-color-orange text-bold margin-left-large font-default">
      My Profile
    </div>

    <div class="flex row text-size-small text-color-black margin-top-medium margin-left-large">
      <div class="one-five flex align-right margin-right-medium">
        <img class="mini-icon" src="../res/misc/user.png">
      </div>
      <div class="flex one-five text-size-small center-vertical font-default"> Username </div>
      <div class="flex three-five text-size-small vertical margin-left-medium wrap-text font-default"> <?php echo $username?> </div>
    </div>

    <div class="flex row text-size-small text-color-black margin-top-medium margin-left-large">
      <div class="one-five flex align-right margin-right-medium">
        <img class="mini-icon" src="../res/misc/email.png">
      </div>
      <div class="flex one-five text-size-small center-vertical font-default"> Email </div>
      <div class="flex three-five text-size-small vertical margin-left-medium wrap-text font-default"> <?php echo $email?> </div>
    </div>

    <div class="flex row text-size-small text-color-black margin-top-medium margin-left-large">
      <div class="one-five flex align-right margin-right-medium">
        <img class="mini-icon" src="../res/misc/placeholder.png">
      </div>
      <div class="flex one-five text-size-small center-vertical font-default"> Address </div>
      <div class="flex three-five text-size-small vertical margin-left-medium wrap-text font-default"> <?php echo $address?></div>
    </div>

    <div class="flex row text-size-small text-color-black margin-top-medium margin-left-large">
      <div class="one-five flex align-right margin-right-medium">
        <img class="mini-icon" src="../res/misc/smartphone.png">
      </div>
      <div class="flex one-five text-size-small center-vertical font-default"> Phone Number </div>
      <div class="flex three-five text-size-small vertical margin-left-medium wrap-text font-default"> <?php echo $phone?> </div>
    </div>
  </div>
</body>
<footer>
</footer>
</html>
<script type="text/javascript" src="../js/profile.js"></script>
