<!DOCTYPE html>
<html>
<head>
	<title>Pro Book</title>
	<link rel="stylesheet" type="text/css" href="../css/app.css">
	<link rel="stylesheet" type="text/css" href="../css/home.css">
	<link rel="stylesheet" type="text/css" href="../css/edit-profile.css">
	<script type="text/javascript" src="../js/validate.js"></script>
</head>
<body>
	<?php require 'header.php';
		require '../php/connect.php';
    $sql2 = "SELECT username from probook.user INNER JOIN probook.token ON username=granted where access_token='" . $_COOKIE['login']. "'" ;
    $result2 = mysqli_fetch_row(mysqli_query($conn, $sql2));
    $username = $result2[0];
		$sql = "SELECT name, address, phone, picture from probook.user where username='" . $username. "'" ;
		$result = mysqli_fetch_row(mysqli_query($conn, $sql));
		$name = $result[0];
		$address = $result[1];
		$phone = $result[2];
		$picture = $result[3];
	?>

  <div class="text-size-very-large text-bold margin-left-medium text-color-orange font-default">
    Edit Profile
  </div>
  <div class="flex row">
    <div class="flex one-third align-right margin">
      <div class="flex row half">
        <img class="profile-picture one-five" id="display-profile-picture" src='<?php echo $picture?>'>
      </div>
    </div>
    <div class="flex row center-vertical two-third">
      <div class="flex row two-third flex-wrap">
        <div class="flex full-width text-size-small font-default">
          Update profile picture
        </div>
        <form id="new-profile" name="new-profile" class="flex row full-width flex-wrap" enctype="multipart/form-data" method="post" action="../php/submit-profile.php" onsubmit="return validateEdit()">
					<div class="flex nine-ten flex-wrap">
            <input class="full-width picture-input padding-left-small font-field" type="text"
							id="profile-picture-name" value="">
          </div>
          <div class="flex one-ten full-height flex-wrap">
						<input class="file-input font-field" type="file" id="file-input" name="file-input">
            <input class="bg-color-lightgray profile-btn font-default" type="button" name="btn-profil-picture" value="Browse.." onclick="document.getElementById('file-input').click();">
					</div>
        </form>
      </div>
    </div>
  </div>

  <div class="flex row margin-top-large center-vertical">
    <div class="flex row one-third center text-size-small">
      <div class="flex half"></div>
      <div class="flex half font-default">
          Name
      </div>
    </div>
    <div class="flex two-third">
      <div class="flex two-third flex-wrap">
      <input form="new-profile" class="other-input padding-left-small full-width font-field" type="text" name="new-name" value='<?php echo $name?>'>
      </div>
    </div>
  </div>

  <div class="flex row margin-top-large center-vertical">
    <div class="flex row one-third center text-size-small">
      <div class="flex half"></div>
      <div class="flex half font-default">
          Address
      </div>
    </div>
    <div class="flex two-third">
      <div class="flex two-third flex-wrap">
      <textarea form="new-profile" class="address-input padding-left-small padding-top-small full-width font-field" name="new-address"><?php echo $address?></textarea>
      </div>
    </div>
  </div>

  <div class="flex row margin-top-large center-vertical">
    <div class="flex row one-third center text-size-small">
      <div class="flex half"></div>
      <div class="flex half font-default">
          Phone number
      </div>
    </div>
    <div class="flex two-third">
      <div class="flex two-third flex-wrap">
      <input form="new-profile" class="other-input padding-left-small full-width font-field" type="text" name="new-phone" value='<?php echo $phone?>'>
      </div>
    </div>
  </div>

  <div class="flex row margin-top-large ">
    <div class="flex one-third">
      <div class="flex half"></div>
      <div class="flex half">
        <input class="white-button font-default" type="button" name="btn-back" value="Back" onclick="window.location.href='profile.php'">
      </div>
    </div>
    <div class="flex row two-third">
      <div class="flex row two-third align-right">
        <input class="blue-button font-default" type="submit" name="btn-submit" value="Submit" form="new-profile">
      </div>
    </div>
  </div>

</body>
<footer>
</footer>
</html>
<script type="text/javascript" src="../js/profile.js"></script>
<script type="text/javascript">addOnChangeProfilePictureName();</script>
