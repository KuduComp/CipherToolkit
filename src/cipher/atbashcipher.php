<?php  

namespace cipher;

// Classic atbash cipher, encoding using reversed alphabet
class atbashcipher extends cipher {
    
    public function __construct ($a = UPPER_ALPHABET) {
        parent::__Construct ($a);
    }
    
    public function encode ($text) {
        return $this->simplesubstitution ($text, strrev($this->alphabet));
    }
    
    public function decode ($text) {
        return $this->simplesubstitution ($text, strrev($this->alphabet));
    }
    
} // End of atbashcipher

?>