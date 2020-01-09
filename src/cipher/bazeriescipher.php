<?php

namespace cipher;
use \NumberFormatter;

// Bazeries cipher
// Split message in chunks, reverse each chunk before encoding
// Uses two squares - locate character in 1st square and replaces with the 2nd square
// Default square 1 is vertically transcribed alphabet
// Default square 2 uses spelled number

class bazeriescipher extends cipher {

	protected $alphabet;
	protected $key1;	// Sets square 1
	protected $key2;	// Sets square 2, typically equals n written out
	protected $sq1, $sq2;
	protected $n; 		// Determines grouping
	protected $chunk;

	public function __construct ($alphabet = "ABCDEFGHIKLMNOPQRSTUVWXYZ", $key1 = "", $key2 = "", $n = 1) {
		parent::__construct ($alphabet);
		$this->setkeys ($key1, $key2);
		$this->setn ($n);
	}

	public function setkeys ($key1 = "", $key2 = "") {
		$this->key1 = $key1;
		if ($key1 != "")
			$this->sq1 = $this->shufflealphabet ($this->alphabet, $key1);
		else
    		$this->key1 = "Unused";
			$this->sq1 = $this->fillsquare ($this->alphabet, "VERT", "TL");
		$this->key2 = $key2;
		if ($key2 != "")
			$this->sq2  = $this->shufflealphabet ($this->alphabet, $key2);
		else {
            $this->key2 = "Unused";
            $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
            $s = $f->format($n);
            $s = cleaninput($s);
			$this->sq2  = $this->shufflealphabet ($this->alphabet, $s);
		}
	}

	public function setsquares ($sq1, $sq2) {
		// Set squares directly
		$this->key1 = "Unused";
		$this->key2 = "Unused";
		$this->sq1  = $sq1;
		$this->sq2  = $sq2;
	}

	public function setn ($n = 1) {
		$this->n = $n;
		$this->chunk = str_split ( (string) $n); 
	}

	public function getkeys () { return array($this->key1, $this->key2); }
	public function getsquares() { return array ($this->sq1, $this->sq2); }
	public function getn() { return $this->n; }

	public function encode ($msg) {

		// Remove spaces and other stuff
		$msg = $this->cleaninput ($msg);

		// Split msg in chunks and reverse each chunk
		$s = "";
		$i = 0;
		$len = sizeof ($this->chunk);
		while ($msg != "") {
			$s .= strrev (substr($msg, 0, $this->chunk[$i % $len]));
			$msg = substr($msg, $this->chunk[$i % $len]);
			$i++;
		}

		// Code the string
		$s2 = "";
		for ($i = 0; $i < strlen ($s); $i++) {
			$pos = $this->strpos2 ($this->sq1, $s[$i]);
			if ($pos !== FALSE) $s2 .= $this->sq2[$pos];
		}
		return $s2;
	}

	public function decode ($msg) {

		// Remove spaces and other stuff
		$msg = $this->cleaninput ($msg);

		// Decode the string
		$s = "";
		for ($i = 0; $i < strlen ($msg); $i++) {
			$pos = $this->strpos2 ($this->sq2, $msg[$i]);
			if ($pos !== FALSE) $s .= $this->sq1[$pos];
		}

		// Reverse chunks
		$s2 = "";
		$i = 0;
		$len = sizeof ($this->chunk);
		while ($s != "") {
			$s2 .= strrev (substr($s, 0, $this->chunk[$i % $len]));
			$s = substr($s, $this->chunk[$i % $len]);
			$i++;
		}

		return $s2;
	}

} // bazeriescipher

?>
