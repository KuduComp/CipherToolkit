<?php  

namespace cipher;

// Classic atbash cipher, encoding using reversed alphabet
class newscipher extends cipher {

    protected $alphabet;
    protected $size;
    
    public function __construct ($a = UPPER_ALPHABET_REDUCED, $size = 5) {
        parent::__Construct ($a);
        $this->size = $size;
    }
    
    public function decode ($t = "") {

      $t = strtoupper($t);
      preg_match_all('(.(NE|NW|SE|SW|N|E|S|W))', $t, $chars);
          
      $s = "";

      foreach ($chars[0] as $c) {
            
        // FInd character in alphabet
        $idx = strpos ($this->alphabet, $c[0]);
        if ($idx !== FALSE) {
        
          $col = $idx % 5;
          $row = floor($idx/5);
          
          switch (substr($c,1,999)) {
            
            case 'N' :
              $row--;
              break;
            case 'S' :
              $row++;
              break;
            case 'E' :
              $col++;
              break;
            case 'W' :
              $col--;
              break;
            case 'NE' :
              $row--;
              $col++;
              break;
            case 'NW' :
              $row--;
              $col--;
              break;
            case 'SE' :
              $row++;
              $col++;
              break;
            case 'SW' :
              $row++;
              $col--;
              break;
          }
          
          if ($row == $this->size) $row = 0;
          if ($row == -1) $row = $this->size-1;
          if ($col == $this->size) $col = 0;
          if ($col == -1) $col = $this->size-1;
          $s .= $this->alphabet[(int)$row*$this->size + $col];
        }
      }
      return $s; 

    }
    
    public function encode ($t) {

      $chars = str_split(strtoupper($t));
        
      $s = "";
      
      foreach ($chars as $c) {
            
        // FInd character in alphabet
        $idx = strpos ($this->alphabet, $c[0]);
        $nesw = [ 'N', 'S', 'E', 'W', 'NE', 'NW', 'SE', 'SW'];
        
        if ($idx !== FALSE) {
        
          $col = $idx % 5;
          $row = floor($idx/5);
          $dir = random_int(0,7);
    
          switch ($dir) {
            
            case 0 :
              $row++;
              break;
            case 1 :
              $row--;
              break;
            case 2 :
              $col--;
              break;
            case 3 :
              $col++;
              break;
            case 4 :
              $row++;
              $col--;
              break;
            case 5 :
              $row++;
              $col++;
              break;
            case 6 :
              $row--;
              $col--;
              break;
            case 7 :
              $row--;
              $col++;
              break;
          }
          
          if ($row == $this->size) $row = 0;
          if ($row == -1) $row = $this->size-1;
          if ($col == $this->size) $col = 0;
          if ($col == -1) $col = $this->size-1;
          
          $s .= $this->alphabet[(int)$row*$this->size + $col] . $nesw[$dir];
        }
      }
      return $s; 
  
    }
    
} // End of newscipher

?>