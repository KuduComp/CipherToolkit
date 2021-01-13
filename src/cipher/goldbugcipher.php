<?php

namespace cipher;

// Classic caesar cipher, default using standard alphabet and ROT13
class goldbugcipher extends cipher {
	
	protected $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	protected $goldbugalphabet = "52-†81346,709*‡.$();?¶]¢:[";
 
	function encode ($msg) {

		$s = "";
		for ($i = 0; $i < strlen($msg); $i++) {
			$pos = stripos ($this->alphabet, $msg[$i]);
			if ($pos !== FALSE)
						$s .= mb_substr( $this->goldbugalphabet, $pos, 1);
			else
				if (!$this->remove) $s .= $msg[$i];
		}
		return $s;
	}
		 
	function decode ($msg) {
		
		$s = "";
		for ($i = 0; $i < mb_strlen($msg); $i++) {
			$pos = mb_stripos ($this->goldbugalphabet, mb_substr($msg, $i, 1));
			if ($pos !== FALSE)
				$s .= $this->alphabet[$pos];
			else
				if (!$this->remove) $s .= mb_substr ($msg, $i, 1);
		}
		return $s;
	}
 
} // Goldbugcipher

?>

