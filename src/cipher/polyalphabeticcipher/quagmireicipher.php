<<<<<<< HEAD
<?php 

namespace cipher\multisubstitutioncipher;

class quagmireicipher extends \cipher\polyalphabeticcipher {
    
    // The Quag One is a periodic cipher with a keyed plain alphabet
    // run against a straight cipher alphabet.
    // The indicator can be under any key
    public function __construct ($alphabet, $iteratorkey, $plainkey, $keycol="") {
        $this->keyunder = $keyunder;
        parent::__construct ($alphabet, $iteratorkey, "", $plainkey, $keycol);
        $this->createshiftedtableau($this->keyunder);
    }
}

?>