<?php

namespace cipher;

class myszkowskicipher extends cipher {

    protected $key;

	public function __construct ($alphabet, $key) {
		parent::__construct ($alphabet);
		$this->setkey ($key);
	}

	public function setkey ($key) {
		$this->key = $key;
	}

	public function getkey () { return $this->key; }

	public function encode ($msg) {
		return $this->encodemyszkowskitransposition ($msg, $this->key);
	}

  public function decode ($msg) {
		return $this->decodemyszkowskitransposition ($msg, $this->key);
  }

} // class

?>
