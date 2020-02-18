<?php

namespace cipher;

class cmbifidcipher extends cipher {

	protected $cipher;	//square
	protected $period;
	
	public function __construct ($alphabet, $cipher = "", $period = 0) {
		parent::__construct ($alphabet);
		$this->cipher = $cipher;
		$this->period = $period;
	}
	
	public function getcipher() { return $this->cipher; }
	public function getperiod() { return $this->period; }
	public function setcipher($cipher) { $this->cipher = $cipher; }
	public function setperiod($period) { $this->period = $period; }
	
	function encode ($msg) {
		$s2 = "";

		while ($msg != "") {
			$chunk = substr ($msg, 0, $this->period);
			$msg = substr ($msg, $this->period);

			// Encode the chunk using alphabet
			$s = "";
			for ($i = 0; $i < strlen($chunk); $i++) {
				$pos = stripos ($this->alphabet, $chunk[$i]);
				if ($pos !== FALSE) {
					$row =intdiv($pos, 5);
					$col = $pos % 5;
					$s = $s . $row . $col;
				}
			}
			// Fractionate in two rows
			$s = $this->rowtocolumntransposition ($s, 2);
			// Translate using cipher
			for ($i = 0; $i < strlen($s); $i+=2) $s2 .= $this->cipher [ $s[$i]*5 + $s[$i+1]];
		}
		return $s2;
	}


	function decode ($msg) {

		$s2 = "";
		while ($msg != "") {
			$chunk = substr ($msg, 0, $this->period);
			$msg = substr ($msg, $this->period);

			// Decode the chunk using cipher
			$s = "";
			for ($i = 0; $i < strlen($chunk); $i++) {
				$pos = stripos ($this->cipher, $chunk[$i]);
				if ($pos !== FALSE) {
					$row =intdiv($pos, 5);
					$col = $pos % 5;
					$s = $s . $row . $col;
				}
			}

			// Fractionate in len / two rows
			$s = $this->rowtocolumntransposition ($s, strlen($s)/2);
			// Translate using alphabet
			for ($i = 0; $i < strlen($s); $i+=2) $s2 .= $this->alphabet [ $s[$i]*5 + $s[$i+1]];
		}
		return $s2;
	}

} // class cmbifid

?>