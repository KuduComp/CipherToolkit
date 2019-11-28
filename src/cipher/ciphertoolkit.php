<?php

namespace cipher;

use phpDocumentor\Reflection\Types\Null_;

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
	    return implode("", array_values (array_unique (str_split($key . $alphabet))));
	}
	
	// Help function to position keeping in mind setting of matchcase
	public function strpos2 ($s, $c) {
	    if ($this->matchcase) 
	        return strpos($s,$c);
	    else
	        return stripos($s,$c);
	}
	
	// Help function to translate a msg (mixed type) into an array
	public function makearray ($msg, $sequence = null) {
    
		switch (gettype($msg)) {
		    case "array"    : $a = $msg; break;
		    case "integer"  : $s = sprintf("%d", $msg);
		    case "string"   : 
		        $s = $msg;
		        if (!is_array($sequence))
		            $a = str_split ($s);
		        else {
		            // Cut string into bits as specified in sequence e.g. (1,2) alternates between 1 and 2 char chunks
		            $a = array();
		            $seq = 0;
		            while (strlen($s) > 0) {
		                $a[] = substr($s, 0, $sequence[$seq % sizeof($sequence)]);
		                $s   = substr($s, $sequence[$seq % sizeof($sequence)]);
		                $seq++;
		            }
		        }
		        break;
			default : return null;
		}
		return $a;
	}
	
	// Below are placeholders for common cipher functions
	
	// Substitute replace each character in the input with something else
	// Polygraphic substitution replaces replaces two or more characters from the input
	// Polyalphabetic substitution uses multiple alphabets organized in a tableau
	public function simplesubstitution ($msg, $newalphabet) {
		
		// Replaces each character one on one with newalphabet
		if (strlen($this->alphabet) != strlen($newalphabet)) return "Invalid number of characters in cipher alphabet";
		if ($msg == "") return "Nothing to encode or decode";
		
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
	
	public function arraysubstitution ($msgtxt, $repl = null) {
		
		// Checks
		if ($repl == null) return "Empty replacement table";
		if (gettype($repl) != "array") return "No replacement table specified, not an array";
		if ($msgtxt == "") return "Nothing to encode or decode";
		
		// Translate message into an array
		$msg = $this->makearray($msgtxt);
		
		// Replace each element in message
		$s = "";
		foreach ($msg as $m) {
			// Try to find m
			if (array_key_exists($m, $repl)) {
				// Match
				$s = $s . $repl[$m] . $this->sep;
			} elseif ($this->matchcase) {
				// Case match didn't result in find
				if (!$this->remove) $s = $s . $m . $this->sep;
			} elseif (array_key_exists(strtoupper($m), $repl)) {
				// Uppercase was a match
				$s = $s . strtolower($repl[strtoupper($m)]) . $this->sep;
			} elseif (array_key_exists(strtolower($m), $repl)) {
				// Lowercase was a match
				$s = $s. strtoupper($repl[strtolower($m)]) . $this->sep;
			} else {
				// None of the case matched
				if ($this->remove) $s = $s . $m . $this->sep;
			}
		}
		
		// Return result
		if ($s[strlen($s) - 1] == $this->sep) $s = substr ($s,0,-1);
		return $s;
	}
	
	// Transposing a message reorganizes the message
	
	public function createtranspositionkey ($s) {
	    
	    // Creates array of integers e.g. 2,1,0 reorders columns as 0,1,2
	    // $key[1] = 4; means column 1 becomes column 4
	    switch (gettype($s)) {
	        case "array"    : return $s;
	        case "integer"  : $s = sprintf("%d", $s); break;
	        case "string"   : break;
	        default         : return null;
	    }
	    
	    $tmparr = array();
	    $len = strlen($s);
	    for ($i = 0; $i<$len; $i++) {
	        $tmparr[$i] = $s[$i] . sprintf("%04d",$i);
	    }
	    sort ($tmparr);
	    $a = array();
	    for ($i = 0; $i<$len; $i++) $a[$i] = array_search ($s[$i] . sprintf("%04d",$i), $tmparr);
	    return $a;  
	}
	
	public function encodecolumnartransposition ($msgtxt, $key) {
    
		// Message can be a text string, a number or an array
		// For transposition an array is used as elements might have different length (e.g. amsco cipher)
		// Key should be an array of integers e.g. 2,1,0 reorders columns as 0,1,2
	    	
		// check stuff
		if ($key == null) return "No key square specified, empty";
		if (gettype($key) != "array") return "No key specified, not an array";
	    	$ncol = sizeof($key);
		if ($ncol < 2) return "Cannot decode message there should be at least two columns";
		
		$msg      = $this->makearray($msgtxt);
		$msglen   = sizeof($msg);
		if ($msglen == 0) return "Nothing to encode";
		$nrow     = (int) ceil ($msglen / $ncol);
		$nlongcol = $msglen % $ncol;        
		
		// Write message row after row in array table
		$table = array();
		$idx = 0;
		for ($r = 0; $r < $nrow; $r++) {
		    (($r == ($nrow-1)) && ($nlongcol != 0)) ? $rowlen = $nlongcol : $rowlen = $ncol;
		    for ($c = 0; $c < $rowlen; $c++) {
				$table[$r][$c] = $msg[$idx++];
			}
		}

		// Write output column after colum in array table, taking into account order of key
		$s = "";
		for ($c = 0; $c < $ncol; $c++) {
		    $col = array_search ($c, $key);
		    (($col < $nlongcol) || ($nlongcol == 0)) ? $collen = $nrow : $collen = $nrow - 1;
		    for ($r = 0; $r < $collen; $r++) {
				$s .= $table[$r][$col];
			}
		}
		return $s;
	}

	public function decodecolumnartransposition ($msgtxt, $key) {

		// check stuff
		if ($key == null) return "No key square specified, empty";
		if (gettype($key) != "array") return "No key specified, not an array";
	    	$ncol = sizeof($key);
		if ($ncol < 2) return "Cannot decode message there should be at least two columns";
		
		$msg  = $this->makearray($msgtxt);
		$msglen = sizeof($msg);
		if ($msglen == 0) return "Nothing to decode";
		$nrow = ceil ($msglen / $ncol);
        	$nlongcol = $msglen % $ncol;

		// Write message column after column in array table
		$table = array();
		$idx = 0;
		for ($c = 0; $c < $ncol; $c++) {
			$col = array_search($c, $key);
			(($col < $nlongcol) || ($nlongcol == 0)) ? $rowlen = $nrow : $rowlen = $nrow  - 1;
			for ($r = 0; $r < $rowlen; $r++) $table[$r][$col] = $msg[$idx++];
		}
        
		// Write output row after row in array table, taking into account order of key
		$s = "";
		for ($r = 0; $r < $nrow; $r++) {
		    (($r == ($nrow-1)) && ($nlongcol != 0)) ? $collen = $nlongcol : $collen = $ncol;
		    for ($c = 0; $c < $collen; $c++)
		        $s .= $table[$r][$c];
		}
		
		return $s;
	}

	public function encodeswagmantransposition ($msgtxt = "", $keysquare = null) {

		// Key is an array of arrays with indexes starting at 1, 2, 3, ...
		
		// check stuff
		if ($keysquare == null) return "No key square specified, empty";
		if (gettype($keysquare) != "array") return "No key square specified, not an array";
		$keysquaresize = sizeof($keysquare);
		if (!array_key_exists(1, $keysquare)) return "No key square specified, 1st row is missing";
		if ($keysquaresize != sizeof($keysquare[1])) return "Key square is not a square";

		$msg      = $this->makearray($msgtxt);
		$msglen   = sizeof($msg);
		if ($msglen == 0) return "Nothing to encode";

		//Append message with random characters if needed
		for ($i = 0; $i < ($msglen % $keysquaresize); $i++) $msg .= "X";
		$rowlen = (integer) ceil($msglen / $keysquaresize);

		// Organize message in keysize rows
		$s = array();
		for ($c = 0; $c < $keysquaresize; $c++) {
			$s[$c+1] = "";
			for ($r = 0; $r < $rowlen; $r++)
				$s[$c+1] .= $msg[$c * $rowlen + $r];
		}

		// Create mapping for each column
		$map = array();
		for ($c = 0; $c < $this->keysquaresize; $c++) {
			$map[$c] = array();
			for ($r = 0; $r < $keysquaresize; $r++)
				$map[$c][$r+1] = $keysquare[$r+1][$c];
		}

		// For each column reorder and print
		$s2 = "";
		for ($c = 0; $c < $rowlen; $c++) {
			$keycol = ($c % $keysquaresize);
			for ($r = 0; $r < $keysquaresize; $r++)
				$s2 .= $s[array_search($r+1, $map[$keycol])][$c];
		}
		return $s2;
	}

	public function decodeswagmantransposition ($msgtxt = "", $keysquare = null) {

		// check stuff
		if ($keysquare == null) return "No key square specified, empty";
		if (gettype($keysquare) != "array") return "No key swuare specified, not an array";
		$keysquaresize = sizeof($keysquare);
		if (!array_key_exists(1, $keysquare)) return "No key square specified, 1st row is missing";
		if ($keysquaresize != sizeof($keysquare[1])) return "Key square is not a square";
		
		$msg      = $this->makearray($msgtxt);
		$msglen   = sizeof($msg);
		if ($msglen == 0) return "Nothing to encode";
		if (($msglen % $keysquaresize) != 0) return "Incorrect message length";

		// Create mapping for each column
		$map = array();
		for ($c = 0; $c < $keysquaresize; $c++) {
			$map[$c] = array();
			for ($r = 0; $r < $keysquaresize; $r++)
				$map[$c][$r+1] = $keysquare[$r+1][$c];
		}

		// Init table
		$s = array();
		for ($r = 0; $r < $keysquaresize; $r++) $s[$r+1] = array();

		// Print message in columns
		$rowlen = (integer) ceil($msglen / $keysquaresize);
		$idx = 0;
		for ($c = 0; $c < $rowlen; $c++) {
			$keycol = ($c % $keysquaresize);
			for ($r = 0; $r < $keysquaresize; $r++)
				$s[array_search($r+1, $map[$keycol])][$c] = $msg[$idx++];
		}
		
		// Print message
		$s2 = "";
		for ($r = 0; $r < $keysquaresize; $r++)
			for ($c = 0; $c < $rowlen; $c++)
				$s2 .= $s[$r+1][$c];

		return $s2;
	}
	
	function encodenihilisttransposition ($msgtxt = "", $key, $readrow = TRUE) {

		// NIHILIST TRANSPOSITION (10x10 maximum)
		// The same key is applied to rows and columns.
		// Enter the plaintext in square 1 by rows as shown. Transpose columns by key order
		// into square 2. Transpose rows of square 2 by key order into square 3. The ciphertext
		// is taken off by columns or rows from square 3.
		
		// Key should be an array with index starting at 0, 1, 2, ....
		
		// check stuff
		if ($key == null) return "No key specified, empty";
		if (gettype($key) != "array") return "No key specified, not an array";
		$msg      = $this->makearray($msgtxt);
		$msglen   = sizeof($msg);
		if ($msglen == 0) return "Nothing to encode";
		$size = sizeof($key);
		if ($msglen != $size**2) return "Message not a sqyuare";

		// Fill square
		$table = array();
		for ($r = 0; $r < $size; $r++) {
			$table[$r] = array ();
			for ($c = 0; $c < $size; $c++) $table[$r][$c] = $msg[$r * $size + $c];
		}
		// Transpose columns
		$table2 = array();
		for ($r = 0; $r < $size; $r++) {
			$table2[$r] = array ();
			for ($c = 0; $c < $size; $c++) $table2[$r][$key[$c]] = $table[$r][$c];
		}
		// Transpose rows
		$table3 = array();
		for ($r = 0; $r < $size; $r++) $table3[$r] = array();
		for ($r = 0; $r < $size; $r++) {
			for ($c = 0; $c < $size; $c++) $table3[$key[$r]][$c] = $table2[$r][$c];
		}
		// Print row after row or column after column
		$s = "";
		for ($r = 0; $r < $size; $r++)
			for ($c = 0; $c < $size; $c++) 
			    ($readrow) ? $s .= $table3[$r][$c] :  $s .= $table3[$c][$r];
		// Return result
		return $s;

	}
	
	function decodenihilisttransposition ($msgtxt, $key, $readrow = TRUE) {

		// check stuff
		if ($key == null) return "No key specified, empty";
		if (gettype($key) != "array") return "No key specified, not an array";
		$size = sizeof($key);
		$msg      = $this->makearray($msgtxt);
		$msglen   = sizeof($msg);
		if ($msglen == 0) return "Nothing to encode";
		if ($msglen != $size**2) return "Message not a sqyuare";
		
		// Fill square
		$table = array();
		$size = sizeof($key);
		for ($r = 0; $r < $size; $r++) $table[$r] = array();
		for ($r = 0; $r < $size; $r++) {
			$table[$r] = array ();
			for ($c = 0; $c < $size; $c++) 
				($readrow) ? $table[$r][$c] = $msg[$r * $size + $c] : $table[$c][$r] = $msg[$r * $size + $c];
		}
		
		// Transpose rows
		$table2 = array();
		for ($r = 0; $r < $size; $r++) $table2[$r] = array();
		for ($r = 0; $r < $size; $r++) {
			for ($c = 0; $c < $size; $c++) $table2[$key[$r]][$c] = $table[$r][$c];
		}

		// Transpose columns
		$table3 = array();
		for ($r = 0; $r < $size; $r++) $table3[$r] = array();
		for ($r = 0; $r < $size; $r++) {
			for ($c = 0; $c < $size; $c++) $table3[$r][$key[$c]] = $table2[$r][$c];
		}
		
		// Print row after row
		$s = "";
		for ($r = 0; $r < $size; $r++)
			for ($c = 0; $c < $size; $c++) 
			    $s .= $table3[$r][$c];
		
		// Return result
		return $s;

	}
	
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
	
	// Default functions must always be implemented
	abstract function encode ($text);	
	abstract function decode ($text);
	
} // End cipher


?>
