<?php 

namespace cipher;

// Polygraphic substitutions
class playfaircipher extends cipher {
    
    // Playfield takes two characters from input and replaces them with two others
    // It generates a square from the alphabet using a keyword
    // For the first letter it finds (r1, c1) and (r2, c2)
    // It returns the letter at r1,c2 and r2, c1
    // If c1=c2 then r1 = r1+1 and r2 = r2 + 1 (mod size of the square), same or r1 = r2
    
    protected $size = 0;
    protected $insertchar = "X";
    
    public function __construct ($alphabet = UPPER_ALPHABET_REDUCED, $key) {
        
        // Generate alphabet
        $h = $this->shufflealphabet ($alphabet, $key);
        parent::__construct ($h);
        $this->size = (integer) sqrt(strlen($h));
    }
    
    public function setinsertchar ($c) { $this->insertchar = $c; }
    public function getinsertchar ($c) { return $this->insertchar; }
    
    public function encode ($msg) {
        
        // Checks
        if (strlen($this->alphabet) != ($this->size**2)) return "Not a square number of characters in the alphabet";
        
        //Process message
        $s = "";
        for ($i = 0; $i < strlen($msg); $i +=2) {
            if ($msg[$i] == $msg[$i+1]) {
                // Two letters are the same insert an X between them
                $msg = substr($msg, 0, $i) . $this->insertchar . substr($msg,$i);
            }
            $pos1 = $this->strpos2 ($this->alphabet, $msg[$i]);
            $pos2 = $this->strpos2 ($this->alphabet, $msg[$i+1]);
            if (($pos1 === FALSE) || ($pos2 === FALSE)) return $s .= " Illegal character found: " . $msg[$i];
            $row1 = intdiv ($pos1, $this->size);
            $col1 = $pos1 % $this->size;
            $row2 = intdiv ($pos2, $this->size);
            $col2 = $pos2 % $this->size;
            if ($col1 == $col2) { $row1 = ($row1 + 1) % $this->size; $row2 = ($row2 + 1) % $this->size; }
            if ($row1 == $row2) { $col1 = ($col1 + 1) % $this->size; $col2 = ($col2 + 1) % $this->size; }
            $s .= $this->alphabet[$row1 * $this->size + $col2];
            $s .= $this->alphabet[$row2 * $this->size + $col1];
        }
        return $s;
    }
    
    public function decode ($msg) {
        
        // Checks
        if (strlen($this->alphabet) != ($this->size**2)) return "Not a square number of characters in the alphabet";
        
        //Process message
        $s = "";
        for ($i = 0; $i < strlen($msg); $i +=2) {
            if ($msg[$i] == $msg[$i+1]) {
                // Two letters are the same insert an X between them
                $msg = substr($msg, 0, $i) . $this->insertchar . substr($msg,$i);
            }
            $pos1 = $this->strpos2 ($this->alphabet, $msg[$i]);
            $pos2 = $this->strpos2 ($this->alphabet, $msg[$i+1]);
            if (($pos1 === FALSE) || ($pos2 === FALSE)) return $s .= " Illegal character found: " . $msg[$i];
            $row1 = intdiv ($pos1, $this->size);
            $col1 = $pos1 % $this->size;
            $row2 = intdiv ($pos2, $this->size);
            $col2 = $pos2 % $this->size;
            if ($col1 == $col2) {
                ($row1 == 0) ? $row1 = $this->size : $row1 = $row1 - 1;
                ($row2 == 0) ? $row2 = $this->size : $row2 = $row2 - 1;
            }
            if ($row1 == $row2) {
                ($col1 == 0) ? $col1 = $this->size : $col1 = $col1 - 1;
                ($col2 == 0) ? $col2 = $this->size : $col2 = $col2 - 1;
            }
            $s .= $this->alphabet[$row1 * $this->size + $col2];
            $s .= $this->alphabet[$row2 * $this->size + $col1];
        }
        return $s;
        
    }
    
} // End of playfieldcipher

?>