<?php

namespace cipher;

class onetimepadcipher extends cipher {

	// Each character is encoded with the corresponding character in the key (one time pad).
	// An unbreakable cipher, when the key at least as long as the message and truly random.

	protected $otp = "";
	
	public function __construct ($alphabet, $key) {
		parent::__construct ($alphabet);
		$this->key = $key;
	}
	
	public function encode ($msg) {

		// Checks
		if (strlen($msg) > strlen($this->key)) return 'One time pad should be at least as long as the message';

		// Encode uses substraction - decode uses addition (mod size of the alphabet)
		// But you can encode using decode if you use decode to encode ;-)
		$s = "";
		$len = strlen($this->alphabet);
		for ($i = 0; $i < strlen($msg); $i++)
			$s .= $this->alphabet[ ($len + strpos($this->alphabet, $msg[$i]) - strpos($this->alphabet, $this->key[$i])) % $len];

		return $s;
	}

	public function decode ($msg) {

		// Checks
		if (strlen($msg) > strlen($this->key)) return 'One time pad should be at least as long as the message';

		// Encode uses substraction - decode uses addition (mod size of the alphabet)
		// But you can encode using decode if you use decode to encode ;-)
		$s = "";
		$len = strlen($this->alphabet);
		for ($i = 0; $i < strlen($msg); $i++)
			$s .= $this->alphabet[ (strpos($this->alphabet, $msg[$i]) + strpos($this->alphabet, $this->key[$i])) % $len];

		return $s;
	}

} // onetimepadcipher

?>