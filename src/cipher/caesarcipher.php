<?php

namespace cipher;

// Classic caesar cipher, default using standard alphabet and ROT13
class caesarcipher extends cipher {

	protected $rot = 13;

    public function __construct ($a = UPPER_ALPHABET, $rot = 13) {
		parent::__Construct ($a);
		$this->rot = ($rot % strlen($this->alphabet));
	}

	public function encode ($text) {
		$newalphabet = substr($this->alphabet, $this->rot) . substr($this->alphabet,0, $this->rot);
		return $this->simplesubstitution ($text, $newalphabet);
	}

	public function decode ($text) {
		$newalphabet = substr($this->alphabet, strlen($this->alphabet) - $this->rot, $this->rot) . substr($this->alphabet, 0, strlen($this->alphabet) - $this->rot);
		return $this->simplesubstitution ($text, $newalphabet);
	}

} // End of caesarcipher

?>
