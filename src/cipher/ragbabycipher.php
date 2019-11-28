<?php

namespace cipher;

class ragbabycipher extends cipher {

	// The ragbaby cipher is a substitution cipher that encodes/decodes a text using a keyed alphabet
	// and their position in the plaintext word they are a part of.
	// Position in the word, 1st word 1st positoin = 1, 2nd word 1st position = 2, 3rd word 1st pos = 3 etc.
	// Original alphabet was 24 chars with I/J and W/X pairs

	protected $alphabet = "ABCDEFHIKLMNOPQRSTUVWYZ";
	protected $key = "";
	protected $cipher = "";
	protected $initoffs = 25;

	public function __construct ($alphabet, $key, $initoffs) {
		parent::__construct ($alphabet);
		$this->initoffs = $initoffs;
		$this->setkey ($key);
	}
	
	public function setkey ($key) {

		// Set numeric key
		$this->key = $key;

		// Set substitution alphabet
		$this->cipher = implode ("", array_unique(str_split($key . $this->alphabet)));
	}
	
	public function getkey () { return $this->key; }

	public function encode ($msg) {

		$offset = 1;
		$wordcount = 1;

		$s = "";
		for ($i = 0; $i<strlen($msg); $i++) {
			$pos = stripos ($this->cipher, $msg[$i]);
			if ($pos === FALSE) {
			$s .= $msg[$i];
			// Hyphens and apostrophes are considered one word
			if (($msg[$i] != "-") && ($msg[$i] != "'")) $offset = ++$wordcount;
			} else {
				$s .= $this->cipher[ ($pos + $offset) % strlen($this->cipher)];
				$offset++;
			}
		}
		return $s;
	}

	public function decode ($msg) {

		$offset = 1;
		$wordcount = 1;

		$s = "";
		for ($i = 0; $i<strlen($msg); $i++) {
			$pos = stripos ($this->cipher, $msg[$i]);
			if ($pos === FALSE) {
			$s .= $msg[$i];
			// Hyphens and apostrophes are considered one word
			if (($msg[$i] != "-") && ($msg[$i] != "'")) $offset = ++$wordcount;
			} else {
				$s .= $this->cipher[ (strlen($this->cipher) + $pos - $offset) % strlen($this->cipher)];
				$offset++;
			}
		}	
		return $s;
	}

} // Class ragbabycipher
