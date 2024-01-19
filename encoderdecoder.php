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

// $json = file_get_contents("php://input");
// For command line testing
$json = '{"cipher": "trevanion",
	"enordecode": "decode",
	"message": "",
	"key1" : ".,:;?!",
	"key2" : 3,
	"transmessage" : ".thequi.ckbrownfox,jumpsovert?helazydog",
	"alphabet" : "ABCDEFGHIJKLMNOPQRSTUVWXYZ"}';
$data = json_decode($json);

$mes = $data->message;
$transmes = $data->transmessage;

// Array that translates cipher to classnames and array that tells the number of keys
// When using a variable class name it must be fully qualified
$ciphertoclass = array (
	'adfgvx'=> ['cipher\polybiuscipher\ADFGVXcipher', 1],
	'affine' => ['cipher\affinecipher', 2],
	'amsco' => ['cipher\amscocipher', 1],
	'atbash' => ['cipher\atbashcipher', 0],
	'atomtom' => ['cipher\multisubstitutioncipher\atomtomcipher', 0],
	'autokey' => ['cipher\polyalphabeticcipher\vigenerecipher\autokeycipher', 1],
	'bacon' => ['cipher\multisubstitutioncipher\baconcipher', 3],
	'bazeries' => ['cipher\bazeriescipher', 3],
	'beaufort' => ['cipher\polyalphabeticcipher\vigenerecipher\beaufortcipher', 1],
	'bibibinary' => ['cipher\bibibinarycipher', 0],
	'bifid' => ['cipher\polybiuscipher\bifidcipher', 1],
	'burrowswheeler' => ['cipher\burrowswheelercipher', 1],
	'cadenus' => ['cipher\cadenuscipher', 1],
	'rot5' => ['cipher\caesarcipher', 1],
	'rot13' => ['cipher\caesarcipher', 1],
	'rot47' => ['cipher\caesarcipher', 1],
	'chaocipher' => ['cipher\chaocipher', 2],
	'collon' => ['cipher\colloncipher', 3],
	'columnartransposition' => ['cipher\columnartranspositioncipher', 1],
	'condi' => ['cipher\condicipher', 2],
	'digrafid' => ['cipher\digrafidcipher', 3],
	'foursquare' =>['cipher\foursquarecipher', 2],
	'gcid' =>['cipher\gcidcode', 0],
	'goldbug' =>['cipher\goldbugcipher', 0],
	'gronsfield' => ['cipher\polyalphabeticcipher\vigenerecipher\gronsfieldcipher', 1],
	'gromark' => ['cipher\gromarkcipher', 2],
	'kennycode' => ['cipher\multisubstitutioncipher\kennycode', 0],
	'monomedinome' => ['cipher\monomedinomecipher', 2],
	'morse' => ['cipher\multisubstitutioncipher\morsecode', 0],
	'morbit' => ['cipher\morbitcipher', 1],
	'myszkowski' => ['cipher\myszkowskicipher', 1],
	'nicodemus' => ['cipher\polyalphabeticcipher\vigenerecipher\nicodemuscipher', 1],
	'nihilisttransposition' => ['cipher\nihilisttranspositioncipher', 2],
	'nihilist' => ['cipher\polybiuscipher\nihilistcipher', 2],
	'onetimepad' => ['cipher\onetimepadcipher', 1],
	'phillips' => ['cipher\phillipscipher', 1],
	'playfair' => ['cipher\playfaircipher', 1],
	'polybius' => ['cipher\polybiuscipher', 2],
	'pollux' => ['cipher\polluxcipher', 3],
	'porta' => ['cipher\portacipher', 1],
	'portax' =>['cipher\portaxcipher', 1],
	'railfence' => ['cipher\railfencecipher', 2],
	'ragbaby' => ['cipher\ragbabycipher', 1],
	'redefence' => ['cipher\redefencecipher', 3],
	'reverse' => ['', 0],
	'reversewords' => ['', 0],
	'rot123' => ['cipher\rot123cipher', 1],
	'scytale' => ['cipher\skytalecipher', 1],
	'skip' =>  ['cipher\skipcipher', 2],
	'substitution' => ['cipher\genericsubstitutioncipher', 1],
	'syllabary' => ['cipher\syllabarycipher', 3],
	'tapir' => ['cipher\tapircipher', 0],
	'trevanion' => ['cipher\trevanioncipher', 2],
	'trifid' => ['cipher\trifidcipher', 1],
	'trisquare' => ['cipher\trisquarecipher', 3],
	'vigenere' => ['cipher\polyalphabeticcipher\vigenerecipher', 1],
	'vatsyayana' => ['cipher\vatsyayanacipher', 2],
	'zebra' => ['cipher\zebracipher', 0],
	'zygazyfa' => ['cipher\zygazyfacipher', 1]
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
