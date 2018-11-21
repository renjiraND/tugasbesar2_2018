<!DOCTYPE html>
<html>
<head>
	<title>Pro Book</title>
	<link rel="stylesheet" type="text/css" href="../css/app.css">
	<link rel="stylesheet" type="text/css" href="../css/home.css">
	<link rel="stylesheet" type="text/css" href="../css/history.css">
</head>
<body>

	<?php require 'header.php';?>
	<?php require '../php/connect.php';?>
  <div class="margin-top-large margin-left-large margin-right-large">
    <div class="text-size-very-large wrap-text text-color-orange text-bold font-default">
      History
    </div>
    <div>
    	<?php
				require '../php/connect.php';
			  $sql2 = "SELECT username from probook.user INNER JOIN probook.token ON username=granted where access_token='" . $_COOKIE['login']. "'" ;
				$result2 = mysqli_fetch_row(mysqli_query($conn, $sql2));
				$username = $result2[0];
			?>
      <?php
				$que1 = "SELECT idorder, amount, bookname, image, order_date, rating, review from probook.`order` inner join probook.`book` on probook.`order`.book = probook.`book`.idbook WHERE buyer = '" . $username . "' AND rating is null ORDER BY idorder DESC";
				$que2 = "SELECT idorder, amount, bookname, image, order_date, rating, review from probook.`order` inner join probook.`book` on probook.`order`.book = probook.`book`.idbook WHERE buyer = '" . $username . "' AND rating is not null ORDER BY idorder DESC";
				$sql_arr = array($que1, $que2);
				$isEmpty = true;
				foreach ($sql_arr as $sql) {
					$result = mysqli_query($conn, $sql);
					if (mysqli_num_rows($result)>0) {
						$isEmpty=false;
		        foreach ($result as $order) {
							$ordertime = strtotime($order["order_date"]);
							$ordertime = date('d', $ordertime) ." " . date('F', $ordertime). " " . date('Y', $ordertime);

		          echo "<div class=\"margin-bottom-medium\">
		            <div class=\"flex row margin-top-large\">
		              <img class=\"book-img\" src=\"" . $order['image'] . "\">
		              <div class=\"margin-left-small full-width\">
		                <div class=\"flex space-beetween\">
		                  <div class=\"text-color-orange text-bold text-size-medium font-default\">" . $order["bookname"] ."</div>
		                  <div class=\"text-color-black text-size-very-small flex center font-default\">" . $ordertime ."</div>
		                </div>
		                <div class=\"flex space-beetween\">
		                  <div class=\"text-color-grey text-size-very-small font-default\"> Amount : " . $order["amount"] . "</div>
		                  <div class=\"text-color-black text-size-very-small flex center font-default\"> Order Number : " . $order["idorder"] ."</div>
		                </div>
		                  <div class=\"text-color-grey text text-size-very-small font-default\">" . ($order["rating"] ? "Sudah direview" : "Belum direview") . "</div>"
		                ."<div class=\"flex align-right\">"
		                . ($order["rating"] ? "" : "<div>
		                    <div class=\"flex\">
		                      <input class=\"blue-button font-default\" type=\"button\" name=\"btn-review\" value=\"Review\"
														onclick=\"window.location.href='review.php?idorder=" . $order["idorder"] . "'\">
		                    </div>")
		              . "</div>
		                </div>
		              </div>
		            </div>";}
						}
					}
				if ($isEmpty) {
					echo "<div class=\"margin-left-small margin-top-small font-default\"> You don't have any book order history </div>";
				}
			?>
    </div>
  </div>


</body>
<footer></footer>
</html>
<script type="text/javascript" src="../js/review.js"></script>
