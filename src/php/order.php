<?php
	// Create the SoapClient instance
    $url        = "http://localhost:9000/BookService?wsdl";
    $client     = new SoapClient($url);

    $params = array("arg0" => "0uJqQNKhxWAC", "arg1" =>  "1", "arg2" => array("test","set"));
    // Call wsdl function
    $soapresp = $client->buyBookByID($params);

	if($soapresp->return){
        $data = json_decode(file_get_contents('php://input'), true);
        $data['date'] = date('Y-m-d');
        require 'connect.php';

        $sql = "INSERT INTO probook.`order` (buyer, book, amount, order_date) VALUES (\"" . $data['username'] . "\", " . $data['idbook'] . ", " . $data['amount'] . ", \"" . $data['date'] . "\")";
        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
            $result = array("id_order"=>$last_id,"status"=>$soapresp->return);
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
        echo json_encode($result);
	}else{
	    $error = array("id_order" => -1, "status" => $soapresp->return)
	    echo ;
	}

?>
 