<?php

namespace cipher;

class digrafidcipher extends cipher {
	
	protected $key1, $key2;
	protected $alphabet1, $alphabet2;
	protected $tableau;
	protected $fraction = 9;
	
	public function __construct ($alphabet, $key1, $key2) {
		parent::__construct ($alphabet);
		$this->setkeys($key1, $key2);
	}
	
	function setkeys ($key1, $key2) {
	
		$this->key1 = $key1;
		$this->key2 = $key2;
		$this->alphabet1 = strtoupper ($this->alphabet);
		$this->alphabet2 = strtolower ($this->alphabet);
		$numbers   = array ( array (1,2,3), array (4,5,6), array (7,8,9));
		
		$this->tableau = array();
		$this->alphabet1 = implode("", array_unique(str_split(strtoupper($key1) . $this->alphabet1)));
		$this->alphabet2 = implode("", array_unique(str_split(strtolower($key2) . $this->alphabet2)));
		
		for ($i1 = 0; $i1 < strlen($this->alphabet1); $i1++) {
			for ($i2 = 0; $i2 < strlen($this->alphabet2); $i2++) {
				$c1 = (string) ($i1 % 9 + 1);
				$c2 = (string) $numbers[intdiv($i1,9)][intdiv($i2,9)];
				$c3 = (string) ($i2 % 9 + 1);
				$this->tableau[ $this->alphabet1[$i1] . $this->alphabet2[$i2] ] = $c1 . $c2 . $c3;
			}
		}
	}
	
	function getkeys() { return array($key1, $key2); }
	function setFraction ($frac = 3) { $this->fraction = 3 * $frac; }
	function getFraction () { return $this->fraction / 3; }
	
	function encode ($msg) {
		$s = "";
		for ($i = 0; $i < strlen($msg); $i +=2) 
			$s .= $this->tableau[strtoupper($msg[$i]).strtolower($msg[$i+1])];
		
		// Fractionate in chunks
		$s2 = "";
		for ($i = 0; $i <strlen($s); $i += $this->fraction)
			$s2 .= $this->rowtocolumntransposition(substr($s, $i, $this->fraction), 3);
		
		// Reverse coding
		$s = "";
		for ($i = 0; $i < strlen ($s2); $i += 3)
			$s .= array_search( substr($s2, $i, 3), $this->tableau);

		return $s;
	}
	
	function decode ($msg) {
		$s = "";
		for ($i = 0; $i < strlen($msg); $i +=2) 
			$s .= $this->tableau[strtoupper($msg[$i]).strtolower($msg[$i+1])];
		
		// Fractionate in chunks
		$s2 = "";
		for ($i = 0; $i <strlen($s); $i += $this->fraction)
			$s2 .= $this->rowtocolumntransposition(substr($s, $i, $this->fraction), $this->fraction / 3);
		
		// Reverse coding
		$s = "";
		for ($i = 0; $i < strlen ($s2); $i += 3)
			$s .= array_search( substr($s2, $i, 3), $this->tableau);

		return $s;
	}
	
} // digrafidcipher

?>
