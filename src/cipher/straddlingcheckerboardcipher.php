<?php

// The Algorithm 
// The key for a straddling checkerboard is a permutation of the alphabet e.g. 'fkmcpdyehbigqrosazlutjnwvx', 
// along with 2 numbers e.g. 3 and 7. A straddling checkerboard is set up something like this (using the key information above):

// 	  0 1 2 3 4 5 6 7 8 9
//    f k m   c p d   y e
// 3: h b i g q r o s a z
// 7: l u t j n w v x    

// The first row is set up with the first eight key letters, leaving two blank spots. It has no row label. 
// The second and third rows are labelled with whichever two digits didn't get a letter in the top row, and then filled out with the rest of the key letters. Since there are 30 slots in our grid, and we missed two letters in the first row, there will end up being two spare in the other rows. It doesn't matter where these spares go, so long as sender and receiver use the same system.

// To encipher, a letter on the top row is simply replaced by the number labelling its column. 
// Letters on the other rows are replaced by their row number, then column number:

// D E F E N  D T  H  E E A  S  T  W  A  L  L  O  F T  H  E C A  S  T  L  E
// 6 9 0 9 74 6 72 30 9 9 38 37 72 75 38 70 70 36 0 72 30 9 4 38 37 72 70 9
// So, DEFEND THE EAST WALL OF THE CASTLE becomes 690974672309938377275387070360723094383772709. 

// Colkey uses a different set instead of 0 to 9
// Printzero prints a leading zero for the first row

namespace cipher;

class straddlingcheckerboardcipher extends cipher {

    protected $key = "";
    protected $sparepos1 = 0;
    protected $sparepos2 = 0;
    protected $board = array();
    protected $colkey = null;
	protected $printzero = FALSE;

    public function __construct ($alphabet, $key, $pos1, $pos2, $colkey=null, $printzero = FALSE) {
        $this->alphabet = $alphabet;
		$this->setboard ($key, $pos1, $pos2, $colkey, $printzero);
    }

    public function setboard ($key, $pos1, $pos2, $colkey, $printzero) {
        $this->key = $key;
		$this->board = array();
        $this->sparepos1 = $pos1;
        $this->sparepos2 = $pos2;
        $this->colkey    = $colkey;
		$this->printzero = $printzero;

        //Generate default colkey
        if ($colkey == null) {
            $this->colkey = array();
            for ($i = 0; $i < 10; $i++) $this->colkey[$i] = $i;
        } else
            $this->colkey = $colkey;

        //Shuffle alphabet with key!
		$s = $this->shufflealphabet ($this->alphabet, $this->key);
		
		//Fill board
		($printzero) ? $format = "%02d" : $format = "%d";
        $idx = 0;
        for ($r=0; $r<3; $r++)
            for ($c = 0; $c <=9; $c++) {
                if (($r == 0) && (($this->colkey[$c] == $pos1) || ($this->colkey[$c] == $pos2))) continue;
                if ($r == 0) $n = $this->colkey[$c];
                if ($r == 1) $n = $pos1 * 10 + $this->colkey[$c];
                if ($r == 2) $n = $pos2 * 10 + $this->colkey[$c];
                if ($idx < strlen($this->alphabet)) $this->board[$s[$idx++]] = sprintf ($format, $n);
            }
    }
   
    public function getboard () { return $this->board; }

    public function encode ($msg) {
        $s = "";
        for ($i = 0; $i < strlen($msg); $i++)
			if (strpos($this->alphabet, $msg[$i]) !== FALSE) $s .= $this->board[$msg[$i]];
        return $s;
    }

    public function decode ($msg) {
        $s = "";
        for ($i = 0; $i < strlen($msg); $i++) {
			$c = $msg[$i];
			if ((($c == (string) $this->sparepos1) || ($c == (string) $this->sparepos2)) || $this->printzero) $c .= $msg[++$i];
			$s .= array_search ($c, $this->board);
        }
        return $s;                           
    }

} // class straddlingcheckboardcipher

?>