<?php

namespace cipher;

use phpDocumentor\Reflection\Types\Null_;

// Constants
const UPPER_ALPHABET         = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
const UPPER_ALPHABET_REDUCED = "ABCDEFGHIKLMNOPQRSTUVWXYZ";
const LOWER_ALPHABET         = "abcdefghijklmnopqrstuvwxyz";
const LOWER_ALPHABET_REDUCED = "abcdefghiklmnopqrstuvwxyz";
const NUMBER_ALPHABET        = "0123456789";
const MIXED_ALPHABET         = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
const ROMAN_NUMBERS          = "IVXLDCM";
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
	
	// Help function to create a reorganized alphabet using a key
	public function shufflealphabet ($alphabet, $key) {
	    return implode("", array_values (array_unique (str_split($key . $alphabet))));
	}
	
	// Help function to position in string keeping in mind setting of matchcase
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
	
	// Help function to create a square with various options, default is the default Polybius square
	// returns a string
	function fillsquare ($text = UPPER_ALPHABET_REDUCED, $dir = "HOR", $c = "TL", $flip = FALSE) {

	    $size = (int) sqrt(strlen($text));
	    if ($size ** 2 != strlen($text)) return "Not a square";
	    $dir = strtoupper ($dir);
	    $c = strtoupper ($c);
	    
		$idx = 0;
	    $fliprow = $flip;

	    switch ($dir) {

			case "DIAH" :
				for ($i = 0; $i < $size; $i++) {
				for ($j = 0; $j <= $i; $j++) {
					if (!$fliprow) {
						if ($c == "TL") $sq[$j][$i-$j] = $text[$idx++];
						if ($c == "TR") $sq[$j][$size - $i - 1 + $j] = $text[$idx++];
						if ($c == "BL") $sq[$size - $j - 1][$i - $j] = $text[$idx++];
						if ($c == "BR") $sq[$size - 1 - $j][$size - $i - 1 + $j] = $text[$idx++];
					} else {
						if ($c == "TL") $sq[$i-$j][$j] = $text[$idx++];
						if ($c == "BL") $sq[$size - $i - 1 + $j][$j] = $text[$idx++];
						if ($c == "TR") $sq[$i - $j][$size - $j - 1] = $text[$idx++];
						if ($c == "BR") $sq[$size - $i - 1 + $j][$size - 1 - $j] = $text[$idx++];
					}
				}
				if ($flip) $fliprow = !$fliprow;
				}

				for ($i = 1; $i < $size; $i++) {
				for ($j = 0; $j < $size - $i; $j++) {
					if (!$fliprow) {
						if ($c == "TL") $sq[$i+$j][$size-$j-1] = $text[$idx++];
						if ($c == "TR") $sq[$i+$j][$j] = $text[$idx++];
						if ($c == "BL") $sq[$size - $i - 1 - $j][$size - $j - 1] = $text[$idx++];
						if ($c == "BR") $sq[$size - $i - 1 - $j][$j] = $text[$idx++];
					} else {
						if ($c == "TL") $sq[$size-$j-1][$i+$j] = $text[$idx++];
						if ($c == "BL") $sq[$j][$i+$j] = $text[$idx++];
						if ($c == "TR") $sq[$size - $j - 1][$size - $i - 1 - $j] = $text[$idx++];
						if ($c == "BR") $sq[$j][$size - $i - 1 - $j] = $text[$idx++];
					}
				}
				if ($flip) $fliprow = !$fliprow;
				}
				break;

			case "DIAV" :
				for ($i = 0; $i < $size; $i++) {
				for ($j = 0; $j <= $i; $j++) {
					if (!$fliprow) {
						if ($c == "TL") $sq[$i-$j][$j] = $text[$idx++];
						if ($c == "BL") $sq[$size - $i - 1 + $j][$j] = $text[$idx++];
						if ($c == "TR") $sq[$i - $j][$size - $j - 1] = $text[$idx++];
						if ($c == "BR") $sq[$size - $i - 1 + $j][$size - 1 - $j] = $text[$idx++];
					} else {
						if ($c == "TL") $sq[$j][$i-$j] = $text[$idx++];
						if ($c == "TR") $sq[$j][$size - $i - 1 + $j] = $text[$idx++];
						if ($c == "BL") $sq[$size - $j - 1][$i - $j] = $text[$idx++];
						if ($c == "BR") $sq[$size - 1 - $j][$size - $i - 1 + $j] = $text[$idx++];
					}
				}
				if ($flip) $fliprow = !$fliprow;
				}

				for ($i = 1; $i < $size; $i++) {
				for ($j = 0; $j < $size - $i; $j++) {
					if (!$fliprow) {
						if ($c == "TL") $sq[$size-$j-1][$i+$j] = $text[$idx++];
						if ($c == "BL") $sq[$j][$i+$j] = $text[$idx++];
						if ($c == "TR") $sq[$size - $j - 1][$size - $i - 1 - $j] = $text[$idx++];
						if ($c == "BR") $sq[$j][$size - $i - 1 - $j] = $text[$idx++];
					} else {
						if ($c == "TL") $sq[$i+$j][$size-$j-1] = $text[$idx++];
						if ($c == "TR") $sq[$i+$j][$j] = $text[$idx++];
						if ($c == "BL") $sq[$size - $i - 1 - $j][$size - $j - 1] = $text[$idx++];
						if ($c == "BR") $sq[$size - $i - 1 - $j][$j] = $text[$idx++];
					}
				}
				if ($flip) $fliprow = !$fliprow;
				}
				break;

			case "HOR" :
				for ($i = 0; $i < $size; $i++) {
					if ($flip) $fliprow = !$fliprow;
					for ($j = 0; $j < $size; $j++) {
						if (!$fliprow) {
							if ($c == "TL") $sq[$i][$j] = $text[$idx++];
							if ($c == "TR") $sq[$i][$size - $j - 1] = $text[$idx++];
							if ($c == "BL") $sq[$size - $i - 1][$j] = $text[$idx++];
							if ($c == "BR") $sq[$size - $i - 1][$size - $j - 1] = $text[$idx++];
						} else {
							if ($c == "TL") $sq[$i][$size - $j - 1] = $text[$idx++];
							if ($c == "TR") $sq[$i][$j] = $text[$idx++];
							if ($c == "BL") $sq[$size - $i - 1][$size - $j - 1] = $text[$idx++];
							if ($c == "BR") $sq[$size - $i - 1][$j] = $text[$idx++];
						}
					}
				}
				break;

			case "VER" :
				for ($i = 0; $i < $size; $i++) {
					if ($flip) $fliprow = !$fliprow;
					for ($j = 0; $j < $size; $j++) {
						if (!$fliprow) {
							if ($c == "TL") $sq[$j][$i] = $text[$idx++];
							if ($c == "TR") $sq[$j][$size - $i - 1] = $text[$idx++];
							if ($c == "BL") $sq[$size - $j - 1][$i] = $text[$idx++];
							if ($c == "BR") $sq[$size - $j - 1][$size - $i - 1] = $text[$idx++];
						} else {
							if ($c == "TL") $sq[$size - $j - 1][$i] = $text[$idx++];
							if ($c == "TR") $sq[$size - $j - 1][$size - $i - 1] = $text[$idx++];
							if ($c == "BL") $sq[$j][$i] = $text[$idx++];
							if ($c == "BR") $sq[$j][$size - $i - 1] = $text[$idx++];
						}
					}
				}
				break;

			case "SI" :
				// Spiral inwards start at specified corner and rotate towards center
			   if (!$flip) {

					//Clockwise
					$corners = array ("TL", "TR", "BR", "BL");
					$loop = 0;
					for ($i = $size - 1; $i >= 0; $i -=2) {
						for ($cs = 0; $cs < 4; $cs++) {
							$ct = $corners [($cs + array_search($c, $corners)) % 4];
							for ($j = 0; $j < $i; $j++) {
								//echo $ct, $i, $j, "\tLoop:", $loop, "\n";
								if ($ct == "TL") $sq[$size - $i - 1 - $loop][$j + $loop] = $text[$idx++];  
								if ($ct == "TR") $sq[$j+$loop][$i + $loop] = $text[$idx++];  
								if ($ct == "BR") $sq[$i + $loop][$size - $j - 1 - $loop] = $text[$idx++];  
								if ($ct == "BL") $sq[$size - $j - 1 - $loop][$size - $i - 1 - $loop] = $text[$idx++];
							}
						}
						$loop++;
					}
					if ($size % 2 == 1) $sq[intdiv($size,2)][intdiv($size,2)] = $text[$idx++];

				} else {

					// Counterclockwise
					$corners = array ("TL", "BL", "BR", "TR");
					$loop = 0;
					for ($i = $size - 1; $i >= 0; $i -=2) {
						for ($cs = 0; $cs < 4; $cs++) {
							$ct = $corners [($cs + array_search($c, $corners)) % 4];
							for ($j = 0; $j < $i; $j++) {
								if ($ct == "TL") $sq[$j + $loop][$size - $i - 1 - $loop] = $text[$idx++];  
								if ($ct == "BL") $sq[$i + $loop][$j + $loop] = $text[$idx++];  
								if ($ct == "BR") $sq[$size - $j - 1 - $loop][$size - 1 - $loop] = $text[$idx++];  
								if ($ct == "TR") $sq[$size - $i - 1 - $loop][$size - $j - 1 - $loop] = $text[$idx++];
							}
						}
						$loop++;
					}
					if ($size % 2 == 1) $sq[intdiv($size,2)][intdiv($size,2)] = $text[$idx++];
				}
				break;

			default :
				for ($i = 0; $i < $size; $i++)
					for ($j = 0; $j < $size; $j++) $sq[$i][$j] = "X";	
	    } // end case

		$s = "";
		for ($i = 0; $i < $size; $i++)
			for ($j = 0; $j < $size; $j++) $s .= $sq[$i][$j];

	    	return $s;

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
		$msg = $this->makearray($msgtxt);
		if (sizeof($msg) == 0) return "Nothing to encode or decode";
		
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
	
	// Transposing a message reorganizes the message. Different methods are used
	// depending on the cipher.

	public function createtranspositionkey ($s) {
	    
	    // Creates array of integers e.g. 2,1,0 reorders columns as 0,1,2
	    // $key[1] = 4; means column 1 becomes column 4
	    switch (gettype($s)) {
	        case "array"    : return $s;
	        case "integer"  : $s = sprintf("%d", $s); break;
	        case "string"   : break;
	        default         : return null;
	    }
	    
	    $tmparr = [];
	    $len = strlen($s);
	    for ($i = 0; $i<$len; $i++) {
	        $tmparr[$i] = $s[$i] . sprintf("%04d",$i);
	    }
	    sort ($tmparr);
	    $a = [];
	    for ($i = 0; $i<$len; $i++) $a[$i] = array_search ($s[$i] . sprintf("%04d",$i), $tmparr);
	    return $a;  
	}
	
	public function rowtocolumntransposition ($msgtxt, $nrows) {
	    
	    //Simple tranposition: write message in rows and read the columns
		
	    //Check input
	    if ($nrows < 0) return "Number of rows should be greater than zero";
	    $msg      = $this->makearray($msgtxt);
	    $msglen   = sizeof($msg);
	    if ($nrows > $msglen) return $msgtxt;
	    if ($msglen == 0) return "Nothing to transpose";

		//Initialize stuff
	    $a = [];
	    for ($i = 1; $i <= $nrows; $i++) $a[$i]="";
		
	    //Distribute across columns
	    $i=0;
	    while ($i < $msglen) {
	        $row = 1;
	        while (($row <= $nrows) && ($i < $msglen)) {
	            $a[$row] .= $msg[$i];
	            $i++; $row++;
	        }
	    }
	    
	    //Print rows
	    $s="";
	    for ($i=1; ($i <= $nrows); $i++) $s .= $a[$i];
	    
	    return $s;
	}
	
	public function encodecolumnartransposition ($msgtxt, $key) {
    
		// Message can be a text string, a number or an array
		// Key should be an array of integers e.g. 2,1,0 reorders columns as 0,1,2
		// Message is written in rows and columns are read in the given order
		// Function works both on complete and incomplete columns, it just depends on the input
	    	
		// Check stuff
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
		$table = [];
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
		
		// Check stuff
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
		$table = [];
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
	
	public function encodemyszkowskitransposition ($msgtxt = "", $key) {

		// Kind of columnar transposition, when columns share the same key
		// they are printed together before proceeding with the next row
		
		// Check stuff
		if ($key == null) return "No key specified, empty";
		if (gettype($key) != "string") return "No key specified, not an string";
		$msg      = $this->makearray($msgtxt);
		$msglen   = sizeof($msg);
		if ($msglen == 0) return "Nothing to encode";
		
		$n1 = 0;  
		$na = []; 
		$na[$n1] = 1;
		$colkey = $this->createtranspositionkey ($key);

		// Create the aggregated column map
		for ($i = 0; $i < (sizeof($colkey) -1); $i++) {
			if ($key[array_search ($i, $colkey)] == $key[array_search($i+1,$colkey)])
				$na[$n1]++;
			else {
				$n1++; $na[$n1] = 1;
			}
		}

		$s = "";
		$nrow = (integer) ceil($msglen / sizeof($colkey));
		$colcnt = 0;
		$nlongcol = $msglen % sizeof($colkey);

		// Put msg in table
		for ($i = 0; $i < $msglen; $i++)
			$table[intdiv ($i, sizeof($colkey))][ $i % sizeof($colkey)] = $msg[$i];

		// for each aggregated column
		for ($i = 0; $i < sizeof($na); $i++) {

			// Print all rows for the aggregated column
			for ($row = 0; $row < $nrow; $row++) {

				// Print each column in the aggregated column
				for ($c = 0; $c < $na[$i]; $c++) {
					$col = array_search($colcnt + $c, $colkey);
					if (($col >= $nlongcol) && ($nlongcol != 0) && ($row == $nrow-1)) continue;
					$s .= $table [$row][$col];
				}
			}
			$colcnt += $na[$i];
		}
		return $s;
	}

	public function decodemyszkowskitransposition ($msgtxt = "", $key) {

		// Check stuff
		if ($key == null) return "No key specified, empty";
		if (gettype($key) != "string") return "No key specified, not an string";
		$msg      = $this->makearray($msgtxt);
		$msglen   = sizeof($msg);
		if ($msglen == 0) return "Nothing to encode";

		$n1 = 0;  
		$na = [];
		$na[$n1] = 1;
		$colkey = $this->createtranspositionkey ($key);

		// Create the aggregated column map
		for ($i = 0; $i < (sizeof($colkey) -1); $i++) {
			if ($key[array_search ($i, $colkey)] == $key[array_search($i+1,$colkey)])
				$na[$n1]++;
			else {
				$n1++; $na[$n1] = 1;
			}
		}

		$s = "";
		$idx = 0;
		$colcnt = 0;
		$nrow = (integer) ceil($msglen / sizeof($colkey));
		$nlongcol = $msglen % sizeof($colkey);

		// For each aggregated column
		for ($i = 0; $i < sizeof($na); $i++) {

			// Print all rows for the aggregated column
			for ($row = 0; $row < $nrow; $row++) {

				// Print each column in the aggregated column
				for ($c = 0; $c < $na[$i]; $c++) {
					$col = array_search ($c + $colcnt, $colkey);
					if (($col > $nlongcol-1) && ($nlongcol != 0) && ($row == $nrow - 1)) continue;
					$table[$row][$col] = $msg[$idx++];
				}
			}
			$colcnt += $na[$i];
		}

		$s = "";
		for ($row = 0; $row < $nrow; $row++) {
			(($row == $nrow - 1)  && ($nlongcol != 0)) ? $collen = $nlongcol : $collen = sizeof($colkey);
			for ($col = 0; $col < $collen; $col++)  {
					$s .= $table[$row][$col];
				}
			}
		return $s;
	}
	
	public function encodeswagmantransposition ($msgtxt = "", $keysquare = null) {
		// Key is an array of arrays with indexes starting at 1, 2, 3, ...
		
		// Check stuff
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
		$map = [];
		for ($c = 0; $c < $this->keysquaresize; $c++) {
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
		$map = [];
		for ($c = 0; $c < $keysquaresize; $c++) {
			for ($r = 0; $r < $keysquaresize; $r++)
				$map[$c][$r+1] = $keysquare[$r+1][$c];
		}
		
		// Print message in columns
		$rowlen = (integer) ceil($msglen / $keysquaresize);
		$idx = 0;
		$s = [];
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
		
		// Check stuff
		if ($key == null) return "No key specified, empty";
		if (gettype($key) != "array") return "No key specified, not an array";
		$msg      = $this->makearray($msgtxt);
		$msglen   = sizeof($msg);
		if ($msglen == 0) return "Nothing to encode";
		$size = sizeof($key);
		if ($msglen != $size**2) return "Message not a sqyuare";
		
		// Fill square
		for ($r = 0; $r < $size; $r++) {
			for ($c = 0; $c < $size; $c++) $table[$r][$c] = $msg[$r * $size + $c];
		}
		
		// Transpose columns
		for ($r = 0; $r < $size; $r++) {
			for ($c = 0; $c < $size; $c++) $table2[$r][$key[$c]] = $table[$r][$c];
		}
		
		// Transpose rows
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
		
		// Check stuff
		if ($key == null) return "No key specified, empty";
		if (gettype($key) != "array") return "No key specified, not an array";
		$size = sizeof($key);
		$msg      = $this->makearray($msgtxt);
		$msglen   = sizeof($msg);
		if ($msglen == 0) return "Nothing to encode";
		if ($msglen != $size**2) return "Message not a sqyuare";
		
		// Fill square
		$size = sizeof($key);
		for ($r = 0; $r < $size; $r++)
			for ($c = 0; $c < $size; $c++) 
				($readrow) ? $table[$r][$c] = $msg[$r * $size + $c] : $table[$c][$r] = $msg[$r * $size + $c];
		
		// Transpose rows
		for ($r = 0; $r < $size; $r++) {
			$row = array_search ($r, $key);
			for ($c = 0; $c < $size; $c++) $table2[$row][$c] = $table[$r][$c];
		}
		
		// Transpose columns
		for ($r = 0; $r < $size; $r++)
			for ($c = 0; $c < $size; $c++) {
				$col = array_search ($c, $key);
				$table3[$r][$col] = $table2[$r][$c];
			}
		
		// Print row after row
		$s = "";
		for ($r = 0; $r < $size; $r++)
			for ($c = 0; $c < $size; $c++) 
			    $s .= $table3[$r][$c];
		
		// Return result
		return $s;
	}
	
	public function encodeburrowswheelertransposition ($msg, $eof = "|") {
		
		$msg = $msg . $eof;
		$sz = strlen ($msg);
		$table[0] = $msg;
		for ($i = 1; $i < $sz; $i++)
			$table [$i] = substr($msg, $i) . substr($msg, 0, $i);
		sort ($table);
  
		$s = "";
		for ($i = 0; $i < strlen ($msg); $i++) $s .= $table[$i][$sz-1];
		return $s;
	}
	
	public function decodeburrowswheelertransposition ($msg, $eof = "|") {
		
		$sz = strlen ($msg);

		// Calculate transfomatievector
		$firstcol = str_split($msg);
		sort ($firstcol);
		$firstcol = implode ("", $firstcol);

		$keeptrack = [];
		$transvec  = [];
		for ($i = 0; $i < $sz; $i++) {
			(array_key_exists ($msg[$i], $keeptrack)) ? $start = $keeptrack[$msg[$i]]+1 : $start = 0;
			$transvec[$i] = strpos ($firstcol, $msg[$i],$start);
			$keeptrack[$msg[$i]] = $transvec[$i];
		}
	 
		// Reverse start at EOF pos
		$pos = strpos ($msg, $eof);
		$end = $pos;
	   
		$s = "";
		do {
			$s   = $msg[$pos] . $s;
			$pos = $transvec[$pos];
		} while ($pos != $end);

		return substr($s, 0, -1);
	}
	
	public function encoderedefencetransposition ($msg, $nrail = 3, $offset = 0, $railseq = null) {

		// Init rows a.k.a as rails
		for ($i=0; $i < $nrail; $i++) $rails[$i] = "";

		// Calculate right offset
		$down = ($offset < $nrail - 1);
		($down) ? $rail = $offset : $rail = ($nrail - 1)*2 - $offset;

		// Append each char to the next row   
		for ($i = 0; $i < strlen($msg); $i++) {
			$rails[$rail] .= $msg[$i];
			if ($down) {
				$rail++;
				if ($rail == ($nrail-1)) $down = !$down;
			} else {
				$rail--;
				if ($rail == 0) $down = !$down;
			}
		}

		// Print all the rows
		$s2 = "";                              
		for ($i=0; $i < $nrail; $i++) $s2 .= $rails[$railseq[$i]];
		return $s2;
    }

    public function decoderedefencetransposition ($msg, $nrail = 3, $offset, $railseq = null) {

        // Create a table with nulls
		for ($r = 0; $r < $nrail; $r++)
			for ($c = 0; $c < strlen($msg); $c++)
				$rails[$r][$c] = null;
				
		// Calculate right offset
        $down = ($offset < $nrail - 1);
        ($down) ? $rail = $offset : $rail = ($nrail - 1)*2 - $offset;

        // Plot the positions that should contain the message
		for ($i = 0; $i < strlen($msg); $i++) {
			$rails[$rail][$i] = 'XX';
			if ($down) {
				$rail++;
				if ($rail == ($nrail-1)) $down = !$down;
			} else {
				$rail--;
				if ($rail == 0) $down = !$down;
			}
		}

		// Fill the message
		$idx = 0;
		for ($r = 0; $r < $nrail; $r++)
			for ($c = 0; $c < strlen($msg); $c++)
				if ($rails[$railseq[$r]][$c] == 'XX')  $rails[$railseq[$r]][$c] = $msg[$idx++];

		// Read col after col
		$s = "";
		for ($c = 0; $c < strlen($msg); $c++)
			for ($r = 0; $r < $nrail; $r++)
				if ($rails[$r][$c] != null)  $s .= $rails[$r][$c];
		return $s;
    }
	
	// Default functions must always be implemented
	abstract function encode ($text);	
	abstract function decode ($text);
	
} // End cipher

