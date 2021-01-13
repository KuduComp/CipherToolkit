<?php

namespace cipher;

class portacipher extends cipher {

	// The porta cipher is a polyalphabetic cipher which uses 13 alphabets
	// The alphabets and index are (A,B) N..Z, (C,D) O..ZN, (E,F) P..ZNO etc

	// Encryption uses a key to match
	// Take the letter of the key (mod key length)
	// Find N..Z alphabet
	// If letter is N..Z got to columnheader A..B
	// If letter is A..B take corresponding N..Z

	protected $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	protected $key = "";
	protected $tableau = "";

	public function __construct ($alphabet, $key) {
		parent::__construct ($alphabet);
		$this->setkey($key);
		$this->settableau();
	}

	public function setkey ($key) {
		$this->key = $key;
		$this->keylen = strlen($key);
	}

	public function getkey() { return $this->key; }

	public function settableau () {

		// Set numeric key
		$this->tableau = [];

		// Generate the tableau
		$tab = substr($this->alphabet, strlen($this->alphabet) / 2);
		for ($i = 0; $i < strlen($this->alphabet); $i+=2) {
			$this->tableau[$this->alphabet[$i]] = $tab;
			$this->tableau[$this->alphabet[$i+1]] = $tab;
			$tab = substr($tab,1) . $tab[0];
		}
	}

	public function gettableau() { return $this->tableau; }

	public function encode ($msg) {

		//Checks
		if ($this->keylen == 0) return "No key specified";
		if ($msg == "") return "Nothing to encode or decode";

		$s = "";
		$cnt = 0;
		for ($i = 0; $i<strlen($msg); $i++) {
			$row = $this->key [$cnt % $this->keylen];
			if (stripos ($this->tableau[$row], $msg[$i]) !== FALSE) {
				$s .= $this->alphabet[stripos ($this->tableau[$row], $msg[$i])];
				$cnt++;
			} elseif (stripos ($this->alphabet, $msg[$i]) !== FALSE) {
				$s .= $this->tableau[$row][stripos ($this->alphabet, $msg[$i])];
				$cnt++;
			} else
				$s .= $msg[$i];
		}
		return $s;
	}

	public function decode ($msg) { return $this->encode($msg); }

} // Class portacipher
