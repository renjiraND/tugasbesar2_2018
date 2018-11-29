<!DOCTYPE html>
<html>
<head>
	<title>Pro Book</title>
	<link rel="stylesheet" type="text/css" href="../css/app.css">
	<link rel="stylesheet" type="text/css" href="../css/home.css">
	<link rel="stylesheet" type="text/css" href="../css/browse.css">
</head>
<body>

	<?php
		require '../php/connect.php';
		$search_val = $_GET['search'];

		$sql = "SELECT * FROM probook.book WHERE(probook.book.bookname LIKE '%" . $search_val . "%')";
		$result = $conn->query($sql);
		$list_book = array();
	    while($row = $result->fetch_assoc()) {
	    	$item = array("id"=>$row["idbook"],
	    					"title"=>$row["bookname"],
	    					"author"=>$row["author"],
	    					"description"=>$row["description"],
	    					"img"=>$row["image"]);
	    	$sql_rating = "SELECT * FROM `order` WHERE `order`.rating is not null AND `order`.book = " . $item['id'];
	    	$result_rating = $conn->query($sql_rating);
	    	$votes = 0;
	    	$rate = 0;
	    	while ($row_rating = $result_rating->fetch_assoc()) {
	    		$votes = $votes + 1;
	    		$rate = $rate + $row_rating["rating"];
	    	}
	    	if ($votes != 0) {
	    		$rate = $rate/$votes;
	    	}
	    	$item["votes"] = $votes;
	    	$item["rate"] = $rate;
	        array_push($list_book, $item);
	    }
	    $conn->close();
	?>

	<div class="padding-large">
		<div class="flex row">
			<div class="two-third">
				<div class="text-color-orange text-bold text-size-large font-default">Result</div>
			</div>
			<div class="one-third flex align-right align-bottom">
				<div class="text-color-grey text-size-small font-default">Found <u><strong><?php echo sizeof($list_book);?></strong></u> result(s)</div>
			</div>
		</div>

	 	<?php
			foreach ($list_book as $book) {
				echo "<div class=\"margin-bottom-medium\">
					<div class=\"flex row margin-top-large\">
						<img class=\"book-result-img\" src=\"" . $book['img'] . "\">
						<div class=\"margin-left-small font-default\">
							<div class=\"text-color-orange text-bold text-size-medium\">" . $book["title"] ."</div>
							<div class=\"text-color-grey text-bold text-size-very-small\">" . $book["author"] . " - " . number_format($book["rate"],1) . "/5.0 (" . $book["votes"] . " votes)</div>
							<div class=\"text-color-grey text text-size-very-small\">" . $book["description"] . "</div>
						</div>
					</div>
					<div>
						<form method=\"GET\" action=\"browse-detail.php\">
							<div class=\"flex align-right\">
								<input type=\"hidden\" name=\"id_book\" value=\"" . $book["id"] . "\">
								<input type=\"hidden\" name=\"rating\" value=\"" . $book["rate"] . "\">
								<input class=\"text-color-white border-radius bg-color-light-blue margin-top-small font-default btn-detail\" type=\"submit\" value=\"Detail\" id_book=\"" . $book['id'] . "\" value=\"Detail\">
							</div>
						</form>
					</div>
				</div>";
			}
		?>
	</div>

</body>
<footer></footer>
</html>
<script type="text/javascript" src="../js/browse.js"></script>
