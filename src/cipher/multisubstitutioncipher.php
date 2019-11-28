<?php 

namespace cipher;

class multisubstitutioncipher extends cipher {
    
    protected $codelen = 0;          // If codelen = 0 codes varies (e.g. morse) and chars should be separated with a known code
                                     // If codelen > 0 separators are optional
    protected $codetable = array();
    
    public function __Construct ($codelen, $validcodes, $codetable) {
        $this->codelen = $codelen;
        $this->codetable = $codetable;
        $s="";
        foreach ($this->codetable as $m) $s .= $m;
        parent::__construct($s, $validcodes);
    }
    
    public function encode ($msg) {
       return $this->arraysubstitution ($msg, $this->codetable);
    }
    
    public function decode ($msg) {
        
        // Decode
        $msgarr = array();
        $i = 0;
        while ($i<strlen($msg)) {
            $key = "";
            if ($this->codelen == 0) {
                // Read until a none code character is found
                while (($i<strlen($msg)) && (strpos($this->validcodes, $msg[$i]) !== FALSE)) {
                    $key .= $msg[$i]; $i++;
                }
            } else {
                $cnt = 0;
                while (($i<strlen($msg)) && ($cnt<$this->codelen) ) {
                    if (strpos($this->validcodes, $msg[$i]) !== FALSE) {
                        $cnt++;
                        $key .= $msg[$i];
                    } else
                        if (!$this->remove) $msgarr[] = $msg[$i];;
                        $i++;
                }
            }
            $msgarr[] = $key;
            // Skip stuff until start of new code
            while (($i<strlen($msg)) &&(strpos($this->validcodes, $msg[$i]) === FALSE)) {
                if (!$this->remove) $msgarr[] = $msg[$i];
                $i++;
            }
        }
		
		// Create reverse codetable
		return $this->arraysubstitution ($msgarr, array_flip($this->codetable));
    }
    
} // multisubstitutioncipher

?>