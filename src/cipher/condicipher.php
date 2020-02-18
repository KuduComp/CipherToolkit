<?php

namespace cipher;

class condicipher extends cipher{

	// The Condi (Consecutive Digraphs) cipher was introduced by G4EGG (Wilfred Higginson) in 2011. The cipher 
	// preserves word divisions, and is simple to describe and encode, but it's surprisingly difficult to crack.

	// Steps for encoding are
	// Generate the cipher using a key
	// Number the cipher starting at 1

	// Encoding starts with an offset
	// First letter is encoded moving <offset> places to the right in the cipher
	// New <offset> is position of 1st letter in the cipher
	// and so on

	protected $alphabet = "ABCDEFHIJKLMNOPQRSTUVWXYZ";
	protected $key = "";
	protected $cipher = "";
	protected $initoffs = 25;
	
	function __construct ($alphabet = "ABCDEFHIJKLMNOPQRSTUVWXYZ", $key = "", $initoffs = 0) {
		parent::__construct ($alphabet);
		$this->setkey ($key, $initoffs);
	}

	function setkey ($key, $initoffs) {
		// Set numeric key
		$this->key = $key;
		$this->initoffs= $initoffs;

		// Set substitution alphabet
		$this->cipher = implode ("", array_unique(str_split($key . $this->alphabet)));
	}

	function encode ($msg) {

		$offset = $this->initoffs;

		// Substitution each character by taking the position in the cipher and adding the offset
		$s = "";
		for ($i = 0; $i<strlen($msg); $i++) {
			$pos = stripos ($this->cipher, $msg[$i]);
			if ($pos === FALSE)
				$s .= $msg[$i];
			else {
				// Minus one because the first number in the cipher is 1 not 0
				$pos++;
				$s .= $this->cipher[ ($pos + $offset - 1) % strlen($this->cipher)];
				$offset = $pos;
			}
		}
		return $s;
	}

	function decode ($msg) {

		$offset = $this->initoffs;

		// Substitution each character by taking the position in the cipher and adding the offset
		$s = "";
		for ($i = 0; $i<strlen($msg); $i++) {
			$pos = stripos ($this->cipher, $msg[$i]);
			if ($pos === FALSE)
				$s .= $msg[$i];
			else {
				// Add one because the first number in the cipher is 1 not 0
				$pos++;
				$idx = (strlen($this->cipher) + $pos - $offset) % strlen($this->cipher);
				$s .= $this->cipher[$idx - 1];
					$offset = $idx;
			}
		}
		return $s;
	}

} // Class condicipher


?>