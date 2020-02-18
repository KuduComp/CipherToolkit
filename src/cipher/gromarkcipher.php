<?php

namespace cipher;

class gromarkcipher extends cipher{

	// Gromark cipher

	// First generate the CT alphabet using columnar transposition of the keyed alphabet
	// Key: ENIGMA (columnar transposition 264351)
	// 426351
	// ENIGMA
	// BCDFHJ
	// etc.

	// pt: abcdefghijklmnopqrstuvwxyz
	// CT: AJRXEBKSYGFPVIDOUMHQWNCLTZ

	// 5-digit primer e.g. 23452 determine shift to right (mod length alphabet)
	// 6th digit is 1st + 5th, 7th digit is 2nd + 6th and so on dropping 10's. (running key)
	 
	// K : 23452 57977 26649 82037023072537978066
	// pt: thereareuptotensubstitutesperletter
	// CT: NFYCKBTIJCNWZYCACJNAYNLQPWWSTWPJQFL

    protected $cipher  = "AJRXEBKSYGFPVIDOUMHQWNCLTZ";
	protected $key 	   = "";
    protected $primer  = "";
    protected $primlen = 0;
	
	public function __construct ($alphabet = UPPER_ALPHABET, $key = "", $primer = "") {
		
		parent::__construct ($alphabet);
		$this->setprimer ($primer);
		$this->setkey($key);
	}
	
	public function setprimer ($primer) {
		
		switch (gettype($primer)) {
		    case "array"    : $this->primer = implode ("", $primer); break;
		    case "integer"  : $this->primer = (string) $primer; break;
		    case "string"   : $this->primer = $primer;
		}
		$this->primlen = strlen($primer);
	}
	
	public function setkey ($key) {
		$this->key = $key;
		$cipher = $this->shufflealphabet ($this->alphabet, $key);
		$this->cipher = $this->encodecolumnartransposition ($cipher, $this->createtranspositionkey($key));
	}
	
	public function getkey () { return $this->key; }
	public function getprimer() { return $this->primer; }
	public function getcipher() { return $this->cipher; }
	
    protected function setrunningkey ($msg) {
       
        // Fill array with offsets
        $primarr = [];
        for ($i = 0; $i < strlen ($msg); $i++) {
			if ($i < $this->primlen) {
				$primarr[$i] = (integer) $this->primer[$i];
			} else {
				$primarr[$i] = ($primarr [$i - $this->primlen] + $primarr [$i + 1 - $this->primlen]) % 10;
			}
		}
		return $primarr;
    }

    public function encode ($msg = "") {
        $primarr = $this->setrunningkey($msg);
        $s = "";
        for ($i = 0; $i < strlen ($msg); $i++)
			$s .= $this->cipher [($this->strpos2($this->alphabet, $msg[$i]) + $primarr[$i]) % strlen($this->alphabet)];
        return $s;
    }

    public function decode ($msg = "") {
        $primarr = $this->setrunningkey($msg);
        $s = "";
        for ($i = 0; $i < strlen ($msg); $i++)
            $s .= $this->alphabet [($this->strpos2($this->cipher, $msg[$i]) + strlen($this->alphabet) - $primarr[$i]) % strlen($this->alphabet)];
        return $s;
    }

} // gromarkcipher

?>