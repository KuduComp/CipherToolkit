<?php

namespace cipher;

class alberticipher extends cipher {

    protected $cipherdisc; 
	protected $nullchars;
	
    public function __construct ($alphabet, $cipherdisc, $nullchars = "") {
        parent::__construct ($alphabet);
        $this->cipherdisc = $cipherdisc;
		$this->nullchars  = $nullchars;
    }

    public function setcipherdisc ($cipherdisc) { $this->cipherdisc = $cipherdisc; }
    public function getcipherdisc () { return $this->cipherdisc; }
    public function setnullchars ($nullchars) { $this->nullchars = $nullchars; }
    public function getnullchars () { return $this->nullchars; }


	// Method 1 as documented on wikipedia and by Albert in Chapter XIV
	// See https://en.wikipedia.org/wiki/Alberti_cipher_disk
	// and https://en.wikipedia.org/wiki/Alberti_cipher
	
	// A character from the inner circle (cipher) is used as the index.
	// The disc is rotated by adding an unencoded character (from the outer
	// circle to the message. The first char in the message inits the disc.
	//
	// If one want to rotates the disc a character from the outer circle is added 
	// to the encoded message. When decoding a character from the outer circle
	// signals the rotation.
	
	function encodemethod1 ($msg, $index) {

		// Move $index under $start
		$pos = strpos ($this->cipherdisc, $index);
		$disc = substr ($this->cipherdisc, $pos) . substr ($this->cipherdisc, 0, $pos);

		$s = "";
		for ($i = 0; $i < strlen($msg); $i++) {
			// Find char in plaindisc
			$pos = strpos ($this->alphabet, $msg[$i]);
			if ($pos !== FALSE)
				$s .= $disc[$pos];
			else {
				// If not find char in cipherdisc
				$pos = strpos ($disc, $msg[$i]);
				if ($pos !== FALSE) {
					// Add plain character to message
					$s .= $this->alphabet[$pos];
					// Turn cipherdisc
					$disc = substr ($disc, $pos) . substr ($disc, 0, $pos);
				}
			}
		}
		return $s;
	}

	function decodemethod1 ($msg, $index) {

		// First character in message positions the index of the cipherdisc
		$posplain = strpos ($this->alphabet, $msg[0]);
		$poscipher= strpos ($this->cipherdisc, $index);

		($posplain > $poscipher) ? $shift = strlen($this->cipherdisc) - ($posplain - $poscipher) :
						$shift = $poscipher - $posplain;
		$disc = substr ($this->cipherdisc, $shift) . substr ($this->cipherdisc, 0, $shift);

		$s = "";
		for ($i = 0; $i < strlen($msg); $i++) {

			// Find char in plaindisc
			$pos = strpos ($disc, $msg[$i]);
			if ($pos !== FALSE) {
				if (strpos ($this->nullchars, $this->alphabet[$pos]) === FALSE) $s .= $this->alphabet[$pos];
			} else {
				// If not find char in plaindisc
				$pos = strpos ($this->alphabet, $msg[$i]);
				if ($posplain !== FALSE)
					$disc = substr ($this->cipherdisc, $pos) . substr ($this->cipherdisc, 0, $pos);
			}
		}
		return $s;
	}
	
	// Method 2 as documented on wikipedia and by Albert in Chapter XV
	// See https://en.wikipedia.org/wiki/Alberti_cipher_disk
	// and https://en.wikipedia.org/wiki/Alberti_cipher

	// An character from the outer disc is used as an index. The inner disc
	// is rotated so the index matches the inner circle. The first char in the
	// message inits the disc.
	
	// When one wants to rotate the disc one inserts a character that matches
	// a null character. The inner disc is then aligned with that character.
	
