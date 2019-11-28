<?php 

namespace cipher\polyalphabeticcipher;

class keyedvigenerecipher extends \cipher\polyalphabeticcipher {
    
    public function __construct ($alphabet = UPPER_ALPHABET, $iteratorkey, $cipherkey) {
        parent::__construct ($alphabet, $iteratorkey, $cipherkey, $cipherkey);
    }
    
}
    
?>