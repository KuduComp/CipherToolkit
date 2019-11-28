<?php
namespace cipher;

class columnartranspositioncipher extends cipher {
    protected $key = "";
    protected $keylen = 0;
    protected $keymap;
    
    function __construct ($alphabet  = UPPER_ALPHABET, $key = "") {
        parent::__construct ($alphabet);
        $this->setkeys ($key1, $key2);
    }
    
    function setkey ($key) {
        $this->key = $key;
        $this->keylen = strlen($key);
        $this->keymap = $this->createtranspositionkey ($key);
    }
    
    function getkey () { return $key; }
    
    function encode ($msg = "") {
        return $this->encodecolumnartransposition ($res, $this->keymap);
    }
    
    
    function decode ($msg = "") {
        return $this->decodecolumnartransposition ($res, $this->keymap);
    }
    
} // columnartranspositioncipher
?>
