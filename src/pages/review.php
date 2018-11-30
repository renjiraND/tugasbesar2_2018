<!DOCTYPE html>
<html>
<head>
	<title>Pro Book</title>
	<link rel="stylesheet" type="text/css" href="../css/app.css">
	<link rel="stylesheet" type="text/css" href="../css/home.css">
	<link rel="stylesheet" type="text/css" href="../css/review.css">
</head>
<body>

	<?php require 'header.php';?>
	<?php require '../php/connect.php';?>
	<?php
		if (!isset($_POST['idorder']) || !isset($_POST['book']) || !isset($_POST['bookname']) || !isset($_POST['author']) || !isset($_POST['image'])) {
			header( "Location: history.php" ); die;
		}
		$order_id = $_POST['idorder'];
		$sql = "select bookname, author, image from probook.order inner join probook.book on
			(probook.book.idbook=probook.order.book) WHERE probook.order.idorder=" . $order_id;
		$result = array($_POST['bookname'], $_POST['author'], $_POST['image']);
	?>
	<div class="margin-top-large margin-left-large margin-right-large flex row center">
		<div class="two-third">
			<div class="text-size-very-large wrap-text text-color-orange font-default">
			<?php echo $result[0] ?>
			</div>
			<div class="margin-left-small text-size-small wrap-text font-default">
			<?php echo $result[1] ?>
			</div>
		</div>
		<div class="one-third">
				<img class="book-cover" src="<?php echo $result[2]?>">
		</div>
	</div>

	<div class="margin-top-large margin-left-large margin-right-large">
		<div class="text-color-dark-blue text-size-medium font-default">
			Add Rating
		</div>
		<div class="flex center text-size-large">
			<form class="rating" id="review" method="post" action="../php/submit-review.php">
				<input type="hidden" name="idorder" value=<?php echo $_POST['idorder']?>>
				<div>
				  <label>
				    <input type="radio" class="stars-button" name="stars" value="1" />
				    <img class="star" src="../res/misc/star_no_fill.png" id="stars1" onmouseover="activate1Star()" onmouseout="activateCurrentStar()">
				  </label>
				  <label>
				    <input type="radio" class="stars-button" name="stars" value="2" />
						<img class="star" src="../res/misc/star_no_fill.png" id="stars2" onmouseover="activate2Star()" onmouseout="activateCurrentStar()">

				  </label>
				  <label>
				    <input type="radio" class="stars-button" name="stars" value="3" />
						<img class="star" src="../res/misc/star_no_fill.png" id="stars3" onmouseover="activate3Star()" onmouseout="activateCurrentStar()">
				  </label>
				  <label>
				    <input type="radio" class="stars-button" name="stars" value="4" />
							<img class="star" src="../res/misc/star_no_fill.png" id="stars4" onmouseover="activate4Star()" onmouseout="activateCurrentStar()">
					  </label>
				  <label>
				    <input type="radio" class="stars-button" name="stars" value="5" />
						<img class="star" src="../res/misc/star_no_fill.png" id="stars5" onmouseover="activate5Star()" onmouseout="activateCurrentStar()">
				  </label>
				</div>
			</form>
		</div>
	</div>

	<div class="margin-top-large margin-left-large margin-right-large">
		<div class="text-color-dark-blue text-size-medium font-default">
			Add Comment
		</div>
		<div class="flex center">
			<textarea id="comment" name="comment" class="review-textarea font-field" form="review" placeholder="Enter Comment"></textarea>
		</div>
		<div class="flex center">
				<div class="four-five margin-top-small">
					<div class="float-left">
						<input class="white-button font-default" type="button" name="back-search" value="Back" onclick="window.location.href='http://localhost/src/pages/review.php'">
					</div>
					<div class="float-right">
						<input class="blue-button font-default" type="submit" form="review" name="btn-search" value="Submit">
					</div>
				</div>
		</div>
	</div>

</body>
<footer></footer>
</html>
<script type="text/javascript" src="../js/review.js"></script>
<script type="text/javascript">addValidation()</script>
