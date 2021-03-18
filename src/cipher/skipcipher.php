<?php

namespace cipher;

class skipcipher extends cipher {

    protected $skip, $start;

    function __construct ($alphabet, $skip = 1, $start = 0) {
      parent::__construct ($alphabet);
      $this->setskip ($skip);
      $this->setstart ($start);
    }

    function setskip ($skip) { $this->skip = $skip; }
    function getskip () { return $this->skip; }
    function setstart ($start) { $this->start = $start; }
    function getstart () { return $this->start; }

    function encode ($msg) {

        // Check if possible ggd(skip, len) == 1
        // Take every n-th letter starting at start
        $b = $this->start - 1;
        $s = "";
        $len = strlen($msg);
        for ($i=0; $i < $len; $i++) {
            $s .= $msg[ ($b + $i * $this->skip) % $len];
        }
        return $s;

    }

    function decode ($msg) {

        // Check if possible ggd(skip, len) == 1
        $b = $this->start - 1;
        $len = strlen($msg);
        $s = array_fill(0, $len, " ");

        for ($i=0; $i < strlen($msg); $i++) {
          $s[ ($b + $i * $this->skip) % $len ] = $msg[$i];
        }
        return implode("", $s);
        
    }

} // class affinecipher

?>
