<!DOCTYPE html>
<html>
<head>
	<title>Pro Book</title>
	<link rel="stylesheet" type="text/css" href="../css/app.css">
	<link rel="stylesheet" type="text/css" href="../css/home.css">
	<link rel="stylesheet" type="text/css" href="../css/browse.css">
</head>
<body>

	<div id="notification" class="notification hided">
		<div class="flex center full-height">
			<div class="bg-color-white one-third corner-small opacity-full">
				<div class="flex align-right margin-small">
					<img class="cancel-img" src="../res/misc/close.png" onclick="closeNotification()">
				</div>
				<div class="margin-left-large flex row text-color-black">
					<img class="check-img margin-right-medium" src="../res/misc/check.png">
					<div>
						<div class="text-bold text-size-very-small font-default">
							Pemesanan Berhasil!
						</div>
						<div>
							<span class="font-default">Nomor Transaksi : </span>
							<span id="transaction_id">3</span>
						</div>
					</div>
				</div>
				<div class="add-height"></div>
			</div>
		</div>
	</div>

	<div id="backdrop" class="backdrop hided"></div>

	<div>
		<?php require 'header.php';?>
		<?php
			require '../php/connect.php';
			$id_book = $_GET['id_book'];
			//$id_book = 'xsRGDwAAQBAJ';

			// $sql = "SELECT * FROM probook.book WHERE probook.book.idbook = " . $id_book;
			// $result = $conn->query($sql);
			// $book = array();
			// while ($row = $result->fetch_assoc()) {
			// 	$book['id'] = $row['idbook'];
			// 	$book['title'] = $row['bookname'];
			// 	$book['author'] = $row['author'];
			// 	$book['description'] = $row['description'];
			// 	$book['img'] = $row['image'];
			// 	$book['rating'] = $_GET['rating'];
			// }

			// $sql = "SELECT probook.`order`.buyer AS username, probook.`order`.rating AS rating, probook.`order`.review AS review, probook.`user`.picture AS img FROM probook.`order` INNER JOIN probook.`user` ON probook.`order`.buyer = probook.`user`.username WHERE probook.`order`.rating is not null AND probook.`order`.book = " . 1;
			// //print_r($sql);
			// $result = $conn->query($sql);
			// $list_review = array();
			// while ($row = $result->fetch_assoc()) {
			// 	array_push($list_review, $row);
			// }

			$client = new SoapClient("http://localhost:9000/BookService?wsdl");
			$responseDetail = $client->getBook(array("arg0" => $id_book));
			/* Print webservice response */
			$title = $responseDetail->return->categories;
			//print_r($title);
			//var_dump($title);

			$book['id'] = $responseDetail->return->id;
			$book['title'] = $responseDetail->return->title;
			$book['author'] = $responseDetail->return->authors;
			$book['description'] = $responseDetail->return->description;
			$book['img'] = $responseDetail->return->imageLinks;
			$book['price'] = $responseDetail->return->price;
			$book['categories'] = $responseDetail->return->categories;
			$book['rating'] = $_GET['rating'];



			// $responseReccomendation = $client->getRecommendation(array("arg0" => $book['categories']));
			// $recBookId = $responseReccomendation->return;

			// $responseRecBook = $client->getBook(array("arg0" => $recBookId));

			// $recBook = array();
			// $recBook['id'] = $responseReccomendation->return->id;
			// $recBook['title'] = $responseReccomendation->return->title;
			// $recBook['author'] = $responseReccomendation->return->authors;
			// $recBook['description'] = $responseReccomendation->return->description;
			// $recBook['img'] = $responseReccomendation->return->imageLinks;
			// $recBook['price'] = $responseReccomendation->return->price;
			// $recBook['categories'] = $responseReccomendation->return->categories;
			// $book['rating'] = $_GET['rating'];

			//var_dump($client->__getFunctions());
			//var_dump($client->__getTypes());
			 $conn->close();
		?>

		<div class="flex center">
			<div class="container-small">
				<div class="flex space-beetween">
					<div>
						<div class="text-color-orange text-size-large text-bold font-default"><?php echo $book["title"];?></div>
						<div class="text-color-grey text-bold text-size-very-small font-default"><?php echo $book["author"];?></div>
						<div class="tet-color-grey text-size-very-small margin-top-small font-default"><?php echo $book["description"];?></div>
					</div>
					<div class="margin-left-large">
						<div class="flex center">
							<img class="book-result-img margin font-default" src=<?php echo "\"" . $book["img"] . "\"";?>>
						</div>
						<div class="text-color-grey text-bold text-size-small margin-top-small font-default"><?php echo "Rp" . $book["price"];?></div>
						<div class="flex row margin-top-small">
							<?php
								$rating = $book['rating'];
								$star = (int) $rating;
								$star_filled = "../res/misc/star.png";
								$star_unfilled = "../res/misc/star_no_fill.png";
								$star_array = array($star_unfilled, $star_unfilled, $star_unfilled, $star_unfilled, $star_unfilled);
								for ($x = 0; $x < $star; $x++) {
									$star_array[$x] = $star_filled;
								}
								foreach ($star_array as $val) {
									echo "<img class=\"star-icon\" src=\"$val\">";
								}
							?>
						</div>
						<div class="flex center">
							<div class="text-color-black text-bold margin-top-small font-default">
								<?php
									echo number_format($rating,1) . "/5.0";
								?>
							</div>
						</div>
					</div>
				</div>

				<div class="margin-top-large">
					<div class="margin-top-medium text-size-medium text-color-navy-blue text-bold font-default">Order</div>
					<form method="POST" class="margin-top-small">
						<span class="margin-right-small text-size-very-small font-default">
							Jumlah:
						</span>
						<select id="amount">
							<option value="unordered">-</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
						</select>
						<div class="flex align-right">
							<?php
								require '../php/connect.php';
							  $sql2 = "SELECT username from probook.user INNER JOIN probook.token ON username=granted where access_token='" . $_COOKIE['login']. "'" ;
								$result2 = mysqli_fetch_row(mysqli_query($conn, $sql2));
								$username = $result2[0];
							?>
							<input class="text-color-white border-radius bg-color-light-blue btn-order font-default" type="button" name="btn-order" value="Order" onclick="order(amount.value, <?php echo "'" . $username . "'";?>, <?php echo $_GET['id_book'];?>)">
						</div>
					</form>
				</div>


				<div class="margin-top-large">
					<div class="margin-top-medium margin-bottom-medium text-size-medium text-color-navy-blue text-bold font-default">Reviews</div>
					<?php
                        foreach ($list_review as $review) {
							echo "<div class=\"flex space-beetween margin-bot-medium\">
								<div class=\"flex row\">
									<img class=\"review-img margin-right-small\" src=\"" . $review["img"] . "\">
									<div>
										<div class=\"text-bold text-size-small text-color-grey font-default\">@" . $review["username"] . "</div>
										<div class=\"text-color-grey text-size-very-small font-default\">" . $review["review"] . "</div>
									</div>
								</div>
								<div class=\"margin-left-small\">
									<div class=\"flex center-horizontal\">
										<img class=\"star-icon-review\" src=\"../res/misc/star.png\">
									</div>
									<div class=\"flex center-horizontal text-size-very-small text-bold text-color-grey font-default\">" . number_format($review["rating"],1) . "/5.0</div>
								</div>
							</div>";
						}
					?>
				</div>


				<div class="margin-top-large">
					<div class="margin-top-medium margin-bottom-medium text-size-medium text-color-navy-blue text-bold font-default">Recommendation</div>
					<?php
					echo "<div class=\"flex space-beetween margin-bot-medium\">
					<div class=\"flex space-beetween row \">
						<img class=\"book-result-img\" src=\"" . $book['img'] . "\">
						<div class=\"margin-left-small font-default flex column\">
							<div class=\"text-color-orange text-bold text-size-medium\">" . $book["title"] ."</div>
							<div class=\"text-color-grey text-bold text-size-very-small\">" . $book["author"] . " - " . number_format($book["rate"],1) . "/5.0 (" . $book["votes"] . " votes)</div>
							<div class=\"text-color-grey text-bold text-size-small font-default\">" . 'Rp' . $book["price"] . "</div>
							<div class=\"flex column full-height align-right align-bottom\">
								<form method=\"GET\" action=\"browse-detail.php\">
									<div class>
										<input type=\"hidden\" name=\"id_book\" value=\"" . $book["id"] . "\">
										<input type=\"hidden\" name=\"rating\" value=\"" . $book["rate"] . "\">
										<input class=\"text-color-white border-radius bg-color-light-blue margin-top-small font-default btn-detail\" type=\"submit\" value=\"See More!\" id_book=\"" . $book['id'] . "\" value=\"Detail\">
									</div>
								</form>
							</div>
						</div>
					</div>
					";
				?>
				</div>


			</div>
		</div>
	</div>

</body>
<footer></footer>
</html>
<script type="text/javascript" src="../js/browse.js"></script>
