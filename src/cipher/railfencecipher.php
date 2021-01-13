<?php

namespace cipher;

class railfencecipher extends cipher {

    protected $nrail = 3;
    protected $offset = 0;

    public function __construct ($alphabet, $nrail = 3, $offset = 0) {
        parent::__construct ($alphabet);
        $this->nrail = $nrail;
        $this->offset = $offset % (2 * $nrail - 3);
    }

    public function setnrail ($nrail) { $this->nrail = $nrail; }
    public function getnrail () { return $this->nrail; }
    public function setoffset ($offset) { $this->offset = $offset; }
    public function getoffset () { return $this->offset; }

    function encode ($msg) {
		    for ($i = 0; $i < $this->nrail; $i++) $railseq[$i] = $i;
        return $this->encoderedefencetransposition ($msg, $this->nrail, $this->offset, $railseq);
    }

	function decode ($msg) {
		  for ($i = 0; $i < $this->nrail; $i++) $railseq[$i] = $i;
      return $this->decoderedefencetransposition ($msg, $this->nrail, $this->offset, $railseq);
  }
}  // class railfencecipher

?>
