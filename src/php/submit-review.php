<?php
  require 'connect.php';

  $stars = $_POST['stars'];
  $review = $_POST['comment'];
  $idorder = $_POST['idorder'];

  $sql = "UPDATE `probook`.`order`
          SET
          `rating` = $stars,
          `review` = '$review'
          WHERE (`idorder` = '$idorder')";

  if (mysqli_query($conn, $sql)) {
    header( "Location: ../pages/history.php" ); die;
  } else {
    header( "Location: ../pages/review.php?idorder=$idorder" ); die;
  }
 ?>
