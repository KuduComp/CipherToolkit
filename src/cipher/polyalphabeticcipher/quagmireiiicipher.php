<?php 

namespace cipher\polyalphabeticcipher;

class quagmireiiicipher extends \cipher\polyalphabeticcipher {
    
    // The same keyed alphabet is used for plain and cipher alphabets.
    // The iterator key may appear under any character
    // Assuming column 1 this equals a keyed Vigenere
    public function __construct ($alphabet, $iteratorkey, $cipherkey, $keycol="") {
        $this->keyunder = $keyunder;
        parent::__construct ($alphabet, $iteratorkey, $cipherkey, $cipherkey, $keycol);
        $this->createshiftedtableau($this->keyunder);
    }
}

?>