<?php

namespace cipher;

class periodicgromarkcipher extends cipher{

	// Periodic Gromark cipher

	// First generate the CT alphabet using columnar transposition of the keyed alphabet
	// Key: ENIGMA (columnar transposition 264351, also used as primer
	// 426351
	// ENIGMA
	// BCDFHJ
	// etc.

	// pt: abcdefghijklmnopqrstuvwxyz
	// CT: AJRXEBKSYGFPVIDOUMHQWNCLTZ
	//     0   4    etc used as additional offset on subsequent blocks

	// K : 23452 57977 26649 82037023072537978066
	// pt: thereareuptotensubstitutesperletter
	// CT: NFYCKBTIJCNWZYCACJNAYNLQPWWSTWPJQFL

    protected $cipher  = "AJRXEBKSYGFPVIDOUMHQWNCLTZ";
	protected $key 	   = "";
    protected $primer  = "";
    protected $primlen = 0;
	protected $addoffsets = [];
	
	public function __construct ($alphabet = UPPER_ALPHABET, $key = "", $primer = "") {
		
		parent::__construct ($alphabet);
		$this->setkey($key);
	}
	
	
	public function setkey ($key) {
		
		// Create the alphabet
		$this->key = $key;
		$cipher = $this->shufflealphabet ($this->alphabet, $key);
		$this->cipher = $this->encodecolumnartransposition ($cipher, $this->createtranspositionkey($key));
		
		// Primer is numeric version of key, starting with 1
		$tmp = $this->createtranspositionkey($key);
		for ($i = 0; $i < sizeof($tmp); $i++) $tmp[$i]++;
		$this->primer = implode("",$tmp);
		$this->primlen = strlen($this->primer);
		
		// Fill array with additional offsets
		$this->addoffsets = [];
        for ($i = 0; $i < $this->primlen; $i++) $this->addoffsets[$i] = stripos ($this->cipher, $this->key[$i]);
	}
	
	public function getkey () { return $this->key; }
	public function getcipher() { return $this->cipher; }
	
    protected function setrunningkey ($msg) {
       
        // Fill array with offsets
        $primarr = [];
		$primarr2 = [];
        for ($i = 0; $i < strlen ($msg); $i++) {
			if ($i < $this->primlen) {
				$primarr[$i] = (integer) $this->primer[$i];
			} else {
				$primarr[$i] = ($primarr [$i - $this->primlen] + $primarr [$i + 1 - $this->primlen]) % 10;
			}
			$primarr2[$i] = $primarr[$i] + $this->addoffsets[ intdiv($i, $this->primlen) % $this->primlen];
		}
		return $primarr2;
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
            $s .= $this->alphabet [($this->strpos2($this->cipher, $msg[$i]) + 2*strlen($this->alphabet) - $primarr[$i]) % strlen($this->alphabet)];
        return $s;
    }

} // periodicgromarkcipher

?>