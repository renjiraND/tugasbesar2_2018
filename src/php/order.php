<?php

	$data = json_decode(file_get_contents('php://input'), true);
	$data['date'] = date('Y-m-d');
	require 'connect.php';

	$sql = "INSERT INTO probook.`order` (buyer, book, amount, order_date) VALUES (\"" . $data['username'] . "\", " . $data['idbook'] . ", " . $data['amount'] . ", \"" . $data['date'] . "\")";
	if ($conn->query($sql) === TRUE) {
	    $last_id = $conn->insert_id;
	    $result = array("id_order"=>$last_id);
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
	echo json_encode($result);
?>
 