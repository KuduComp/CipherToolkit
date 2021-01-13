<?php 

namespace cipher\polyalphabeticcipher\vigenerecipher;

class gronsfieldcipher extends \cipher\polyalphabeticcipher\vigenerecipher {
    
    public function __construct ($alphabet, $key) {
        parent::__construct ($alphabet, $key);
        //Check key
        $hlp = "ABCDEFGHIJ";
        $keys = "";
        for ($i=0; $i < strlen($key); $i++) $keys .= $hlp[(int)$key[$i]];
        $this->keyiterator = $keys;
    }
}

?>