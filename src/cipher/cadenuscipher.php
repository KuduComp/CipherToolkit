<?php

namespace cipher;

class cadenuscipher extends cipher {

	// The cadenuscipher is a transposition cipher (tramp) that uses a keyword
	// to change the column order as well as to shift the rows.

	// Write message in n columns, row after row
	// Write col after col, but do not start with the first row
	// Start with the row based upon the character of the column key using
	// the followig order: AZYXWUTSRQPONMLKJIHGFEDCB (use W for V)

	protected $keystr = "";
	protected $key;
	
	public function __construct ($alphabet, $key) {
		parent::__construct ($alphabet);
		$this->setkey ($key);
	}
	
	public function setkey ($key) {
		$this->keystr = $key;
		$this->key = $this->createtranspositionkey($key);
	}
	
	public function encode ($msg = "") {

		$alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		// Checks
		if ($this->key == null) return "No key specified";
		if ($this->keystr == "") return "No key specified";
		if ($msg == "") return "Nothing to encode";

		// Message should be a multiple of 25 long
		for ($i = 0; $i < (strlen($msg) % 25); $i++) $msg .= $this->alphabet[rand(0,strlen($this->alphabet))];

		// Write row after row
		$ncol = sizeof($this->key);
		$nrow = intdiv(strlen($msg), $ncol);
		$table = array();

		for ($r = 0; $r < $nrow; $r++) {
			$table[$r] = array();
			for ($c = 0; $c < $ncol; $c++)
				$table[$r][$c] = $msg[$r * $ncol + $c];
		}

		// Write row after row but in transposed column order and shifted rows
		$s = "";
		for ($r = 0; $r < $nrow; $r++)
			for ($c = 0; $c < $ncol; $c++) {
				$col = $this->key[$c];
				// Find shifting position
				$kc = substr($this->keystr, $col, 1);;
				if ($kc == "V") $kc = "W";
				$pos = stripos ("AZYXWUTSRQPONMLKJIHGFEDCB", $kc);
				if ($pos === FALSE) return "Illegal character in keystring";
				$s .= $table[($r + $pos) % $nrow][$col];
			}
		return $s;
	}

	public function decode ($msg = "", $keystr = "", $key = null) {

		$alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		// Checks
		if ($this->key == null) return "No key specified";
		if ($this->keystr == "") return "No key specified";
		if ($msg == "") return "Nothing to encode";
		if (strlen($msg) % 25 != 0) return "Not a cadenuscipher message not a multiple of 25";

		$ncol = sizeof($this->key);
		$nrow = intdiv(strlen($msg), $ncol);
		$table = array();

		// Write row after row
		for ($r = 0; $r < $nrow; $r++)
			$table[$r] = array();
		for ($r = 0; $r < $nrow; $r++)
			for ($c = 0; $c < $ncol; $c++) {
				$col = array_search($c, $this->key);
				// Find shifting position
				$kc = substr($this->keystr, $col, 1);;
				if ($kc == "V") $kc = "W";
				$pos = stripos ("AZYXWUTSRQPONMLKJIHGFEDCB", $kc);
				if ($pos === FALSE) return "Illegal character in keystring";

				$table[($r + $pos) % $nrow][$col] = $msg[$r * $ncol + $c];
			}

		// Write row after row
		$s = "";
		for ($r = 0; $r < $nrow; $r++)
			for ($c = 0; $c < $ncol; $c++)
				$s .= $table[$r][$c];
		return $s;
	}

} // Class cadenuscipher

$pt = "aseverelimitationontheusefulnessofthecadenusisthateverymessagemustbeamultipleoftwentyfiveletterslong";
$ct = "SYSTRETOMTATTLUSOATLEEESFIYHEASDFNMSCHBHNEUVSNPMTOFARENUSEIEEIELTARLMENTIEETOGEVESITFAISLTNGEEUVOWUL";
?>