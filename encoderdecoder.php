<?php

// Autoload ciphertoolkit
require_once (__DIR__ . '/vendor/autoload.php');
// use cipher\atbashcipher;
// use cipher\base91code;
// use cipher\polybiuscipher\bifidcipher;
// use cipher\caesarcipher;
// use cipher\cadenuscipher;
// use cipher\polyalphabeticcipher\vigenerecipher;

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}") origin = null!

$json = file_get_contents("php://input");
//For command line testing
// $json = '{"cipher": "Tapir",
// 	"enordecode": "encode",
// 	"message": "the1quick2brownfoxjumpsoverthelazydog",
// 	"key1" : 47,
// 	"key2" : 1,
// 	"key3" : "123",
// 	"transmessage" : "",
// 	"alphabet" : "!#$%&()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[]^_`abcdefghijklmnopqrstuvwxyz{|}~"}';
$data = json_decode($json);

$mes = $data->message;
$transmes = $data->transmessage;

// Array that translates cipher to classnames and array that tells the number of keys
// When using a variable class name it must be fully qualified
$ciphertoclass = array (
	'ADFGVX'=> ['cipher\polybiuscipher\ADFGVXcipher', 1],
	'Affine' => ['cipher\affinecipher', 2],
	'Amsco' => ['cipher\amscocipher', 1],
	'Atbash' => ['cipher\atbashcipher', 0],
	'Autokey' => ['cipher\polyalphabeticcipher\vigenerecipher\autokeycipher', 1],
	'Bacon' => ['cipher\multisubstitutioncipher\baconcipher', 3],
	'Baseconvertor' => ['cipher\baseconvertor', 2],
	'Bazeries' => ['cipher\bazeriescipher', 3],
	'Beaufort' => ['cipher\polyalphabeticcipher\vigenerecipher\beaufortcipher', 1],
	'Bibibinary' => ['cipher\bibibinarycipher', 0],
	'Bifid' => ['cipher\polybiuscipher\bifidcipher', 1],
	'Burrowswheeler' => ['cipher\burrowswheelercipher', 1],
	'Cadenus' => ['cipher\cadenuscipher', 1],
	'Caesar' => ['cipher\caesarcipher', 1],
	'ROT5' => ['cipher\caesarcipher', 1],
	'ROT13' => ['cipher\caesarcipher', 1],
	'ROT47' => ['cipher\caesarcipher', 1],
	'Chaocipher' => ['cipher\chaocipher', 2],
	'Collon' => ['cipher\colloncipher', 3],
	'Columnartransposition' => ['cipher\columnartranspositioncipher', 1],
	'Condi' => ['cipher\condicipher', 2],
	'Digrafid' => ['cipher\digrafidcipher', 3],
	'Foursquare' =>['cipher\foursquarecipher', 2],
	'GCId' =>['cipher\gcidcode', 0],
	'Goldbug' =>['cipher\goldbugcipher', 0],
	'Graycode' =>['cipher\graycode', 1],
	'Gronsfeld' => ['cipher\polyalphabeticcipher\vigenerecipher\gronsfieldcipher', 1],
	'Gromark' => ['cipher\gromarkcipher', 2],
	'Kennycode' => ['cipher\multisubstitutioncipher\kennycode', 0],
	'Monomedinome' => ['cipher\monomedinomecipher', 2],
	'Morse' => ['cipher\multisubstitutioncipher\morsecode', 0],
	'Morbit' => ['cipher\morbitcipher', 1],
	'Myszkowski' => ['cipher\myszkowskicipher', 1],
	'Nicodemus' => ['cipher\polyalphabeticcipher\vigenerecipher\nicodemuscipher', 1],
	'Nihilisttransposition' => ['cipher\nihilisttranspositioncipher', 2],
	'Nihilist' => ['cipher\polybiuscipher\nihilistcipher', 2],
	'Onetimepad' => ['cipher\onetimepadcipher', 1],
	'Phillips' => ['cipher\phillipscipher', 1],
	'Playfair' => ['cipher\playfaircipher', 1],
	'Polybius' => ['cipher\polybiuscipher', 2],
	'Pollux' => ['cipher\polluxcipher', 3],
	'Porta' => ['cipher\portacipher', 1],
	'Portax' =>['cipher\portaxcipher', 1],
	'Railfence' => ['cipher\railfencecipher', 2],
	'Ragbaby' => ['cipher\ragbabycipher', 1],
	'Redefence' => ['cipher\redefencecipher', 3],
	'Reverse' => ['', 0],
	'Reversewords' => ['', 0],
	'Scytale' => ['cipher\skytalecipher', 1],
	'Skip' =>  ['cipher\skipcipher', 2],
	'Substitution' => ['cipher\genericsubstitutioncipher', 1],
	'Tapir' => ['cipher\tapircipher', 0],
	'Trifid' => ['cipher\trifidcipher', 1],
	'Trisquare' => ['cipher\trisquarecipher', 3],
	'Vigenere' => ['cipher\polyalphabeticcipher\vigenerecipher', 1],
	'Vatsyayana' => ['cipher\vatsyayanacipher', 2],
	'Zebra' => ['cipher\zebracipher', 0],
	'Zygazyfa' => ['cipher\zygazyfacipher', 1]
);

$name = $ciphertoclass[$data->cipher][0];
$keycount = $ciphertoclass[$data->cipher][1];

if ($name == "") {
	// Codes or ciphers that are coded here
	if (strtolower($data->enordecode) == 'encode') {
		if (strtolower($data->enordecode) == 'encode') {
			switch ($data->cipher) {
				case "Reverse" :
					$transmes = strrev($data->message);
					break;
				case "Reversewords" :
					preg_match_all ('/(\b[^\s]+\b)/', $data->message, $matches);
					$transmes= "";
					foreach ($matches[0] as $m) $transmes .= strrev($m) . " ";
					break;
			}
		} elseif (strtolower($data->enordecode) == 'decode') {
			switch ($data->cipher) {
				case "Reverse" :
					$transmes = strrev($data->transmessage);
					break;
				case "Reversewords" :
					preg_match_all ('/(\b[^\s]+\b)/', $data->transmessage, $matches);
					$mes= "";
					foreach ($matches[0] as $m) $mes .= strrev($m) . " ";
					break;
			}
		}
	}
} else {
	// Create cipher class
	switch ($keycount) {
		case 0 :
			$c = new $name($data->alphabet);
			break;
		case 1:
			$c = new $name($data->alphabet, $data->key1);
			break;
		case 2:
			$c = new $name($data->alphabet, $data->key1, $data->key2);
			break;
		case 3:
			$c = new $name($data->alphabet, $data->key1, $data->key2, $data->key3);
			break;
	}
	if (strtolower($data->enordecode) == 'encode') {
		if ($data->message == "") $transmes = "Nothing to encode";
			else $transmes = $c->encode($data->message);
	} elseif (strtolower($data->enordecode) == 'decode') {
		if ($data->transmessage == "") $mes="Nothing to decode";
			else $mes = $c->decode($data->transmessage);
	}
}

$message = array(
	'message' => $mes,
	'transmessage' => $transmes
);

//set response code
http_response_code(200);

//return JSON format
echo json_encode($message);

?>
