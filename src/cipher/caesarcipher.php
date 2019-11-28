<?php

namespace cipher;

// Classic caesar cipher, default using standard alphabet and ROT13
class caesarcipher extends cipher {
	
    public function __construct ($a = UPPER_ALPHABET) {
		parent::__Construct ($a);
	}
	
	public function encode ($text, $rot=13) {
		$newalphabet = substr($this->alphabet, $rot) . substr($this->alphabet,0, $rot);
		return $this->simplesubstitution ($text, $newalphabet);
	}
	
	public function decode ($text, $rot=13) {
		$newalphabet = substr($this->alphabet, strlen($this->alphabet) - $rot, $rot) . substr($this->alphabet, 0, strlen($this->alphabet) - $rot);
		return $this->simplesubstitution ($text, $newalphabet);
	}

} // End of caesarcipher

?>