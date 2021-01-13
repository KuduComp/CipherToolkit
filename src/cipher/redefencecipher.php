<?php

namespace cipher;

class redefencecipher extends cipher {

    protected $nrail = 3;
    protected $startdown = TRUE;
    protected $offset = 0;
    protected $railseq = null;

    public function __construct ($alphabet, $nrail = 3, $offset = 0, $railseq = null) {
        parent::__construct ($alphabet);
        $this->nrail = $nrail;
        $this->setrailseq ($railseq);
        $this->offset = $offset % (2 * $nrail - 3);
    }

    public function setnrail ($nrail) { $this->nrail = $nrail; $this->setrailseq(null); }
    public function getnrail () { return $this->nrail; }
    public function setoffset ($offset) { $this->offset = $offset; }
    public function getoffset () { return $this->offset; }

    public function setrailseq ($railseq = null) {
        if ($railseq == null || $railseq == "")
            for ($i = 0; $i < $this->nrail; $i++) $this->railseq[$i] = $i;
        else {
          switch (gettype($railseq)) {
              case "array"    :
                $this->railseq = $railseq;
                break;
              case "integer"  :
                $s = sprintf("%d", $s);
                for ($i = 0; $i <strlen($s); $i++) $this->railseq[] = $s[$i] - 1;
                break;
              case "string"   :
                $s = $railseq;
                for ($i = 0; $i < strlen($s); $i++) $this->railseq[] = $s[$i] - 1;
                break;
              default         :
                return null;
          }
        }
    }


    public function getrailseq () { return $this->railseq; }

    function encode ($msg) {
        return $this->encoderedefencetransposition ($msg, $this->nrail, $this->offset, $this->railseq);
    }

	function decode ($msg) {
        return $this->decoderedefencetransposition ($msg, $this->nrail, $this->offset, $this->railseq);
    }
}  // class railfencecipher

?>
