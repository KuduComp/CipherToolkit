<?php

namespace cipher;

class vatsyayanacipher extends cipher {

	protected $pair1 = "";
	protected $pair2 = "";
	protected $cipher;
	protected $numkeymap;
	protected $keysize  = 0;
	protected $sequence = array (2,1);
	protected $seqsize  = 2;

	public function __construct ($alphabet = UPPER_ALPHABET, $pair1 = "", $pair2 = "") {
		parent::__construct ($alphabet);
		$this->cipher = $this->setcipher ($pair1, $pair2);
	}

	public function setcipher ($pair1 = "", $pair2 = "") {

		// Check pairs
		if (strlen($pair1) != strlen($pair2)) return "";
		if ((2*strlen($pair1)) != strlen ($this->alphabet)) return "";

		// Generate substitution alphabet
		$ciphera = array();
		for ($i = 0; $i < strlen($pair1); $i++) {
			$ciphera[stripos($this->alphabet, $pair1[$i])] = $pair2[$i];
			$ciphera[stripos($this->alphabet, $pair2[$i])] = $pair1[$i];
		}
		ksort($ciphera);
		$cipher = implode("", array_unique($ciphera));

		// Check result
		if (strlen($cipher) != strlen($this->alphabet)) return "";
		return $cipher;
	}

	public function getcipher () { return array ($this->pair1, $this->pair2); }

	public function encode ($msg = "") { return $this->simplesubstitution ($msg, $this->cipher); }

    public function decode ($msg = "") { return $this->simplesubstitution ($msg, $this->cipher); }

} // vatsyayanacipher

?>
