<?php

namespace cipher;

class colloncipher extends cipher {
    
    protected $ncol;
    protected $nrow;
    protected $square;
    
    public function __construct ($alphabet = "ABCDEFGHIKLMNOPQRSTUVWXYZ", $key = "", $ncol = 5, $nrow = 5) {
        parent::__construct ($alphabet);
        $this->nrow = $nrow;
        $this->ncol = $ncol;
        $this->setkey ($key);
    }
    
    public function setkey ($key = "") {
        $this->key = $key;
        $this->square = $this->shufflealphabet ($this->alphabet, $key);
    }
    public function getkey () { return $this->key; }
    
    public function encode ($msg = "", $n = 3, $method = "RFCL") {
        
        // Method R = row, C = column, F = first, L = last
        // E.g. RFCL means First Character of row + Last Character of column
        
        $res = "";
        for ($i = 0; $i < strlen($msg); $i += $n) {
        	$s = substr($msg, $i, $n);
        	$tmp = "";
        	for ($j = 0; $j < strlen ($s); $j++) {
        		$pos = stripos ($this->square, $s[$j]);
        		if ($pos !== FALSE) {
        			$r = intdiv ($pos, $this->ncol);
        			$c = $pos % $this->ncol;
        			switch ($method) {
            			case "RFCL" : $tmp = $tmp . $this->square[$r * $this->ncol] . $this->square [($this->nrow-1)*$this->ncol + $c]; break;
            			case "RLCL" : $tmp = $tmp . $this->square[($r+1) * $this->ncol - 1] . $this->square [($this->nrow-1)*$this->ncol + $c]; break;
            			case "RFCF" : $tmp = $tmp . $this->square[$r * $this->ncol] . $this->square [$c]; break;
            			case "RLCF" : $tmp = $tmp . $this->square[($r+1) * $this->ncol - 1] . $this->square [$c]; break;
            			case "CLRL" : $tmp = $tmp . $this->square [($this->nrow-1)*$this->ncol + $c] . $this->square[($r+1) * $this->ncol - 1]; break;
            			case "CLRF" : $tmp = $tmp . $this->square [($this->nrow-1)*$this->ncol + $c] . $this->square[$r * $this->ncol]; break;
            			case "CFRF" : $tmp = $tmp . $this->square [$c] . $this->square[$r * $this->ncol]; break;
            			case "CFRL" : $tmp = $tmp . $this->square [$c] . $this->square[($r+1) * $this->ncol - 1]; break;
        			}
        		}
        	}
        	for ($j = 0; $j < strlen ($s); $j++) $res .= $tmp[$j*2];
        	for ($j = 0; $j < strlen ($s); $j++) $res .= $tmp[$j*2+1];
        }
        return $res;
    }
    
    public function decode ($msg = "", $n = 3, $method = "RFCL") {
        
        // Method R = row, C = column, F = first, L = last
        // E.g. RFCL means First Character of row + Last Character of column

        $res = "";
        for ($i = 0; $i < strlen($msg); $i += (2*$n)) {
        	$s = substr($msg, $i, 2*$n);
        	$tmp = "";
        	$max = intdiv(strlen($s),2);
        	for ($j = 0; $j < $max; $j += 1) {
        	    if (in_array ($method, array("RFCF","RFCL","RLCL","RLCF"))) {
            		$posr = stripos ($this->square, $s[$j]);
            		$posc = stripos ($this->square, $s[$j + $max]);
        	    } else {
        	        $posc = stripos ($this->square, $s[$j]);
            		$posr = stripos ($this->square, $s[$j + $max]);
        	    }
        		if (($posc !== FALSE) && ($posr !== FALSE)) {
        			$r = intdiv ($posr, $this->ncol);
        			$c = $posc % $this->ncol;
        			$res .= $this->square[$r * $this->ncol + $c];
        		}
        	}
        }
        return $res;
    }

} // colloncipher

?>
