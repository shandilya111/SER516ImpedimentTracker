<?php
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');

//The url you wish to send the POST request to
$url = "https://api.taiga.io/api/v1/auth";

//The data you want to send via POST
$fields = [
    'password'      => "Koustubham*111",
    'type' => "normal",
    'username'         => "vkambha3"
];

//url-ify the data for the POST
$fields_string = http_build_query($fields);
//open connection
$ch = curl_init();
//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, true);
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
//So that curl_exec returns the contents of the cURL; rather than echoing it
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
//execute post
$result = curl_exec($ch);
$result = json_decode($result, true); //because of true, it's in an array; 
//echo $result["auth_token"];
$slug = $_GET["by_slug"];
//print_r($slug);
$curl = curl_init();
$authorization = "Authorization: Bearer ".$result["auth_token"];
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.taiga.io/api/v1/projects/by_slug?slug=$slug",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_TIMEOUT => 30,
 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
          "cache-control: no-cache",
           $authorization
  ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
//curl_close($curl);
$response = json_decode($response, true); //because of true, it's in an array; 
//header('Content-Type: application/json; charset=utf-8');
$projectId =  $response["id"];
$newUrl = "https://api.taiga.io/api/v1/issues?project=".$projectId ;
//echo($newUrl);
curl_setopt_array($curl, array(
  CURLOPT_URL => $newUrl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
          "cache-control: no-cache",
           $authorization
  ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
//header('Content-Type: application/json; charset=utf-8');
//$response = json_decode($response, true);
//header('Content-Type: application/json; charset=utf-8');
print_r($response);


