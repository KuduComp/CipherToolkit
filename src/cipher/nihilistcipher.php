<?php 

namespace cipher;

class nihilistcipher extends cipher {
    
    protected $keyword = "";
    protected $keylen = 0;
    protected $numkey = array();
    
    public function __construct ($alphabet = UPPER_ALPHABET, $key = "") {
        parent::__construct ($alphabet);
        $this->setkey($key);
    }
    
    public function setkey ($key) {
        $this->key = $key;
        $this->keylen = strlen($key);
        $numkeystr = "11 22 33 44 55";
        for ($i=0; $i<strlen($numkeystr); $i += 3)
            $numkey[$i % 3] = (integer) substr($numkeystr, $i, 2);
    }
    
    public function encode ($msg) {
        return $msg;
    }
    
    public function decode ($msg) {
        return $msg;
    }
    
}

?>