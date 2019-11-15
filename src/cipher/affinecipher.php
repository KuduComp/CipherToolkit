<?php

namespace cipher;

class affinecipher extends cipher {
  
    protected $a, $b, $ainv;

    function __construct ($alphabet, $a, $b) {
      parent::__construct ($alphabet);
      $this->setab ($a, $b);
    }
    
    function setab ($a, $b) {
      $this->a = $a; 
      $this->b = $b;
      $this->ainv = $this->modinvers ($this->a, strlen($this->alphabet));
    }
  
    function geta () { return $this->a; }
    function getb () { return $this->b; }
    
    function modinvers ($a, $m) {   
        $a = $a % $m; 
        for ($x=1; $x < $m; $x++) 
           if (($a*$x) % $m == 1) 
              return $x;
        return 0;
    }
    
    function encode ($msg) {
        $s = "";
        for ($i=0; $i < strlen($msg); $i++) {
            $pos = strpos ($this->alphabet, $msg[$i]);
            if ($pos !== FALSE) {
                $s .= $this->alphabet [($pos * $this->a + $this->b) % strlen($this->alphabet)];
            } else 
                if (!$this->remove) $s .= $msg[$i]; else return "Illegal character found";
        }
        return $s;
    }
    
    function decode ($msg) {
        
        if ($this->ainv == 0) return "Error decoding as a results in duplicates in decoding";
        $s = "";
        for ($i=0; $i < strlen($msg); $i++) {
            $pos = strpos ($this->alphabet, $msg[$i]);
            if ($pos !== FALSE) {
                $s .= $this->alphabet [($this->ainv * ($pos - $this->b)) % strlen($this->alphabet)];
            } else 
                if (!$this->remove) $s .= $msg[$i]; else return "Illegal character found";
        }
        return $s;
    }
    
} // class affinecipher

?>
