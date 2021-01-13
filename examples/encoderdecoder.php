<?php

// Autoload ciphertoolkit
require_once (__DIR__ . '\..\vendor\autoload.php');
use cipher\caesarcipher;

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}") origin = null!

$json = '{"cipher":"ROT13","enordecode": "decode", "message": "asdhjasdahdkj"}';
$data = json_decode($json);

$c = new caesarcipher();

$message = array(
	'cipher' => $data->cipher,
	'enordecode' => $data->enordecode,
	'message' => $data->message,
	'transmessage' => $c->decode($data->message)
);

//set response code
http_response_code(200);

//return JSON format
echo json_encode($message);

?>
