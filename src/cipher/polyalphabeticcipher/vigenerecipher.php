<?php 

namespace cipher\polyalphabeticcipher;

class vigenerecipher extends \cipher\polyalphabeticcipher {
    
    public function __construct ($alphabet, $iteratorkey) {
        parent::__construct ($alphabet, $iteratorkey, $alphabet, $alphabet);
    }
}

?>