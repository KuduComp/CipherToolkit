<?php

namespace cipher;

// Constants
const UPPER_ALPHABET         = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
const UPPER_ALPHABET_REDUCED = "ABCDEFGHIKLMNOPQRSTUVWXYZ";
const LOWER_ALPHABET         = "abcdefghijklmnopqrstuvwxyz";
const NUMBER_ALPHABET        = "0123456789";
const MIXED_ALPHABET         = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
const ALPHANUMERIC_ALPHABET  = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
const ALPHABET_94            = "!\"#\$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^_`abcdefghijklmnopqrstuvwxyz{|}~";

// Abstract cipher class
// It provides all the standard functions
// In order to make it a working cipher the abstract encode and decode should be defined

abstract class cipher {
	
	protected $alphabet = "";		// The alphabet of characters than can be encoded
	protected $validcodes = "";	    // Characters that are valid in an encoded message
	protected $matchcase = FALSE;	// If matchcase is TRUE the input message is case sensitive
	protected $remove = TRUE;		// If remove is FALSE invalid characters in the input will be copied to the output
	protected $block = 0;	   		// Used to organize the output in blocks of n characters
	protected $sep = "";     		// Character used to separate blocks of output
	protected $repl = array();	    // Array of characters to be replaced with another i.e. I=J or U=V
	
	public function __Construct ($alphabet = UPPER_ALPHABET, $validcodes = "", $remove = TRUE, $block=0, $sep = "") {
		// Set all the variables
		$this->alphabet = $alphabet;
		$this->validcodes = $validcodes;
		$this->remove = $remove;
		$this->block = $block;
		$this->sep = $sep;
		$this->matchcase = ((strpos($alphabet,'a') !== FALSE) && (strpos($alphabet,'A') !== FALSE));
	}
	
	public function __Destruct () {}
	
	public function setalphabet ($alphabet) { $this->alphabet = $alphabet; }
	public function setvalidcodes ($validcodes) { $this->validcodes = $validcodes; }
	public function setmatchcase ($matchcase) { $this->matchcase = $matchcase; }
	public function setremove ($remove) { $this->remove = $remove; }
	public function setblock ($block) { $this->block = $block; }
	public function setsep ($sep) { $this->sep = $sep; }
	public function addReplacement ($c1, $c2) { if (array_key_exists($c1, $this->repl)) return; $this->repl[$c1] = $c2; }
	public function clearrepl () { $this->repl = array(); }

	public function getalphabet () { return $this->alphabet; }
	public function getvalidcodes () { return $this->validcodes; }
	public function getmatchcase () { return $this->matchcase; }
	public function getremove () { return $this->remove; }
	public function getblock () { return $this->block; }
	public function getsep () { return $this->sep; }
	public function getReplacement () { return $this->repl; }
	
	
	public function cleaninput ($msg, $removesep = TRUE) {
		// Replace characters if needed
		// Remove invalid characters if ignore == FALSE
		$s = "";
		for ($i = 0; $i < strlen($msg); $i++) {
		    if ($msg[$i] == $this->sep) {
		        if (!$removesep) $s .= $this->sep; 
		        continue;
	        }
			if (array_key_exists($msg[$i], $this->repl)) {
				// Match case should be included here
				$s .= $this->repl[$msg[$i]]; 
				continue;
			} elseif (!$this->matchcase && (array_key_exists (strtolower($msg[$i]), $this->repl) )) {
			    $s .= strtoupper($this->repl[strtolower($msg[$i])]);
			    continue;
			} elseif (!$this->matchcase && (array_key_exists (strtoupper($msg[$i]), $this->repl) )) {
		        $s .= strtolower($this->repl[strtoupper($msg[$i])]);
		        continue;
			}
			if (!$this->remove) {
				$s .= $msg[$i];
				continue;
			}
			if ($this->matchcase) {
				$pos = strpos($this->alphabet, $msg[$i]);
				if ($pos !== FALSE) $s .= $msg[$i];
			} else {
				$pos = stripos($this->alphabet, $msg[$i]);
				if ($pos !== FALSE) $s .= $msg[$i];
			};
		}
		return $s;
	}
	
