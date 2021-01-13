<?php

namespace cipher;

class morbitcipher extends cipher {

	protected $alphabet = UPPER_ALPHABET;
	protected $morsecode = array (
        'a' => '.-',   'b' => '-...', 'c' => '-.-.', 'd' => '-..',
        'e' => '.',    'f' => '..-.', 'g' => '--.',  'h' => '....',
        'i' => '..',   'j' => '.---', 'k' => '-.-',  'l' => '.-..',
        'm' => '--',   'n' => '-.',   'o' => '---',  'p' => '.--.',
        'q' => '--.-', 'r' => '.-.',  's' => '...',  't' => '-',
        'u' => '..-',  'v' => '...-', 'w' => '.--',  'x' => '-..-',
        'y' => '-.--', 'z' => '--..',
        '0' => '-----', '1' => '.----', '2' => '..---',
        '3' => '...--', '4' => '....-', '5' => '.....',
        '6' => '-....', '7' => '--...', '8' => '---..',
        '9' => '----.',
        '.' => '.-.-.-', ',' => '--..--', '?' => '..--..',
        '!' => '-.-.--', '-' => '-....-', '/'  => '-..-.',
        ':' => '---...', "'" => '.----.',
        ')' => '-.--.-', ';'  => '-.-.-', '('  => '-.--.',
        '=' => '-....-', '@' => '.--.-.', '&'  => '.-...'
		);

	// Morbit example
	// W I S E C R A C K
	// 9 5 8 4 2 7 1 3 6
	// • • • – – – x x x
	// • – x • – x • – x

	protected $key;     // the key used in the table above
	protected $morbit;

	public function __construct ($alphabet = UPPER_ALPHABET, $key = "") {
		parent::__construct ($alphabet);
		$this->setkey ($key);
	}

	public function setkey ($key = "") {
		$this->key = $key;
		$a = $this->createtranspositionkey ($key);
		if (sizeof($a) != 9)
			$this->morbit = null;
		else {
			$this->morbit = array();
			$this->morbit[$a[0]] = "..";
			$this->morbit[$a[1]] = ".-";
			$this->morbit[$a[2]] = ".x";
			$this->morbit[$a[3]] = "-.";
			$this->morbit[$a[4]] = "--";
			$this->morbit[$a[5]] = "-x";
			$this->morbit[$a[6]] = "x.";
			$this->morbit[$a[7]] = "x-";
			$this->morbit[$a[8]] = "xx";
		}
	}

	public function getkey() { return $this->key; }

	function encode ($msg = "") {

		// Translate msg with x between letters and xx between words
		// Punctutation and numbers can be encoded or skipped (if in alphabet they are encoded)
		// Print in 3 rows, encode each column with the fractionated morse table above
		if ($this->morbit == null) return "Invalid key, must be 9 letters";

		$s = "";
		$notwhitespace = FALSE;
		for ($i = 0; $i < strlen($msg); $i++) {
			if (stripos($this->alphabet, $msg[$i]) !== FALSE) {
				$notwhitespace = TRUE;
				$s .= $this->morsecode[strtolower($msg[$i])];
				$s .= 'x';
			} else {
				// Treat non characters in the alphabet as word dividers but only once
				if (($msg[$i] == " ") && ($notwhitespace)) {
					$s .= 'x';
					$notwhitespace = FALSE;
				}
			}
		}

		$s = substr($s, 0, -1);

		// If not exactly 2 rows append 1 or 2 x
		if ( strlen($s) % 2 == 1) $s .= 'x';

		// Create morbit string
		$s2 = "";
		for ($i = 0; $i < strlen($s); $i += 2)
			$s2 .= array_search(substr($s, $i, 2), $this->morbit) + 1;

		return $s2;
	}

	function decode ($msg = "") {

		if ($this->morbit == null) return "Invalid key, must be 9 letters";

		// Create the string
		$s = "";
		for ($i = 0; $i < strlen($msg); $i++) $s .= $this->morbit[$msg[$i]-1];

		// Scan the resulting string
		$s2 = "";
		$i = 0;
		while ($i < strlen($s)) {
			// Find the letter until 'x'
			$c = "";
			if ($s[$i] == 'x') {
				$s2 .= " ";
			} else {
				while ( ($i < strlen($s)) && ($s[$i] != 'x') ) $c .= $s[$i++];
				$s2 .= array_search($c, $this->morsecode);
			}
			$i++;
		}
		return $s2;
	}

} // morbitcipher
