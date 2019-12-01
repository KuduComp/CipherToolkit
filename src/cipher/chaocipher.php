<?php

namespace cipher;

class chaocipher extends cipher {
	
	// ChaoCipher : Simulation of Chaocipher enciphering/deciphering
	// ChaoCipher is a polyalphabetic cipher with continuously changing alphabets
	// Chaocipher is a method of encryption invented by John F. Byrne in 1918, 
	// who tried unsuccessfully to interest the US Signal Corp and Navy in his system. 
	// In 1954, Byrne presented Chaocipher-encrypted messages as a challenge in his 
	// autobiography “Silent Years”. Although numerous students of cryptanalysis attempted 
	// to solve the challenge messages over the years, none succeeded. Chaocipher has been 
	// a closely guarded secret known only to a handful of persons. Following fruitful 
	// negotiations with the Byrne family during the period 2009-2010, the Chaocipher papers and materials have been donated to the National Cryptologic Museum in Ft. Meade, MD.

	protected $startleft  = "ABCDEFMNOPQRSGHIJKLTUVWXYZ";
	protected $startright = "PQRSTUVWXYZABCDEKLMNOFGHIJ";
	
	public function __construct ($alphabet, $left, $right) {
		parent::__construct ($alphabet);
		$this->startleft = $left;
		$this->startright = $right;
	}
	
	protected function bringToZenith ($alphabet, $letter)	{
		# Bring letter to zenith position
		$index = strpos ($alphabet, $letter);
		return array($this->rotate ($alphabet, $index), $index);
	}
		
	protected function rotate ($alphabet, $shift) {
		# Rotate alphabet N positions counterclockwise
		return ($shift > 0) ? substr ($alphabet, $shift) . substr ($alphabet, 0, $shift) : $alphabet;
	}
		
	protected function permute ($alphabet, $offset) {
		# Generic Chaocipher alphabet permutation
		return substr ($alphabet, 0, $offset) . substr ($alphabet, $offset+1, 13-$offset) .
			   substr ($alphabet, $offset, 1) . substr ($alphabet, 14);
	}

	public function decode ($msg) {

		$ct = $msg;
		$pt = "";
		$len = strlen($msg);
		$left = $this->startleft;
		$right = $this->startright;

		for ($i=0; $i<$len; ++$i) {

			# Decipher ciphertext letter
			$c = $ct[$i];
			$a = $this->bringToZenith ($left, $c);
			$left = $a[0];
			$shift = $a[1];
			$right = $this->rotate ($right, $shift);
			$p = $right[0];
			$pt .= $p;
				
			# Permute alphabets
			$left = $this->permute ($left, 1);
			$right = $this->rotate ($right, 1);
			$right = $this->permute ($right, 2);
		}
		return $pt;
	}

	public function encode ($msg) {

		$pt = $msg;
		$ct = "";
		$len = strlen($msg);
		$left = $this->startleft;
		$right = $this->startright;
		
		for ($i=0; $i<$len; ++$i) {
			# Encipher plaintext letter
			$p = $pt[$i];
			$a = $this->bringToZenith ($right, $p);
			$right = $a[0];
			$shift = $a[1];
			$left = $this->rotate ($left, $shift);
			$c = $left[0];
			$ct .= $c;

			# Permute alphabets
			$left = $this->permute ($left, 1);
			$right = $this->rotate ($right, 1);
			$right = $this->permute ($right, 2);
		}
		return $ct;
	}
} // chaocipher
