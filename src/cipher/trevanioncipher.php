<?php  

namespace cipher;

// Classic atbash cipher, encoding using reversed alphabet
class trevanioncipher extends cipher {

    protected $signalchars = "";
    protected $interval = 0;
    
    public function __construct ($a = UPPER_ALPHABET, $signalchars = ".,;:?!", $interval = 0) {
        parent::__Construct ($a);
        $this->signalchars = $signalchars;
        $this->interval = $interval;
    }
    
    public function encode ($text) {
        return "Mo encode available, be creative";
    }
    
    public function decode ($text) {
      $s = "";

      for ($i = 0; $i < strlen($text); $i++) {
        
        if (stripos($this->signalchars, $text[$i]) !== false) {
          $cnt = 0;
          while ($cnt < $this->interval && $i < strlen($text)) {
            if (stripos($this->alphabet, $text[$i++]) !== false) $cnt++;
          }
          if ($cnt == $this->interval) $s .= $text[--$i];
        }
      }

      return $s;
    }
    
} // End of trevanioncipher

?>