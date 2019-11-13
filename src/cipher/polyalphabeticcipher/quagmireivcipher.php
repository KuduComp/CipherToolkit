<?php 

namespace ciphercipher\polyalphabeticcipher;

class quagmireivcipher extends \cipher\polyalphabeticcipher {
    
    // Two keys are used for plain and cipher alphabets.
    // The iterator key may appear under any character
    public function __construct ($alphabet, $iteratorkey, $cipherkey, $plainkey, $keycol="") {
        $this->keyunder = $keyunder;
        parent::__construct ($alphabet, $iteratorkey, $cipherkey, $plainkey, $keycol);
        $this->createshiftedtableau($this->keyunder);
    }
}

?>