	public function formatoutput ($msg) {
		// Organize the output in groups and separate with sep
		if ($this->block == 0) return $msg;
		$s = "";
		$i = 0;
		for ($i = 0; $i < strlen($msg); $i++) {
			if (($i % $this->block == 0) && ($i>0)) $s .= $this->sep;
			$s .= $msg[$i];
		}
		if ($s[strlen($s)-1] == $this->sep) $s = substr($s,0,-1);
		return $s;
	}
	
	public function cleanencodedmessage ($msg, $removesep = TRUE) {
		// This function removes all characters from message which are not valid
		// If validcodes is empty it only removes separators
		$s = "";
		for ($i=0; $i < strlen($msg); $i++) {
		    if ($msg[$i] == $this->sep) {
		        if (!$removesep) $s .= $this->sep;
		        continue;
		    }
		    if ($this->validcodes == "") continue;
			if ($this->matchcase) {
				$pos = strpos($this->validcodes, $msg[$i]);
				if ($pos !== FALSE) $s .= $msg[$i];
			} else {
				$pos = stripos($this->validcodes, $msg[$i]);
				if ($pos !== FALSE) $s .= $msg[$i];
			}
		}
		return $s;
	}
	

	// Helper function to create a reorganize a alphabet with a key
	public function shufflealphabet ($alphabet, $key) {
		return implode("", array_values (array_unique (array_merge (str_split($key), str_split($alphabet)))));
	}
	
	// Help function to position keeping in mind setting of matchcase
	public function strpos2 ($s, $c) {
	    if ($this->matchcase) 
	        return strpos($s,$c);
	    else
	        return stripos($s,$c);
	}
	
	// Below are placeholders for common cipher functions
	
	// Substitute replace each character in the input with something else
	// Polygraphic substitution replaces replaces two or more characters from the input
	// Polyalphabetic substitution uses multiple alphabets organized in a tableau
	public function simplesubstitution ($msg, $newalphabet) {
		// Replaces each character one on one with newalphabet
		if (strlen($this->alphabet) != strlen($newalphabet)) return "Invalid number of characters in cipher alphabet";
		// Take into account match case and keep case in encoded message the same
		$s="";
		for ($i=0; $i < strlen($msg); $i++) {
			$c = $msg[$i];
			// If match case do lookup
			if ($this->matchcase) {
				$pos = strpos($this->alphabet, $c);
				if (($pos !== FALSE) && ($this->remove)) 
					$s .= $newalphabet[$pos];
				else
					$s .= $c;
			} else {
				$pos = strpos(strtoupper($this->alphabet), strtoupper($c));
				if (($pos !== FALSE) && ctype_lower($c))
					$s .= strtolower($newalphabet[$pos]);
				elseif (($pos !== FALSE) && ctype_upper($c))
					$s .= strtoupper($newalphabet[$pos]);
				elseif ($pos !== FALSE)
					$s .= $newalphabet[$pos];	
				elseif (!$this->remove)
					$s .= $c;
			};
		}
		return $s;
	}
	
	// Transposing a message reorganizes the message
	// Transposing functions to be added	
	
    // Fractionation causes the codes for a single character to be spread across the message
	public function fractionate ($input = "", $nrows) {
	    
	    //Check input
	    if ($nrows < 0) return "Number of rows should be greater than zero";
	    if ($nrows > strlen($input)) return "Input message shorter than number of rows";
	    
	    //Initialize stuff
	    $a = array();
	    for ($i = 1; $i <= $nrows; $i++) $a[$i]="";
	    //Distribute across columns
	    $i=0;
	    while ($i < strlen ($input)) {
	        $row = 1;
	        while (($row <= $nrows) && ($i < strlen($input))) {
	            $a[$row] .= $input[$i];
	            $i++; $row++;
	        }
	    }
	    
	    //Print rows
	    $s="";
	    for ($i=1; ($i <= $nrows); $i++) $s .= $a[$i];
	    
	    return $s;
	}
	
	// Default
	abstract function encode ($text);	
	abstract function decode ($text);
	
} // End cipher


?>


