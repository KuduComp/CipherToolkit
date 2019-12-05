<?php 

namespace cipher\polybiuscipher;

class bifidcipher extends \cipher\polybiuscipher {
    
    public function __construct ($alphabet = UPPER_ALPHABET_REDUCED, $key = "") {
        parent::__construct ($alphabet);
        $this->setkey ($key);
    }
    
    public function encode ($msg) {
        // Encode as polybiuscipher
        $msg = parent::encode ($msg);
        // Remove separators if any added by encoding polybius
        $s = $this->cleanencodedmessage($msg);
        // Fractionate in two rows
        $msg = $this->rowtocolumntransposition($s,2);
        // Decode de fractionation as polybius
        $msg = parent::decode($msg);
        return $msg;
    }
    
    public function decode ($msg) {
        $msg = parent::encode($msg);
        $s = $this->cleanencodedmessage($msg);
        $msg = $this->rowtocolumntransposition($s,strlen($s) / 2);
        $msg = parent::decode($msg);
        return $msg;
    }
    
} // Class bifidcipher

?>
