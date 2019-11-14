<?php

namespace cipher\polybiuscipher;

class nihilistcipher extends polybiuscipher {

    protected $addkey = "";
    protected $addkeylen = 0;
    protected $addkeyarr;
    
    public function __construct ($alphabet = UPPER_ALPHABET_REDUCED, $key = "", $addkey = "") {
        $alphabet = $this->shufflealphabet($alphabet, $key);
        parent::__construct ($alphabet);
	$this->setaddkey ($addkey);
	$this->addkeylen = strlen($addkey);
    }

    public function setaddkey ($addkey = "") {

    	$this->addkeylen = strlen($addkey);
    	$this->addkey    = $addkey;
    
    	// Encode the key to be added with the same polybiuscode
        $addkeycoded = parent::encode($addkey);

    	// Convert the coded key to an array of integers
    	$this->addkeyarr = array();
    	preg_match_all ("/([0-9]{2})[.]*/", $addkeycoded, $parsed);
    	foreach ($parsed[1] as $p) $this->addkeyarr[] = intval($p);
    }
    
    public function getaddkey() { return $this->addkey; }
    
    public function encode ($msg) {

        // Encode message as polybiuscipher
        $msg = parent::encode ($msg);

        // Add the key to the encoded message and convert to string
	    $s = "";
        preg_match_all ("/([0-9]{2})[.]*/", $msg, $parsed);
    	$idx = 0;
    	foreach ($parsed[1] as $p) {
    	    $n = intval($p) + $this->addkeyarr[$idx % $this->addkeylen];
    	    $s = $s . sprintf("%02d", $n) . $this->sep;
    	    $idx++;
    	}
    	
        return $s;
    }
    
    public function decode ($msg) {

    	// Substract the key to the encoded message and convert to string
    	$s = "";
        preg_match_all ("/([0-9]{2})[.]*/", $msg, $parsed);
    	$idx = 0;
    	foreach ($parsed[1] as $p) {
    	    $n = intval($p) - $this->addkeyarr[$idx % $this->addkeylen];
    	    $s = $s . sprintf("%02d", $n) . $this->sep;
    	    $idx++;
    	}
    	
	    // Decode the result as polybius
	        echo $s;
        $msg = parent::decode(substr($s,0,-1));
        return $msg;
    }
    
} // Class nihilistcipher

?>
