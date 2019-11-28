<?php

namespace cipher;

class amscocipher extends cipher {

	protected $numkey;
	protected $numkeymap;
	protected $keysize  = 0;
	protected $sequence = array (2,1);
	protected $seqsize  = 2;

	public function __construct ($alphabet = UPPER_ALPHABET, $numkey = null) {
		parent::__construct ($alphabet);
		$this->setnumkey ($numkey);
	}

	public function setnumkey ($numkey) {
		$this->numkey = $numkey;
		$this->numkeymap = $this->createtranspositionkey ($numkey);
		$this->keysize = sizeof ($this->numkeymap);
	}

	public function getnumkey () { return $this->numkey; }

	public function encode ($msg = "") {
		
		// Split message in array of 2,1,2,1
		// This should be done row by row starting with the next elemente of the sequence
		// 3,2,1 then 2,1,3 then 1,3,2 and so on
		
	    $a = array();
	    $seqnum  = 0;
	    $startat = 0;
	    while (strlen($msg) > 0) {
	        $seq = ($startat + $seqnum) % $this->seqsize;
	        $a[] = substr($msg, 0, $this->sequence[$seq]);
	        $msg = substr($msg, $this->sequence[$seq]);
	        $seqnum++;
	        if ($seqnum == $this->keysize) { $startat++; $seqnum = 0; };
	    }
	    
	    // Perform columnar transposition
		$res = $this->encodecolumnartransposition ($a, $this->numkeymap);
		return $res;
    }

    public function decode ($msg = "") {
        
        // Create a table with the right number in each cell
        $a = array();
        $seqnum  = 0;
        $startat = 0;
        $cnt     = 0;
        while ($cnt < strlen($msg)) {
            $seq = ($startat + $seqnum) % $this->seqsize;
            $a[$startat][$seqnum] = min(strlen($msg) - $cnt,$this->sequence[$seq]);
            $cnt += $this->sequence[$seq];
            $seqnum++;
            if ($seqnum == $this->keysize) { $startat++; $seqnum = 0; };
        }
		//var_dump($a);
		
        // Fill the matrix tranpose columns on the fly
        for ($c = 0; $c < $this->keysize; $c++) 
			for ($r = 0; $r < $startat; $r++) {
				$col = array_search($c, $this->numkeymap);
				$len = $a[$r][$col];
                $a[$r][$col] = substr($msg, 0, $len);
 				$msg = substr ($msg, $len);
			}
		
		// Read the result
		$s = "";
		for ($r = 0; $r < $startat; $r++)
			for ($c = 0; $c < $this->keysize; $c++) 
				$s .= $a[$r][$c];
		
        return $s;
    }
}

?>
