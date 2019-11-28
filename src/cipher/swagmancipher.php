<?php

namespace cipher;

class swagmancipher extends cipher {

	// A simple transposition cipher

	protected $keysquare;
	protected $keysquaresize;

	public function __construct ($alphabet = UPPER_ALPHABET, $keysquare = null) {
		parent::__construct ($alphabet);
		$this->setkeysquare ($keysquare);
	}
	
	public function setkeysquare ($ks = null) {
		if ($ks == null) return;
		$this->keysquare = $ks;
		$this->keysquaresize = sizeof ($ks);
	}

	public function getkeysquare() { return $this->keysquare; }

	public function encode ($msg) { return $this->encodeswagmantransposition ($msg, $this->keysquare); }
	public function decode ($msg) { return $this->decodeswagmantransposition ($msg, $this->keysquare); }
	
} // swagmancipher

?>