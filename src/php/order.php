<?php
    $data = json_decode(file_get_contents('php://input'), true);
	// Create the SoapClient instance
    $url        = "http://localhost:9000/BookService?wsdl";
    $client     = new SoapClient($url);

    $params = array("arg0" => $data['idbook'],
                    "arg1" =>  $data['card_number'],
                    "arg2" => $data['categories'],
                    "arg3" => $data['amount']
                    );
    // Call wsdl function
    $soapresp = $client->buyBookByID($params);

	if($soapresp->return){
        $data = json_decode(file_get_contents('php://input'), true);
        $data['date'] = date('Y-m-d');
        require 'connect.php';

        $sql = "INSERT INTO probook.`order` (buyer, book, amount, order_date) VALUES ('" . $data['username'] . "', '" . $data['idbook'] . "', '" . $data['amount'] . "', '" . $data['date'] . "')";
        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
            $result = array("id_order"=>$last_id, "status"=>$soapresp->return);
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
            $result = array("message" => $message);
        }
        $conn->close();
        echo json_encode($result);
	}else{
	    $error = array("id_order" => -1, "status" => $soapresp->return);
	    echo $error;
	}

?>
 