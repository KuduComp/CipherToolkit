<?php 

namespace cipher\multisubstitutioncipher;

class morsecode extends \cipher\multisubstitutioncipher {
    
    protected $morsecodelen = 0;
    protected $morsevalidcodes = ".-";
    protected $morsecode = array (
        '.-'   => 'a', '-...' => 'b', '-.-.' => 'c', '-..'  => 'd',
        '.'    => 'e', '..-.' => 'f', '--.'  => 'g', '....' => 'h',
        '..'   => 'i', '.---' => 'j', '-.-'  => 'k', '.-..' => 'l',
        '--'   => 'm', '-.'   => 'n', '---'  => 'o', '.--.' => 'p',
        '--.-' => 'q', '.-.'  => 'r', '...'  => 's', '-'    => 't',
        '..-'  => 'u', '...-' => 'v', '.--'  => 'w', '-..-' => 'x',
        '-.--' => 'y', '--..' => 'z',
        '-----' => '0', '.----' => '1', '..---' => '2',
        '...--' => '3', '....-' => '4', '.....' => '5',
        '-....' => '6', '--...' => '7', '---..' => '8',
        '----.' => '9',
        '.-.-.-' => '.', '--..--' => ',', '..--..' => '?',
        '-.-.--' => '!', '-....-' => '-', '-..-.'  => '/',
        '---...' => ':', '.----.' => "'", '-....-' => '-',
        '-.--.-' => ')', '-.-.-'  => ';', '-.--.'  => '(',
        '-....-' => '=', '.--.-.' => '@', '.-...'  => '&'
    );
    
    public function __Construct() {
        parent::__Construct ($this->morsecodelen, $this->morsevalidcodes, $this->morsecode);
        $this->setsep('/');
    }
    
    public function encode ($msg) {
        // encode overruled because separator should be added after every character
        $s2 = "";
        if ($this->sep == "") $this->sep = "/";
        for ($i=0; $i<strlen($msg); $i++) {
            if (array_search (strtolower($msg[$i]), $this->codetable, TRUE) !== FALSE) {
                $s2 .= array_search (strtolower($msg[$i]), $this->codetable, TRUE);
                if ($i < (strlen($msg)-1)) $s2 .= $this->sep;
            } else
                if (!$this->remove) $s2 .= $msg[$i];
        }
        return $s2;
    }
    
} // End of morsecode

?>

