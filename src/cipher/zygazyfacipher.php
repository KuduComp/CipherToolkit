<?php

namespace cipher;

class zygazyfacipher extends cipher {

  // See http://anonim.ity.me.uk/ for an explanation
  // The cipher was created by Ray Crowther and used in one of his geocaches

	protected $key;
	protected $cipher;

	public function __construct ($alphabet, $key) {
		parent::__construct ($alphabet);
		$this->setkey ($key);
	}

	protected function nextcipher ($c) {
		$a = array();
		$len = strlen($c);
		for ($i = 0; $i < $len; $i++)
			$a[$this->strpos2($this->alphabet, $c[($i+1) % $len])] = $c[$i];
		ksort($a);
		return implode ("", $a);
	}

	public function setkey ($key) {
		$this->key = implode("", array_values (array_unique (str_split($key))));
		$cipher = $this->shufflealphabet($this->alphabet, $key);
		for ($i = 0; $i < strlen($this->key); $i++) {
			$cipher = $this->nextcipher ($cipher);
		}
		$this->cipher = $cipher;
	}

	public function getkey () { return $this->key; }

	public function encode ($msg = "") {
		$s = "";
		$cipher = $this->cipher;
		for ($i = 0; $i < strlen($msg); $i++) {
			$s .= $this->alphabet[$this->strpos2($cipher, $msg[$i])];
			$cipher = $this->nextcipher($cipher);
		}
		return $s;
	}

	public function decode ($msg = "") {
		$s = "";
		$cipher = $this->cipher;
		for ($i = 0; $i < strlen($msg); $i++) {
			$s .= $cipher[$this->strpos2($this->alphabet, $msg[$i])];
			$cipher = $this->nextcipher($cipher);
		}
		return $s;
	}

}

?>
