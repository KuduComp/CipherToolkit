<?php

namespace cipher;

// ROT123
// First postion shifts 1, second 2, and so on
// Numbers are shifted separate from letters
// All other characters are not encoded.

class rot123cipher extends cipher {

  private $key = "";
  private $numbers = "0123456789";

	function __construct ($alphabet = UPPER_ALPHABET, $key = "") {
		parent::__construct ($alphabet);
    $this->setkey($key);
	}

  function setkey($key) { $this->key = $key; }
  function getkey() { return $this-> key; }

	function encode ($text = "") {
    $msg = "";
    $cnt = 1;
    foreach (str_split($text) as $c) {
      $pos = stripos($this->alphabet, $c);
      if ($pos === false) {
        $pos = strpos($this->numbers, $c);
        if ($pos === false) {
          $msg .= $c;
          continue;
        }
        $msg .= $this->numbers[ ($pos + $cnt++) % 10];
        continue;
      }
      $msg .= $this->alphabet[ ($pos + $cnt++) % strlen($this->alphabet)];
    }
    return $msg;
	}

	function decode ($text = "") {
    $numbers = "0123456789";
    $msg = "";
    $cnt = 1;
    foreach (str_split($text) as $c) {
      $pos = stripos($this->alphabet, $c);
      if ($pos === false) {
        $pos = strpos($this->numbers, $c);
        if ($pos === false) {
          $msg .= $c;
          continue;
        }
        $msg .= $numbers[ ($pos + 10 - $cnt++) % 10];
        continue;
      }
      $msg .= $this->alphabet[ ($pos + strlen($this->alphabet) - $cnt++) % strlen($this->alphabet)];
    }
    return $msg;  
	}

} // rot123cipher

?>
