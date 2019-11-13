<?php 

namespace cipher;

class polybiuscipher extends cipher {
    
    protected $size;        //Size of the square
    protected $rows;        //Row headers
    protected $cols;        //Col headers
    protected $horizontal;  //Direction of cipher
    
    public function __construct ($alphabet = UPPER_ALPHABET_REDUCED, $rows="12345", $cols="12345", $horizontal = TRUE) {
        parent::__construct ($alphabet, $rows . $cols, TRUE, 0, " ");
        $this->size = (int) sqrt (strlen($alphabet));
        $this->rows = $rows;
        $this->cols = $cols;
        $this->horizontal = $horizontal;
    }
    
    public function sethorizontal ($dir = TRUE) { $this->horizontal = $dir; }
    public function gethorizontal ($dir = TRUE) { return $this->horizontal; }
    public function setsquare ($rows="12345", $cols="12345") { $this->rows = $rows; $this->cols = $cols; $this->validcodes = $rows . $cols; }
    
    public function encode ($msg) {
        
        if (($this->size**2) != strlen($this->alphabet)) return "Alphabet not a square number of characters";
        if ((strlen($this->rows) * strlen($this->cols)) != strlen($this->alphabet)) return "Incorrect number of rows or columns";
        // Encode message
        $s = "";
        for ($i = 0; $i<strlen($msg); $i++) {
            $pos = $this->strpos2 ($this->alphabet, $msg[$i]);
            if ($pos === FALSE) {
                if (!$this->remove) { $s .= $msg[$i]; }
                else { return $s . "Illegal character found"; }
            } else {
                $idx1 = intdiv ($pos, $this->size);
                $idx2 = $pos % $this->size;
                ($this->horizontal) ? $s = $s . $this->rows[$idx1] . $this->cols[$idx2] . $this->sep :
                $s = $s . $this->cols[$idx2] . $this->rows[$idx1] . $this->sep;
            }
        }
        return substr($s,0,-1);
    }
    
    public function decode ($msg) {
        // Decode
        if (($this->size**2) != strlen($this->alphabet)) return "Alphabet not a square number of characters";
        if ((strlen($this->rows) * strlen($this->cols)) != strlen($this->alphabet)) return "Incorrect number of rows or columns";
        $i = 0;
        $s = "";
        while ($i<strlen($msg)) {
            $key = "";
            $cnt = 0;
            while (($cnt<2) && ($i<strlen($msg))) {
                if ((stripos($this->rows, $msg[$i]) !== FALSE) || (stripos($this->cols, $msg[$i]) !== FALSE)) {
                    $cnt++;
                    $key .= $msg[$i];
                } else
                    if ($this->remove) { if ($msg[$i] != $this->sep) return "Illegal character found"; }
                else $s .= $msg[$i];
                $i++;
            }
            if (strlen($key) == 2) {
                if ($this->horizontal) {
                    $rowidx = stripos ($this->rows, $key[0]);
                    $colidx = stripos ($this->cols, $key[1]);
                    $s .= $this->alphabet[$rowidx * $this->size + $colidx];
                } else {
                    $colidx = stripos ($this->cols, $key[0]);
                    $rowidx = stripos ($this->rows, $key[1]);
                    $s .= $this->alphabet[$colidx * $this->size + $rowidx];
                };
            }
        }
        return $s;
    }
    
} // End of polybiuscipher




?>