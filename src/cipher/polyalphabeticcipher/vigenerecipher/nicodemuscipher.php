<?php

namespace cipher\polyalphabeticcipher\vigenerecipher;

class nicodemuscipher extends \cipher\polyalphabeticcipher\vigenerecipher {

	// Three steps are used:
	// 1. Column transposition.
	// 2. Vigenère encipherment with the same key.
	// 3. Take off 5 letters at a time from each column in order


	protected $key = "";
	protected $keyarr = null;
	
	public function __construct ($alphabet, $key) {
		parent::__construct($alphabet, $key);
		$this->setkey($key);
	}
	
	public function setkey($key) {
		$this->key = $key;
		$this->keyarr = $this->createtranspositionkey ($key);
	}
	
	public function getkey() { return $this->key; }

	public function encode ($msg) {
		
		// Checks
		if ($this->key == "") return "No key specified";
		if ($this->keyarr == null) return "No key specified";
		if ($msg == "") return "Nothing to encode";

		$m1 = parent::encode($msg);
		$s = "";
		$block = 5 * sizeof($this->keyarr);

		while (strlen($m1) >0) {
			$m2 = substr($m1,0,$block);
			$m1 = substr($m1,$block);
			$m3 = $this->encodecolumnartransposition($m2, $this->keyarr);
			$s .= $m3;
		}
		return $s;
	}

	public function decode ($msg) {

		// Checks
		if ($this->key == "") return "No key specified";
		if ($this->keyarr == null) return "No key specified";
		if ($msg == "") return "Nothing to encode";

		$s = "";
		$block = 5 * sizeof($this->keyarr);
		while (strlen($msg) >0) {
			$m = substr($msg,0,$block);
			$msg = substr($msg,$block);
			$m3 = $this->decodecolumnartransposition($m, $this->keyarr);
			$s .= $m3;
		}

		$s = parent::decode($s);

		return $s;
	}

}  // nicodemuscipher
