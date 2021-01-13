<?php

namespace cipher;

class polluxcipher extends cipher {

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
	
	// Characters are randomly selected from a string to represent . - or x
	
	protected $codes;
	
	public function __construct ($alphabet = UPPER_ALPHABET, $key1 = ".", $key2 = "-", $key3 = "x") {
		parent::__construct ($alphabet);
		$this->setkey ($key1, $key2, $key3);
	}
	
	public function setkey ($key1 = ".", $key2 = "-", $key3 = "x") {
		$this->codes = array();
		$this->codes['.'] = $key1;
		$this->codes['-'] = $key2;
		$this->codes['x'] = $key3;
	}
	
	public function getkey() { return $this->codes; }
	
	function encode ($msg = "") {
		
		// Translate msg with x between letters and xx between words
		// Punctutation and numbers can be encoded or skipped (if in alphabet they are encoded)
		// Print in 3 rows, encode each column with the fractionated morse table above
		
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
		
		// Create pollux string
		$s2 = "";
		for ($i = 0; $i < strlen($s); $i++)
			$s2 .= $this->codes[$s[$i]][rand(0, strlen($this->codes[$s[$i]])-1)];
		return $s2;
	}
	
	function decode ($msg = "") {
		
		// Create the string
		$s = "";
		for ($i = 0; $i < strlen($msg); $i++) {
			$pos = strpos ($this->codes['.'], $msg[$i]);
			if ($pos !== FALSE) { $s .= '.'; continue; }
			$pos = strpos ($this->codes['-'], $msg[$i]);
			if ($pos !== FALSE) { $s .= '-'; continue; }
			$pos = strpos ($this->codes['x'], $msg[$i]);
			if ($pos !== FALSE) { $s .= 'x'; continue; }
		}
		
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

} // polluxcipher
