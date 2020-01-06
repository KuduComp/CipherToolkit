<?php

namespace cipher;

// Shadok numbers - https://www.dcode.fr/shadoks-numeral-system
// A strange way of counting use in the French Shadok cartoon, not really a cipher
// Function take numbers (or words) as input. Illegal characters in the input are ignored.

function encode ($msg = "") {
    
    preg_match_all ('/(\b[^\s]+\b)/', $msg, $matches);
    $tags = array ("GA", "BU", "ZO", "MEU");
	  $s = "";

    foreach ($matches[0] as $m) {
    	$msg = base_convert ($m, 10, 4);
    	for ($i = 0 ; $i < strlen($msg); $i++) $s .= $tags[intval($msg[$i])];
    	$s .= " ";
    }
    return substr($s, 0, -1);
}

function decode ($msg = "") {
    
    $tags = array ("GA"=>"0", "BU"=>"1", "ZO"=>"2", "MEU"=>"3");
    preg_match_all ('/(\b[^\s]+\b)/', $msg, $matches);
    $s2 = "";

    foreach ($matches[0] as $m) {
        preg_match_all ('/MEU|GA|ZO|BU/', $m, $a);
        $s = "";
        foreach ($a[0] as $p) $s .= $tags[$p];
        $s2 = $s2 . base_convert ($s, 4, 10) . " ";
    }
    return substr($s2, 0 , -1);
}

?>
