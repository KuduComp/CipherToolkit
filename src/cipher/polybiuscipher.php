<?php 

namespace cipher;

class polybiuscipher extends cipher {
    
    protected $size;        //Size of the square
    protected $rows;        //Row headers
    protected $cols;        //Col headers
    protected $horizontal;  //Direction of cipher
    protected $square;      //The polybius square
    
    public function __construct ($alphabet = UPPER_ALPHABET_REDUCED, $rows="12345", $cols="12345", $horizontal = TRUE) {
        parent::__construct ($alphabet, $rows . $cols, TRUE, 0, " ");
        $this->size = (int) sqrt (strlen($alphabet));
        $this->horizontal = $horizontal;
        $this->setsquare ($rows, $cols);
    }
    
    public function sethorizontal ($dir = TRUE) { $this->horizontal = $dir; $this->setsquare($this->rows, $this->cols); }
    public function gethorizontal ($dir = TRUE) { return $this->horizontal; }
    
    public function setsquare ($rows="12345", $cols="12345") {
        
        // Check square
        if (strlen($rows) != strlen($cols)) { $this->square = null; return; }
        if (($this->size**2) != strlen($this->alphabet)) { $this->square = null; return; }
        
        // Fill square
        $this->rows = $rows; 
        $this->cols = $cols; 
        $this->validcodes = $rows . $cols;
        $this->square = array();
        for ($r = 0; $r < $this->size; $r++) $this->square[$r] = array();
        for ($r = 0; $r < $this->size; $r++) 
            for ($c = 0; $c < $this->size; $c++)
                ($this->horizontal) ? $square[$this->alphabet[$r * $this->size + $c] = $rows . $cols :
                                              $square[$this->alphabet[$r * $this->size + $c] = $cols . $rows;
    }
    
    public function encode ($msg) {
        
        // Encode message
        $this->setsep = " ";
        return $this->arraysubstitution ($msg, $this->square);
    }
    
    public function decode ($msg) {
        // Split msg in array of pairs assume separator
        $msgarr = array();
        for ($i=0; $i < strlen($msg); $i+=3) $msgarr[]=substr($msg, $i, 2);
        // Decode
        return $this->arraysubstitution ($msgarr, array_flip($this->square));
    }
    
} // End of polybiuscipher

?>
