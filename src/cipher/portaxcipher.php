<?php

namespace cipher;

class portaxcipher extends cipher {
 
	// Portax is a polygraphic (replaces digrams), polyalphabetic (it shifts the
	// alphabvet), transposition (rows to columns) cipher.

	protected $a11 = "ABCDEFGHIJKLM";
	protected $a12 = "NOPQRSTUVWXYZNOPQRSTUVWXYZ";
	protected $a21 = "ACEGIKMOQSUWYACEGIKMOQSUWY";
	protected $a22 = "BDFHJLNPRTVXZBDFHJLNPRTVXZ";
	protected $key = "";
	
	public function __construct ($alphabet, $key = "") {
		parent::__construct ($alphabet);
		$this->key = $key;
	}
	
	public function getkey() { return $this->key; }
	public function setkey($key = "") { $this->key = $key; }

	public function encode ($msg) {
		
		// Checks
		if ($msg == "") return "Nothing to encode or decode";
		if ($this->key == "") return "No key specified";
	
		$ncol = strlen($this->key);
		$nrow = (integer) ceil (strlen($msg) / $ncol);
		if (($nrow % 2) != 0) $nrow++;
		
		// Append message to fill the exact number of columns with even number of rows
		for ($i = strlen($msg); $i < $ncol * $nrow; $i++) $msg .= 'X';
		
		// Fill a table with keylength columns
		$table = array ();
		for ($r = 0; $r < $nrow; $r++) {
			$table[$r] = array();
			for ($c = 0; $c < $ncol; $c++) $table[$r][$c] = $msg[$r * $ncol + $c];
		}

		// Encode each column taking digrams
		$table2 = array();
		for ($r = 0; $r < $nrow; $r++) $table2[$r] = array();
		
		for ($c = 0; $c < $ncol; $c++) {

			// Calculate shift of alphabet $a11
			$pos = strpos ($this->a21, $this->key[$c]);
			if ($pos === FALSE) $pos = stripos ($this->a22, $this->key[$c]);
			if ($pos !== FALSE) $shift = $pos; else return "Illegal key";

			for ($r = 0; $r < $nrow; $r+=2) {
				$c1 = $table[$r][$c];
				$c2 = $table[$r+1][$c];

				// Find positions either pos11 or pos12 is FALSE, same for pos21 and pos22
				$pos11 = stripos ($this->a11, $c1);
				$pos12 = stripos ($this->a12, $c1, $shift);
				$pos21 = stripos ($this->a21, $c2, $shift);
				$pos22 = stripos ($this->a22, $c2, $shift);
				($pos11 !== FALSE) ? $pos1 = $pos11 + $shift : $pos1 = $pos12;
				($pos21 !== FALSE) ? $pos2 = $pos21 : $pos2 = $pos22;

				if ($pos1 == $pos2) {					
					// If both letters are on the same position take the letters above or below
					($pos11 !== FALSE) ? $table2[$r][$c] = $this->a11[$pos1 - $shift] : $table2[$r][$c] = $this->a12[$pos1];
					($pos21 !== FALSE) ? $table2[$r+1][$c] = $this->a22[$pos2] : $table2[$r+1][$c] = $this->a21[$pos2];

				} else {
					// Take the opposite corners of the square
					($pos11 !== FALSE) ? $table2[$r][$c] = $this->a11[$pos2- $shift] : $table2[$r][$c] = $this->a12[$pos2];
					($pos21 !== FALSE) ? $table2[$r+1][$c] = $this->a21[$pos1] : $table2[$r+1][$c] = $this->a22[$pos1];
				}
			}
		}
		
		// Print row after row
		$s = "";
		for ($r = 0; $r < $nrow; $r++) {
			for ($c = 0; $c < $ncol; $c++) $s .= $table2[$r][$c];
		}

		return $s;
	} // Encode
	
	public function decode ($msg) { return $this->encode($msg); }

} // portaxcipher

?>

 

 