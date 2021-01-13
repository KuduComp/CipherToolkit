<?php

namespace cipher;

// Hill cipher
// First char in alphabet has 0
// Matrix nxn multiplied with vector n
// Matrix is n words of n characters, vector is n chars from msg
// Result vector is take modulo and translated back into char
// requires markbaker/matrix

class burrowswheelercipher extends cipher {

	protected $eof;

	public function __construct ($alphabet, $eof) {
		parent::__construct ($alphabet);
		$this->eof = $eof;
	}

	public function seteof ($eof) { $this->eof = $eof; }
	public function geteof () { return $this->eof; }
	
	public function encode ($msg) {
		return $this->encodeburrowswheelertransposition ($msg, $this->eof);
	}

	public function decode ($msg) {
		return $this->decodeburrowswheelertransposition ($msg, $this->eof);
	}

} // class

?>
