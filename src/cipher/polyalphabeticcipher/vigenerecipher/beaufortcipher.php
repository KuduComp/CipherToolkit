<?php

namespace cipher\polyalphabeticcipher\vigenerecipher;

class beaufortcipher extends \cipher\polyalphabeticcipher\vigenerecipher {

  public function settableau ($keyiterator="", $keycipher="", $keyplain="", $keycol="") {

          $this->alphabet    = strrev ($this->alphabet);
          parent::settableau ($keyiterator, $keycipher, $keyplain, $keycol);
          $this->alphabet    = strrev ($this->alphabet);
          
  }
  
}

?>
