<<<<<<< HEAD
<?php 

namespace cipher\polyalphabeticcipher;

class quagmireiicipher extends \cipher\polyalphabeticcipher {
    
    // The Quag One is a periodic cipher with a keyed plain alphabet
    // run against a straight cipher alphabet.
    // The indicator can be under any key
    public function __construct ($alphabet, $iteratorkey, $cipherkey, $keycol="") {
        $this->keyunder = $keyunder;
        parent::__construct ($alphabet, $iteratorkey, $cipherkey, "", $keycol);
        $this->createshiftedtableau($this->keyunder);
    }
    
}

?>