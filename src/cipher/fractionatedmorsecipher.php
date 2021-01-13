<?php

namespace cipher;

class fractionatedmorsecipher extends cipher {

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
	
	// Fractionated morse alphabet with key
	// R O U N D T A B L E C F G H I J K M P Q S V W X Y Z
	// • • • • • • • • • – – – – – – – – – x x x x x x x x
	// • • • – – – x x x • • • – – – x x x • • • – – – x x
	// • – x • – x • – x • – x • – x • – x • – x • – x • –
	
	protected $key;     // the key used in the table above
	protected $cipher;  // the alphabet used for the table above
	protected $fracmorse = array (
		'...', '..-', '..x', '.-.', '.--', '.-x', '.x.',
		'.x-', '.xx', '-..', '-.-', '-.x', '--.', '---',
		'--x', '-x.', '-x-', '-xx', 'x..', 'x.-', 'x.x',
		'x-.', 'x--', 'x-x', 'xx.', 'xx-');
	
	public function __construct ($alphabet = UPPER_ALPHABET, $key = "") {
		parent::__construct ($alphabet);
		$this->setkey ($key);
	}
	
	public function setkey ($key = "") {
		$this->key = $key;
		$this->cipher = $this->shufflealphabet ($this->alphabet, $key);
	}
	
	public function getkey() { return $this->key; }
	
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
		
		// If not exactly 3 rows append 1 or 2 x
		$ncol = ceil ( strlen($s) / 3);
		for ($i = strlen($s); $i < 3*$ncol; $i++) $s .= 'x';
		
		// Create fractionated morse string
		$s2 = "";
		for ($i = 0; $i < strlen($s); $i += 3) {
			$c = substr($s, $i, 3);
			$s2 .= $this->cipher[array_search($c, $this->fracmorse)];
		}
		return $s2;
	}
	
	function decode ($msg = "") {
		
		// Create the string
		$s = "";
		for ($i = 0; $i < strlen($msg); $i++) $s .= $this->fracmorse[stripos($this->cipher,$msg[$i])];
		
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

} // fractionatedmorsecipher
