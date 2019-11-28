<?php

namespace cipher;

class genericsubstitutioncipher extends cipher {

	protected $cipher;
	protected $numkeymap;
	protected $keysize  = 0;
	protected $sequence = array (2,1);
	protected $seqsize  = 2;

	public function __construct ($alphabet = UPPER_ALPHABET, $cipher = null) {
		parent::__construct ($alphabet);
		$this->cipher = $cipher;
	}

	public function getcipher () { return $this->cipher; }

	public function encode ($msg = "") { return $this->simplesubstitution ($msg, $this->cipher); }

    public function decode ($msg = "") { 
		$mem = $this->getalphabet();
		$this->setalphabet ($this->cipher);
		$res = $this->simplesubstitution ($msg, $mem);
		$this->setalphabet ($mem);
		return $res;
	}

} // genericsubstitutioncipher

?>
