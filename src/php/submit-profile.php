<?php
  require 'connect.php';

  $newname = $_POST['new-name'];
  $newaddress = $_POST['new-address'];
  $newphone = $_POST['new-phone'];
  $sql2 = "SELECT username from probook.user INNER JOIN probook.token ON username=granted where access_token='" . $_COOKIE['login']. "'" ;
  $result2 = mysqli_fetch_row(mysqli_query($conn, $sql2));
  $username = $result2[0];

  $sql = "UPDATE `probook`.`user`
          SET
          `name` = '$newname',
          `address` = '$newaddress',
          `phone` = '$newphone'
          WHERE (`username` = '$username')";

  if (mysqli_query($conn, $sql)) {
    if(isset($_FILES["file-input"]) && $_FILES['file-input']['size'] > 0) {
      $target_dir = "../res/profile_picture/";
      $target_file = $target_dir . basename($_FILES["file-input"]["name"]);
      $renamed_file = $target_dir . $username . ".jpg";
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      // Check if image file is a actual image or fake image
      if(isset($_POST["btn-submit"])) {
          $check = getimagesize($_FILES["file-input"]["tmp_name"]);
          if($check !== false) {
              echo "File is an image - " . $check["mime"] . ".";
              $uploadOk = 1;
          } else {
              echo "File is not an image.";
              $uploadOk = 0;
          }
      }

      // Check if file already exists
      if (file_exists($target_file)) {
          unlink($target_file);
      }

      // Check file size
      if ($_FILES["file-input"]["size"] > 500000) {
          echo "Sorry, your file is too large.";
          $uploadOk = 0;
      }

      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
          echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
          $uploadOk = 0;
      }

      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
          echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
      } else {
          if (move_uploaded_file($_FILES["file-input"]["tmp_name"], $renamed_file)) {
              $sql = "UPDATE `probook`.`user`
                      SET
                      `picture` = '../res/profile_picture/$username.jpg'
                      WHERE (`username` = '$username')";
              mysqli_query($conn, $sql);
              echo "The file ". basename( $_FILES["file-input"]["name"]). " has been uploaded.";
          } else {
              echo "Sorry, there was an error uploading your file.";
          }
      }
    }
    header( "Location: ../pages/profile.php" ); die;
  } else {
    header( "Location: ../pages/edit-profile.php"); die;
  }
?>
