<?php

class trisquarecipher {

	protected $sq1, $sq2, $sq3 = "ABCDKLMNOEFGHIPQRSTUVWXYZ";
	protected $sz  = 5;
	
	public function __construct ($alphabet, $sq1, $sq2, $sq3) {
	    $this->setsquares ($sq1, $sq2, $sq3);
	}
    public function setsquares ($sq1, $sq2, $sq3) {
	    $this->sq1 = $sq1;
	    $this->sq2 = $sq2;
	    $this->sq3 = $sq3;
	    $this->size = (integer) ceil(sqrt(strlen($sq1)));
	}
	
	public function getsquares () { return array ($this->sq1, $this->sq2, $this->sq3); }

	public function encode ($msg) {

		if (strlen($msg) % 2 == 1) $msg .= "X";
		$s = "";
		for ($i = 0; $i < strlen($msg); $i+=2) {
			// Take first character and find column in sq1
			// Row is random
			$c1 = stripos ($this->sq1, $msg[$i]) % $this->sz;
			$r1 = intdiv (stripos ($this->sq1, $msg[$i]), $this->sz);
			$ra = rand (0, $this->sz - 1);
			// Take the 2nd character and find row in sq2
			// Col is random
			$ca = rand (0, $this->sz - 1);
			$c2 = stripos ($this->sq2, $msg[$i+1]) % $this->sz;
			$r2 = intdiv (stripos ($this->sq2, $msg[$i+1]), $this->sz);
			$s = $s . $this->sq1[ $ra * $this->sz + $c1] .
				      $this->sq3[ $r1 * $this->sz + $c2] .
				      $this->sq2[ $r2 * $this->sz + $ca];

		}
		return $s;
	}

	public function decode ($msg) {
		if (strlen($msg) % 3 != 0) return "Invalid message";
		$s = "";
		for ($i = 0; $i < strlen($msg); $i += 3) {
			$c1 = stripos ($this->sq1, $msg[$i]) % $this->sz;
			$r2 = intdiv (stripos ($this->sq2, $msg[$i+2]), $this->sz);
			$c3 = stripos ($this->sq3, $msg[$i+1]) % $this->sz;
			$r3 = intdiv (stripos ($this->sq3, $msg[$i+1]), $this->sz);
			$s = $s . $this->sq1 [$r3 * $this->sz + $c1] . $this->sq2 [$r2 * $this->sz + $c3];
		}
		return $s;
	}

} // class trisquarecipher

?>
