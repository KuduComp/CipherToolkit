<?php

namespace cipher;

class foursquarecipher extends cipher {

    protected $alphabet = "ABCDEFGHIKLMNOPQRSTUVWXYZ";
    protected $key1 = "KABOUTER";
    protected $key2 = "DWERG"; 
    protected $square1 = "";
    protected $square2 = "";
    protected $size = 5;
    
    function __construct ($alphabet = UPPER_ALPHABET_REDUCED, $key1 = "", $key2 = "") {
        parent::__construct($alphabet);
        $this->setkeys ($key1, $key2);
    }
    
    function setkeys ($key1, $key2) {
        $this->key1 = $key1;
        $this->key2 = $key2;
        $this->square1 = implode("", array_values (array_unique (array_merge (str_split($key1), str_split($this->alphabet)))));
        $this->square2 = implode("", array_values (array_unique (array_merge (str_split($key2), str_split($this->alphabet)))));
    }
    
    function getkeys () {
        return array ($this->key1, $this->key2);
    }
    
    function encode ($msg = "") {
    
        // Checks
        if (strlen($this->alphabet) != ($this->size**2)) return "Not a square number of characters in the alphabet";
        
        // Make string even number of characters
        if ((strlen($msg) % 2) == 1) $msg .= "X";
        
        //Read string two characters at a time
        $s = "";
        for ($i = 0; $i < strlen($msg); $i += 2) {
            $pos = strpos ($this->alphabet, $msg[$i]);
            if ($pos === FALSE) return $s .= " Illegal character found: " . $msg[$i];
            $r1 = intdiv ($pos, $this->size);
            $c1 = ($pos % $this->size);
            $pos = strpos ($this->alphabet, $msg[$i+1]); 
            if ($pos === FALSE) return $s .= " Illegal character found: " . $msg[$i+1];
            $r2 = intdiv ($pos, $this->size);
            $c2 = ($pos % $this->size);
            $s = $s . $this->square1[$r1 * $this->size + $c2] . $this->square2[$r2 * $this->size + $c1];
        }
        return $s;
    }
    
    
    function decode ($msg = "") {
    
        // Checks
        if (strlen($this->alphabet) != ($this->size**2)) return "Not a square number of characters in the alphabet";
        
        //Read string two characters at a time
        $s = "";
        for ($i = 0; $i < strlen($msg); $i += 2) {
            $pos = strpos ($this->square1, $msg[$i]);
            if ($pos === FALSE) return $s .= " Illegal character found: " . $msg[$i];
            $r1 = intdiv ($pos, $this->size);
            $c1 = ($pos % $this->size);
            $pos = strpos ($this->square2, $msg[$i+1]); 
            if ($pos === FALSE) return $s .= " Illegal character found: " . $msg[$i+1];
            $r2 = intdiv ($pos, $this->size);
            $c2 = ($pos % $this->size);
            $s = $s . $this->alphabet[$r1 * $this->size + $c2] . $this->alphabet[$r2 * $this->size + $c1];
        }
        return $s;
    } 

} // Class foursquarecipher