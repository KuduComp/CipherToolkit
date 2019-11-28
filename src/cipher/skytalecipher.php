<?php
namespace cipher;
class columnartranspositioncipher extends cipher {
    
    protected $key = 0;
    protected $keymap;
    
    function __construct ($alphabet  = UPPER_ALPHABET, $key = 0) {
        parent::__construct ($alphabet);
        $this->setkey ($key);
    }
    
    function setkey ($key) {
        $this->key = $key;
        $this->keymap = array();
        for ($i = 0; $i < $key; $i++) $this->keymap[] = $i;
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
