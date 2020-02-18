<?php

namespace cipher;

class graycode {
	
	protected $n = 4;
	
	function __construct ($n = 4) { $this->n = $n; } 
	function setdigits ($n = 4) { $this->n = $n; }
	function getdigits () { return $this->n; }
	
	// Input is a string of integers separated as words
	// Words which aren't integers are translated into 0
	
	function encode ($msg = "") {
	
		$fs = '%0'. $this->n . 'd';
        // Split into words
        preg_match_all ('/(\b[^\s]+\b)/', $msg, $matches);
	    $s = "";
        
        // Process each word
		foreach ($matches[0] as $n)
			$s .= sprintf ($fs, decbin ($n ^ ($n >> 1))) . " ";
		return substr($s, 0, -1);
	}
  
	function decode ($msg = "") {
        		
        // Split into words
        preg_match_all ('/(\b[^\s]+\b)/', $msg, $matches);
        $s = "";
        
        // Process each word
        foreach ($matches[0] as $n) {
			$n = bindec ($n);
            $mask = $n >> 1;
			while ($mask != 0)   {
				$n = $n ^ $mask;
				$mask = $mask >> 1;
			}
			$s .= $n . " ";
        }
	    return substr($s, 0 , -1);
	}

} // graycode



?>
