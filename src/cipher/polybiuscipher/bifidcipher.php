<?php 

namespace cipher\polybiuscipher;

class bifidcipher extends \cipher\polybiuscipher {
    
    public function __construct ($alphabet = UPPER_ALPHABET_REDUCED, $key = "") {
        $alphabet = $this->shufflealphabet($alphabet, $key);
        parent::__construct ($alphabet);
    }
    
    public function encode ($msg) {
        // Encode as polybiuscipher
        $msg = parent::encode ($msg);
        // Remove separators which are default added by encoding polybius
        $s=""; for ($i=0; $i<strlen($msg); $i++) if ($msg[$i] != $this->sep) $s .= $msg[$i];
        // Fractionate in two rows
        $msg = $this->rowtocolumntransposition($s,2);
        // Decode de fractionation as polybius
        $msg = parent::decode($msg);
        return $msg;
    }
    
    public function decode ($msg) {
        $msg = parent::encode($msg);
        $s=""; for ($i=0; $i<strlen($msg); $i++) if ($msg[$i] != $this->sep) $s .= $msg[$i];
        $msg = $this->rowtocolumntransposition($s,strlen($s) / 2);
        $msg = parent::decode($msg);
        return $msg;
    }
    
} // Class bifidcipher

?>
