<?php

namespace cipher;

class trifidcipher extends cipher{

    public function __Construct ($alphabet="ABCDEFGHIJKLMNOPQRSTUVWXYZ.", $key = "") {
        parent::__Construct ($this->shufflealphabet ($alphabet, $key));
    }

    public function encode ($msg) {
        // Encode message ignore anything that is not in the alphabet
        $s = "";
        // Make three strings for each letter first
        for ($i=0; $i<strlen($msg); $i++) {
            // Calculate square row and column
            $pos = $this->strpos2($this->alphabet, $msg[$i]);
            if ($pos !== FALSE) {
                $square = intdiv ($pos % 9, 3) + 1;
                $row    = intdiv ($pos, 9) + 1;
                $col    = ((($pos % 9) % 3) % 3) + 1;
                $s = $s . $square . $row . $col;
            }
        }

        // Make the new string
        $s = $this->rowtocolumntransposition($s, 3);

        // Take three numbers from the string and find letter
        $s2 = "";
        $cnt = 0;
        for ($i=0; $i<strlen($s); $i+=3) {
            $s2 .= $this->alphabet [($s[$i]-1)*3 + ($s[$i+1]-1)*9 + $s[$i+2] - 1];
            $cnt ++;
        }

        // Return string
        return $s2;
    }

    public function decode ($msg) {

        // Create a string with number_format
        $s = "";
        for ($i=0; $i<strlen($msg); $i++) {
            // Calculate square row and column
            $pos = $this->strpos2($this->alphabet, $msg[$i]);
            if ($pos !== FALSE) {
                $square = intdiv ($pos % 9, 3) + 1;
                $row    = intdiv ($pos, 9) + 1;
                $col    = ((($pos % 9) % 3) % 3) + 1;
                $s = $s . $square . $row . $col;
            }
        }

        // Fractionate message
        $s = $this->rowtocolumntransposition($s, strlen($s) / 3);

        // Translate back
        $s2 = "";
        for ($i=0; $i<strlen($s); $i+=3) {
            $s2 .= $this->alphabet[($s[$i]-1)*3 + ($s[$i+1]-1)*9 + $s[$i+2] - 1];
        }
        //echo $s2,"\n";

        return $s2;
    }
} // Trifid cipher



