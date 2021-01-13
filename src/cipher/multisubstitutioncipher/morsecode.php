<?php

namespace cipher\multisubstitutioncipher;

class morsecode extends \cipher\multisubstitutioncipher {

    protected $morsecodelen = 0;
    protected $morsevalidcodes = ".-";
    protected $morsecode = array (
        'a' => '.-',   'b' => '-...', 'c' => '-.-.', 'd' => '-..',
        'e' => '.',    'f' => '..-.', 'g' => '--.',  'h' => '....',
        'i' => '..',   'j' => '.---', 'k' => '-.-',  'l' => '.-..',
        'm' => '--',   'n' => '-.',   'o' => '---',  'p' => '.--.',
        'q' => '--.-', 'r' => '.-.',  's' => '...',  't' => '-',
        'u' => '..-',  'v' => '...-', 'w' => '.--',  'x' => '-..-',
        'y' => '-.--', 'z' => '--..',
        '0' => '-----', '1' => '.----', '2' => '..---',
        '3' => '...--', '4' => '....-', '5' => '.....',
        '6' => '-....', '7' => '--...', '8' => '---..',
        '9' => '----.',
        '.' => '.-.-.-', ',' => '--..--', '?' => '..--..',
        '!' => '-.-.--', '-' => '-....-', '/'  => '-..-.',
        ':' => '---...', "'" => '.----.',
        ')' => '-.--.-', ';'  => '-.-.-', '('  => '-.--.',
        '=' => '-....-', '@' => '.--.-.', '&'  => '.-...'
    );

    public function __Construct() {
        parent::__Construct ($this->morsecodelen, $this->morsevalidcodes, $this->morsecode);
        $this->setsep(' ');
    }

    public function encode ($msg) {
		// Morsecode should always have a separator
		if ($this->sep == "") $this->sep = " ";
        return $this->arraysubstitution ($msg, $this->morsecode);
    }

} // End of morsecode

?>
