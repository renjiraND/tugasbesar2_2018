<!-- DEPRECATED ?
<!DOCTYPE html>
<html>
<head>
	<title>Pro Book</title>
	<link rel="stylesheet" type="text/css" href="../css/app.css">
	<link rel="stylesheet" type="text/css" href="../css/browse.css">
</head>
<body>

	<?#php require 'header.php';?>

	<div class="padding-large">
		<div class="text-color-orange text-bold text-size-very-large font-default">Search Book</div>
		<div class="margin-top-large">
			<form id="form-search" method="GET" action="browse-result.php">
				<input id="search-value" class="input-search padding-left-small border-radius font-default" type="text" name="search" placeholder="Input search terms...">
				<div class="flex align-right">
					<input id="btn-search" class="text-color-white border-radius bg-color-light-blue margin-top-medium btn-search font-default" type="submit" value="Search">
				</div>
			</form>
		</div>
	</div>

</body>
<footer></footer>
</html>
<script type="text/javascript" src="../js/browse.js"></script>
<script type="text/javascript">addValidationToSearchBox();</script>
