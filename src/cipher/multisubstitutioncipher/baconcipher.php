<?php

namespace cipher\multisubstitutioncipher;

// Classic atbash cipher, encoding using reversed alphabet
class baconcipher extends \cipher\multisubstitutioncipher {

    protected $version;
    protected $cA, $cB;

    protected $baconcodelen = 5;
    protected $baconvalidcodes = "AB";
    protected $baconcodev1 = array (
        'a' => 'AAAAA', 'b' => 'AAAAB', 'c' => 'AAABA', 'd' => 'AAABB',
        'e' => 'AABAA', 'f' => 'AABAB', 'g' => 'AABBA', 'h' => 'AABBB',
        'i' => 'ABAAA', 'j' => 'ABAAA', 'k' => 'ABAAB', 'l' => 'ABABA',
        'm' => 'ABABB', 'n' => 'ABBAA', 'o' => 'ABBAB', 'p' => 'ABBBA',
        'q' => 'ABBBB', 'r' => 'BAAAA', 's' => 'BAAAB', 't' => 'BAABA',
        'u' => 'BAABB', 'v' => 'BAABB', 'w' => 'BABAA', 'x' => 'BABAB',
        'y' => 'BABBA', 'z' => 'BABBB');
    protected $baconcodev2 = array (
        'a' => 'AAAAA', 'b' => 'AAAAB', 'c' => 'AAABA', 'd' => 'AAABB',
        'e' => 'AABAA', 'f' => 'AABAB', 'g' => 'AABBA', 'h' => 'AABBB',
        'i' => 'ABAAA', 'j' => 'ABAAB', 'k' => 'ABABA', 'l' => 'ABABB',
        'm' => 'ABBAA', 'n' => 'ABBAB', 'o' => 'ABBBA', 'p' => 'ABBBB',
        'q' => 'BAAAA', 'r' => 'BAAAB', 's' => 'BAABA', 't' => 'BAABB',
        'u' => 'BABAA', 'v' => 'BABAB', 'w' => 'BABBA', 'x' => 'BABBB',
        'y' => 'BBAAA', 'z' => 'BBAAB');

    public function __construct ($a = UPPER_ALPHABET, $version = 1, $cA = 'A', $cB = 'B') {
      $this->baconvalidcodes = 'AB';
      $this->version = $version;
      $this->cA = $cA;
      $this->cB = $cB;
      if ($this->version == 1)
        parent::__Construct ($this->baconcodelen, $this->baconvalidcodes, $this->baconcodev1);
      else
        parent::__Construct ($this->baconcodelen, $this->baconvalidcodes, $this->baconcodev2);
      $this->setsep(' ');
    }

    public function encode ($text) {
      if ($this->version < 1 || $this->version > 2) return "Version must be 1 or 2";
      $msg = parent::encode ($text);
      $msg = str_replace(["A","B"], [$this->cA, $this->cB], $msg);
      return $msg;
    }

    public function decode ($text) {
      if ($this->version < 1 || $this->version > 2) return "Version must be 1 or 2";
      $msg = str_replace([$this->cA, $this->cB], ["A","B"], $text);
      return parent::decode ($msg);
    }

} // End of baconcipher

?>
