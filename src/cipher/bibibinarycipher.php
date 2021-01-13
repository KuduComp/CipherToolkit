<?php
namespace cipher;

// Bibi binary numbers - https://www.dcode.fr/bibi-binary-code
// Numbers converted into hexadecimal and translated in something that pronounces funny
// https://en.wikipedia.org/wiki/Bibi-binary

class bibibinarycipher extends cipher {

	function __construct () {
		parent::__construct ("0123456789", "MEUGAZOB");
	}

	function encode ($msg = "") {
    $codes= [	"0" => "HO", "1" => "HA", "2" => "HE", "3" => "HI",
	    "4" => "BO", "5" => "BA", "6" => "BE", "7" => "BI",
	    "8" => "KO", "9" => "KA", "A" => "KE", "B" => "KI",
	    "C" => "DO", "D" => "DA", "E" => "DE", "F" => "DI"];

    // Split into words
    preg_match_all ('/(\b[^\s]+\b)/', $msg, $matches);
    $s = "";
		
    // Process each word
		foreach ($matches[0] as $m) {
	    $msg = strtoupper (base_convert ($m, 10, 16));
	    for ($i = 0 ; $i < strlen($msg); $i++) $s .= $codes[$msg[$i]];
	    $s .= " ";
		}
		return substr($s, 0, -1);
	}

	function decode ($msg = "") {
    $codes= ["HO" => "0", "HA" => "1", "HE" => "2", "HI" => "3",
		    "BO" => "4", "BA" => "5", "BE" => "6", "BI" => "7",
		    "KO" => "8", "KA" => "9", "KE" => "A", "KI" => "B",
		    "D)" => "C", "DA" => "D", "DE" => "E", "DI" => "F"];

    // Split into words
    preg_match_all ('/(\b[^\s]+\b)/', $msg, $matches);
    $s = "";

    // Process each word
    foreach ($matches[0] as $m) {
      $msg = strtoupper ($m);
      if (strlen($msg) % 2 == 1) return "Invalid message";
      $s2 = "";
      for ($i = 0; $i < strlen($msg); $i += 2)
        $s2 = $s2 . $codes[$msg[$i] . $msg[$i+1]];
      $s = $s . base_convert ($s2, 16, 10) . " ";
    }
    return substr($s, 0 , -1);
	}

} // bibibinarycipher

?>
