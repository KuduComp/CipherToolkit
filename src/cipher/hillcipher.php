<?php

namespace cipher;

// Hill cipher
// First char in alphabet has 0
// Matrix nxn multiplied with vector n
// Matrix is n words of n characters, vector is n chars from msg
// Result vector is take modulo and translated back into char
// requires markbaker/matrix

require_once __DIR__ . '/../../vendor/autoload.php';

class hillcipher extends cipher {

	protected $keys;
	protected $keymat;
	protected $keyinv;  // inverse matrix
	protected $validinv;
	protected $sz;

	function __construct ($alphabet, $keys) {
		parent::__construct ($alphabet);
		$this->setkeys ($keys);
	}

	function modinvers ($a, $m) {   
        $a = $a % $m; 
        for ($x=1; $x < $m; $x++) 
           if (($a*$x) % $m == 1) 
              return $x;
        return 0;
    }
	
	function coprime ($n1, $n2) {
		while ($n1 != 0 && $n2 != 0) {
			if ($n1 > $n2)
				$n1 %= $n2;
			else
				$n2 %= $n1;
		}
		$gcd = max ($n1, $n2);
		return $gcd == 1;
	}
	
	function setkeys ($keys) {
		
		$this->keymat = array();
		$this->sz = sizeof($keys);
		$ky = -1;
		$mod = strlen($this->alphabet); 
		
		foreach ($keys as $k) {
			$this->keymat[++$ky] = array();
			for ($i = 0; $i < $this->sz; $i++) {
				$this->keymat[$ky][$i] = stripos ($this->alphabet, $k[$i]);
			}
		}
		
		// Calculate inverse matrix
		// See: https://crypto.interactive-maths.com/hill-cipher.html#3x3decypt
		// Step 1 find the determinant 
		$det = \Matrix\determinant($this->keymat);
		while ($det < 0) $det += $mod;
		$det = $det % $mod;
		
		// In order to be a usable key, the matrix must have a non-zero determinant 
		// which is coprime to the length of the alphabet.
		$this->validinv = ($det != 0) && $this->coprime($det,$mod);
		
		// find the multiplicative inverse of the determinant
		$multinvdet = $this->modinvers ($det, $mod);
		
		// Step 2 find adjugate (or adjoint)
		// % 26 for each of the matrix elements
		$adj = \Matrix\adjoint ($this->keymat);
		$a   = $adj->toArray();
		for ($r = 0; $r < $this->sz; $r++)
			for ($c = 0; $c < $this->sz; $c++) {
				while ($a[$r][$c] < 0) $a[$r][$c] += $mod;
				$a[$r][$c] = $a[$r][$c] % $mod;
			}
		
		// Step 3 multiply $adj with $multinvdet
		// % 26 for each of the matrix elements
		for ($r = 0; $r < $this->sz; $r++)
			for ($c = 0; $c < $this->sz; $c++) {
				$a[$r][$c] = $a[$r][$c] * $multinvdet;
				while ($a[$r][$c] < 0) $a[$r][$c] += $mod;
				$this->keyinv[$r][$c] = $a[$r][$c] % $mod;
			}
	}
   
	function getkeys () { return $this->keys; }

	function encode ($msg) {
		$s = "";
		$x = strlen($msg) % $this->sz;
		if ($x > 0) for ($i = 0; $i < ($this->sz - $x); $i++) $msg .= "X";
		while ($msg != "") {

			// Get chunk
			$v = substr($msg, 0, $this->sz);
			$msg = substr ($msg, $this->sz);
			$va = [];
			// Convert chunk to vector
			for ($i = 0; $i < strlen($v); $i++)
				$va[$i] = stripos ($this->alphabet, $v[$i]);
			
			// Multiply vector with matrix
			$m3 = \Matrix\multiply($this->keymat, $va);
			
			// Convert result vector backup to characters
			for ($i = 0; $i < $this->sz; $i++)
				$s .= $this->alphabet[$m3->getValue ($i+1, 1) % strlen($this->alphabet)];
		}
		return $s;
	}


	function decode ($msg) {
		
		if (!$this->validinv) return "Cannot decode message, unusable key";
		
		$m1 = new \Matrix\Matrix ($this->keymat);
		$m1 = \Matrix\inverse($m1);
		$s = "";
		
		while ($msg != "") {

			// Get chunk
			$v = substr($msg, 0, $this->sz);
			$msg = substr ($msg, $this->sz);
			$va = [];
			// Convert chunk to vector
			for ($i = 0; $i < strlen($v); $i++)
				$va[$i] = stripos ($this->alphabet, $v[$i]);
			
			// Multiply vector with inverse matrix
			$m3 = \Matrix\multiply($this->keyinv, $va);
			
			// Convert result vector backup to characters
			for ($i = 0; $i < $this->sz; $i++)
				$s .= $this->alphabet[$m3->getValue ($i+1, 1) % strlen($this->alphabet)];
		}
		return $s;
	}

} // class



?>
