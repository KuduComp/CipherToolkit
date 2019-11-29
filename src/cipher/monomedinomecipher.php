<?php

namespace cipher;

class monomedinomecipher extends cipher {
	
	protected $key1;
	protected $key2;
	protected $board;
	
	public function __construct ($alphabet = "ABCDEFGHIKLMNOPQRSTUVWXY", $key1 = "", $key2 = ""){
		parent::__construct ($alphabet);
		$this->setkeys ($key1, $key2);
	}

	public function setkeys ($keyalphabet = "", $key = "") {
		
		// Alphabet must be 24 char's, key2 at least 10 char's
		$this->key1 = $keyalphabet;
		$this->key2 = $key;
		$keyboard = $this->createtranspositionkey (substr($key,0,10));
		
		$a = $this->shufflealphabet ($this->alphabet, $keyalphabet);
		$this->board = array();
		for ($r=0; $r<3; $r++) {
			if ($r == 0) $row = 0;
			if ($r == 1) $row = ($keyboard[0] + 1) % 10;
			if ($r == 2) $row = ($keyboard[1] + 1) % 10;
            for ($c = 2; $c <=9; $c++) {
				$n = $row * 10 + (($keyboard[$c] + 1) %10);
				$this->board[$a[$r * 8 + $c - 2]] = sprintf ("%d", $n);
			}
		}
	}

	public function getkeys () { return array(key1, key2); }
	
	public function encode($msg = "") {
		return $this->arraysubstitution ($msg, $this->board);
	}
	
	public function decode ($msg = "") {
		$s = "";
		$msgarr = array();
		$keyboard = $this->createtranspositionkey (substr($this->key2,0,10));
		$p1 = (string) ($keyboard[0]+1) % 10;
		$p2 = (string) ($keyboard[1]+1) % 10;
		
        for ($i = 0; $i < strlen($msg); $i++) {
			$c = $msg[$i];
			if (($c == $p1) || ($c == ($p2))) $c .= $msg[++$i];
			$msgarr[] = $c;
        }
		
        return $this->arraysubstitution ($msgarr, array_flip($this->board)); 
	}
	
} // monomedinomecipher

?>