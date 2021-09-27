<?php

namespace cipher\multisubstitutioncipher;

class atomtomcipher extends \cipher\multisubstitutioncipher {

    protected $atomtomcodelen = 0;
    protected $atomtomvalidcodes = "/\\";
    protected $atomtomcode = [
      "A" => "/",    "B" => "//",   "C" => "///",  "D" => "////", 
      "E" => "/\\",   "F" => "//\\",  "G" => "///\\", "H" => "/\\\\", 
      "I" => "/\\\\\\", "J" => "\\/",   "K" => "\\\\/",  "L" => "\\\\\\/", 
      "M" => "\\//",  "N" => "\\///", "O" => "/\\/",  "P" => "//\\/", 
      "Q" => "/\\\\/", "R" => "/\\//", "S" => "\\/\\",  "T" => "\\\\/\\", 
      "U" => "\\//\\", "V" => "\\/\\\\", "W" => "//\\\\", "X" => "\\\\//",
      "Y" => "\\/\\/", "Z" => "/\\/\\" 
    ];

    public function __Construct() {
        parent::__Construct ($this->atomtomcodelen, $this->atomtomvalidcodes, $this->atomtomcode);
        $this->setsep(' ');
    }

} // atomtomcipher

?>
