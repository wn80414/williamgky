<?php
  //URL, Where the JSON data is going to be sent
  // sending get request to reqres.in
  $url = "localhost/userlist.php";

  //initialize CURL
  $ch = curl_init();

  //next we have to set options so below is the options for the curl 
  $array_options = array(
    
    // $url is the variable we want to fetch using CURLOPT_URL
    CURLOPT_URL=>$url,

    //setting curl option RETURNTRANSFER to true so 
    //that it returns the response
    //instead of outputting it 
    CURLOPT_RETURNTRANSFER=>true,
  );

  //setting multiple options using curl_setopt_array
  curl_setopt_array($ch,$array_options);

  // using curl_exec() is used to execute the POST request
  $resp = curl_exec($ch);

  // decode the response 
  $final_decoded_data = json_decode($resp,true);
    print_r($final_decoded_data['result']);

  //close the cURL and load the page
  curl_close($ch);
?>