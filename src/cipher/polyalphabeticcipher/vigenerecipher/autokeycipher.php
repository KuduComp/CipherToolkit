<?php 

namespace cipher\polyalphabeticcipher\vigenerecipher;

class autokeycipher extends \cipher\polyalphabeticcipher\vigenerecipher {
    
    public function encode ($msg) {
        
        // For each letter
        // Row uses index from iteratorkey
        // Col is position in plainalphabet
        $s = "";
        $key = $this->keyiterator . $msg;
        for ($i = 0; $i < strlen($msg); $i++) {
            $pos = $this->strpos2($this->plainalphabet, $msg[$i]);
            if ($pos !== FALSE) {
                $c = $this->tableau[$key[$i]][$pos];
                $s .= $c;
                
            }
        }
        return $s;
    }
    
    // Decode
    
    public function decode ($msg) {
        
        // For each letter
        // Row uses index from iteratorkey
        // Col is position in tableau
        $s = "";
        $key = $this->keyiterator;
        for ($i = 0; $i < strlen($msg); $i++) {
            $pos = $this->strpos2($this->tableau[$key[$i]], $msg[$i]);
            if ($pos !== FALSE) {
                $c = $this->plainalphabet[$pos];
                $s .= $c;
                $key .= $c;
            }
        }
        return $s;
    }
}

?>