	function encodemethod2 ($msg, $index) {

		// First character in message positions the index of the cipherdisc
		$cipherdisc = $this->cipherdisc;
		$posplain = strpos ($this->alphabet, $index);
		$poscipher= strpos ($cipherdisc, $msg[0]);

		($posplain > $poscipher) ? $shift = strlen($cipherdisc) - ($posplain - $poscipher) :
						$shift = $poscipher - $posplain;
		$disc = substr ($cipherdisc, $shift) . substr ($cipherdisc, 0, $shift);
		$cipherdisc = $disc;

		$s = $msg[0];
		for ($i = 0; $i < strlen($msg); $i++) {
			// Find char in plaindisc
			$pos = strpos ($this->alphabet, $msg[$i]);
			if ($pos !== FALSE)  $s .= $disc[$pos];
			$pos2 = strpos ($this->nullchars, $msg[$i]);
			if ($pos2 !== FALSE) {
				// Rotate disk
				$disc = substr ($cipherdisc, $pos) . substr ($cipherdisc, 0, $pos);
			}
		}
		return $s;
	}

	function decodemethod2 ($msg, $index) {

		// First character in message positions the index of the cipherdisc
		$cipherdisc = $this->cipherdisc;
		$posplain = strpos ($this->alphabet, $index);
		$poscipher= strpos ($cipherdisc, $msg[0]);

		($posplain > $poscipher) ? $shift = strlen($cipherdisc) - ($posplain - $poscipher) :
						$shift = $poscipher - $posplain;
		$disc = substr ($cipherdisc, $shift) . substr ($cipherdisc, 0, $shift);
		$cipherdisc = $disc;

		$s = "";
		for ($i = 1; $i < strlen($msg); $i++) {
			// Find char in plaindisc
			$pos = strpos ($disc, $msg[$i]);
			if ($pos !== FALSE) {
				$pos2 = strpos ($this->nullchars, $this->alphabet[$pos]);
				if ($pos2 !== FALSE) {
					// Rotate disk
					$disc = substr ($cipherdisc, $pos) . substr ($cipherdisc, 0, $pos);
				} else {
					$s .= $this->alphabet[$pos];
				}
			}
		}
		return $s;
	}

	// Method 3 as implmented by dcode.fr
	// Simply shift the cipherdisc after each period with incr positions clockwise
	
	function encodemethod3 ($msg, $index, $period, $incr) {

		// Set alphabet with initial shift (or offset)
		$cipherdisc = substr ($this->cipherdisc, $index) . substr ($this->cipherdisc, 0, $index);

		$s = "";
		for ($i = 0; $i < strlen($msg); $i++) {
			if (($i % $period == 0) && ($i != 0))
				// Rotate disk
				$cipherdisc = substr ($cipherdisc, $incr) . substr ($cipherdisc, 0, $incr);
			// Find char in plaindisc
			$pos = strpos ($this->alphabet, $msg[$i]);
			if ($pos !== FALSE) $s .= $cipherdisc[$pos];
		}
		return $s;
	}

	function decodemethod3 ($msg, $index, $period, $incr) {
	 
		// Set alphabet with initial shift (or offset)
		$cipherdisc = substr ($this->cipherdisc, $index) . substr ($this->cipherdisc, 0, $index);

		$s = "";
		for ($i = 0; $i < strlen($msg); $i++) {
			if (($i % $period == 0) && ($i != 0))
				// Rotate disk
				$cipherdisc = substr ($cipherdisc, $incr) . substr ($cipherdisc, 0, $incr);
			// Find char in plaindisc
			$pos = strpos ($cipherdisc, $msg[$i]);
			if ($pos !== FALSE) $s .= $this->alphabet[$pos];
		}
		return $s;
	}

    function encode ($msg, $method = 1, $index = 0, $period = 0, $incr = 0) {
		switch ($method) {
			case 1 :
			case "1" :
				if ($index == 0) $index = $this->cipherdisc[0];
				return $this->encodemethod1 ($msg, $index);
			case 2 :
			case "2" :
				if ($index == 0) $index = $this->alphabet[0];
				return $this->encodemethod2 ($msg, $index);
			case 3 :
			case "3" :
				return $this->encodemethod3 ($msg, $index, $period, $incr);
			default: 
				return "Invalid method";
		}
    }

	function decode ($msg, $method = 1, $index = 0, $period = 0, $incr = 0) {
		switch ($method) {
			case 1 :
			case "1" :
				return $this->decodemethod1 ($msg, $index);
			case 2 :
			case "2" :
				return $this->decodemethod2 ($msg, $index);
			case 3 :
			case "3" :
				return $this->decodemethod3 ($msg, $index, $period, $incr);
			default: 
				return "Invalid method";
		}
    }

}  // class alberticipher

?>