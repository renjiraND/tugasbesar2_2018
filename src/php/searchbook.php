<?php
   $q = strval($_REQUEST["searchvalue"]);
   $q = str_replace(' ', '%20', $q);
   //echo $q;
   require '../php/connect.php';
   $client = new SoapClient("http://localhost:9000/BookService?wsdl");
   //$response = $client->__soapCall("getBook",array('id' => "xsRGDwAAQBAJ"));
   $response = $client->searchbook(array("arg0" => $q));
   /* Print webservice response */
   //$title = $response->return->title;
   //print_r($response->return[0]);
   //var_dump($client->__getFunctions());
   //var_dump($client->__getTypes());
   //print_r($response->return[0]);
   //print_r((array)$response);

   if (empty((array)$response)) {
     echo null;
   } else {
     $x = $response->return;

     foreach ($x as $book) {
       $sql = "SELECT AVG(rating) AS rating, COUNT(*) AS votes from `order`
       WHERE book='$book->id' GROUP BY book";
       $result = mysqli_query($conn, $sql);
       if (mysqli_num_rows($result) > 0) {
         $result = mysqli_fetch_row($result);
         $book->rating = number_format($result[0], 1);
         $book->votes = $result[1];
       } else {
         $book->rating = number_format(0, 1);
         $book->votes = 0;
       }

       if ($book->imageLinks=="default") {
         $book->imageLinks = "../res/book_cover/default.jpg";
       }
     }

     //print_r($x);
     echo json_encode($x);
   }
 ?>
