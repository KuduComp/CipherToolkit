<?php

namespace cipher\polybiuscipher;

class nihilistcipher extends \cipher\polybiuscipher {

    protected $addkey = "";
    protected $addkeylen = 0;
    protected $addkeyarr;
    
    public function __construct ($alphabet = UPPER_ALPHABET_REDUCED, $key = "", $addkey = "") {
        parent::__construct ($alphabet);
	$this->setkey($key);
	$this->setaddkey ($addkey);
	$this->addkeylen = strlen($addkey);
    }

    public function setaddkey ($addkey = "") {

    	$this->addkeylen = strlen($addkey);
    	$this->addkey    = $addkey;
    
    	// Encode the key to be added with the same polybiuscode
        $addkeycoded = $this->cleanencodedmessage(parent::encode($addkey));

    	// Convert the coded key to an array of integers
    	$this->addkeyarr = array();
    	For ($i=0; $i < strlen ($addkeycoded); $i +=2) $this->addkeyarr[] = intval(substr($addkeycoded,$i,2));
    }
    
    public function getaddkey() { return $this->addkey; }
    
    public function encode ($msg) {

        // Encode message as polybiuscipher
        $msg = parent::encode ($msg);
	// Force separator if not there (as numbers can become >99 due to addition)
	if ($this->getsep() == "") $this->setsep(" ");

        // Add the key to the encoded message and convert to string
	$s = "";
        preg_match_all ("/([0-9]{2})[.]*/", $msg, $parsed);
    	$idx = 0;
    	foreach ($parsed[1] as $p) {
    	    $n = intval($p) + $this->addkeyarr[$idx % $this->addkeylen];
    	    $s = $s . sprintf("%02d", $n) . $this->sep;
    	    $idx++;
    	}
    	
        return substr($s,0,-1);
    }
    
    public function decode ($msg) {

    	// Force separator if not there (as numbers can become >99 due to addition)
	if ($this->getsep() == "") $this->setsep(" ");
	
	// Substract the key to the encoded message and convert to string
    	$s = "";
        preg_match_all ("/([0-9]{2,3})[.]*/", $msg, $parsed);
    	$idx = 0;
    	foreach ($parsed[1] as $p) {
    	    $n = intval($p) - $this->addkeyarr[$idx % $this->addkeylen];
    	    $s = $s . sprintf("%02d", $n) . $this->sep;
    	    $idx++;
    	}
    	
	// Decode the result as polybius
        return parent::decode(substr($s,0,-1));
    }
    
} // Class nihilistcipher

?>
