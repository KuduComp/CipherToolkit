<?php 

namespace cipher;

// Polyalphabetic ciphers use a tableau of alphabets. The best known is the Vigenere cipher.
class polyalphabeticcipher extends cipher {
    
    protected $keyiterator;
    protected $iterkeylen;
    protected $keycipher;
    protected $keyplain;
    protected $plainalphabet = "";
    protected $cipheralphabet = "";
    protected $tableau = array();
    protected $keycol="";
    
    public function __construct ($alphabet = UPPER_ALPHABET, $keyiterator="", $keycipher="", $keyplain="", $keycol="") {
        
        parent::__construct ($alphabet);
        $this->settableau ($keyiterator, $keycipher, $keyplain, $keycol);
    }
    
    public function settableau ($keyiterator="", $keycipher="", $keyplain="", $keycol="") {
        
        $this->keyiterator = $keyiterator;
        $this->iterkeylen  = strlen ($keyiterator);
        $this->keycipher   = $keycipher;
        $this->keyplain    = $keyplain;
        $this->keycol      = $keycol;
        
        // Create plainalphabet
        $this->plainalphabet = $this->shufflealphabet ($keyplain, $this->alphabet);
        
        // Create cipheralphabet
        $this->cipheralphabet = $this->shufflealphabet ($keycipher, $this->alphabet);
        
        // Create a tableau - each row contains a shifted alphabet
        $this->tableau = array();
        if ($keycol == "")
            $pos = 0;
            else {
                $pos = $this->strpos2($this->plainalphabet, $keycol);
                if ($pos === FALSE) $pos=0;
            }
            $s = $this->cipheralphabet;
            for ($i=0; $i<strlen($this->cipheralphabet); $i++) {
                $this->tableau[$this->cipheralphabet[($i + $pos) % strlen($this->cipheralphabet) ]]= $s;
                $s = substr($s,1) . $s[0];
            }
    }
    
    public function gettableau () { return $this->tableau; }
    
    public function encode ($msg) {
        
        // For each letter
        // Row uses index from iteratorkey
        // Col is position in plainalphabet
        $s = "";
        for ($i = 0; $i < strlen($msg); $i++) {
            $pos = $this->strpos2($this->plainalphabet, $msg[$i]);
            if ($pos !== FALSE) {
                $row =($i % $this->iterkeylen);
                $s .= $this->tableau[$this->keyiterator[$row]][$pos];
            }
        }
        return $s;
    }
    
    public function decode ($msg) {
        
        // For each letter
        // Row uses index from iteratorkey
        // Col is position in tableau
        $s = "";
        for ($i = 0; $i < strlen($msg); $i++) {
            $row =($i % $this->iterkeylen);
            $pos = $this->strpos2($this->tableau[$this->keyiterator[$row]], $msg[$i]);
            if ($pos !== FALSE) {
                $s .= $this->plainalphabet[$pos];
            }
        }
        return $s;
    }
    
}  // End of class

?>
