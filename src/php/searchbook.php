<?php
   $q = strval($_REQUEST["searchvalue"]);
   $client = new SoapClient("http://localhost:9000/BookService?wsdl");
   //$response = $client->__soapCall("getBook",array('id' => "xsRGDwAAQBAJ"));
   $response = $client->searchbook(array("arg0" => $q));
   /* Print webservice response */
   //$title = $response->return->title;
   //print_r($response->return[0]);
   //var_dump($client->__getFunctions());
   //var_dump($client->__getTypes());
   //print_r($response->return[0]);
   echo json_encode($response->return)
 ?>
